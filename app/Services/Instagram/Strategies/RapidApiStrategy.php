<?php

namespace App\Services\Instagram\Strategies;

use App\Services\Instagram\Contracts\ExtractionStrategy;
use App\Services\Instagram\DTOs\MediaResult;
use App\Services\Instagram\DTOs\MediaItem;
use App\Models\Setting;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

/**
 * Instagram Scraper Stable API from RapidAPI
 * https://rapidapi.com/social-starter-api-social-starter-api-default/api/instagram-scraper-stable-api
 */
class RapidApiStrategy implements ExtractionStrategy
{
    protected Client $client;
    protected string $apiKey;
    protected string $apiHost;

    public function __construct()
    {
        $this->apiKey = env('RAPIDAPI_KEY', '');
        $this->apiHost = env('RAPIDAPI_HOST', 'instagram-scraper-stable-api.p.rapidapi.com');

        $this->client = new Client([
            'timeout' => 30,
            'connect_timeout' => 15,
            'verify' => false,
        ]);
    }

    public function getName(): string
    {
        return 'rapidapi';
    }

    public function supports(string $mediaType): bool
    {
        return in_array($mediaType, ['post', 'reel', 'story', 'igtv', 'carousel']);
    }

    public function extract(string $shortcode, string $mediaType): MediaResult
    {
        $result = new MediaResult();
        $result->strategyUsed = $this->getName();
        $result->shortcode = $shortcode;
        $result->mediaType = $mediaType;

        if (empty($this->apiKey)) {
            $result->error = 'RapidAPI key not configured';
            Log::warning('RapidAPI key not configured');
            return $result;
        }

        try {
            // Build Instagram URL based on media type
            $instagramUrl = $this->buildInstagramUrl($shortcode, $mediaType);
            
            Log::info('RapidAPI request', [
                'shortcode' => $shortcode,
                'type' => $mediaType,
                'url' => $instagramUrl
            ]);

            // Call the Instagram Scraper Stable API
            $response = $this->client->post("https://{$this->apiHost}/get_post_info_by_url.php", [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'X-RapidAPI-Key' => $this->apiKey,
                    'X-RapidAPI-Host' => $this->apiHost,
                ],
                'form_params' => [
                    'url' => $instagramUrl,
                ],
            ]);

            $data = json_decode((string) $response->getBody(), true);
            
            Log::debug('RapidAPI response', [
                'has_data' => !empty($data),
                'keys' => is_array($data) ? array_keys($data) : 'not_array'
            ]);

            return $this->parseResponse($data, $shortcode, $mediaType);

        } catch (RequestException $e) {
            $result->error = 'API request failed: ' . $e->getMessage();
            Log::error('RapidAPI request failed', [
                'error' => $e->getMessage(),
                'response' => $e->hasResponse() ? (string)$e->getResponse()->getBody() : null
            ]);
        } catch (\Exception $e) {
            $result->error = 'Extraction failed: ' . $e->getMessage();
            Log::error('RapidAPI extraction failed', ['error' => $e->getMessage()]);
        }

        return $result;
    }

    protected function buildInstagramUrl(string $shortcode, string $mediaType): string
    {
        switch ($mediaType) {
            case 'reel':
                return "https://www.instagram.com/reel/{$shortcode}/";
            case 'igtv':
                return "https://www.instagram.com/tv/{$shortcode}/";
            default:
                return "https://www.instagram.com/p/{$shortcode}/";
        }
    }

    protected function parseResponse(array $data, string $shortcode, string $mediaType): MediaResult
    {
        $result = new MediaResult();
        $result->strategyUsed = $this->getName();
        $result->shortcode = $shortcode;
        $result->mediaType = $mediaType;

        // Check for error responses
        if (isset($data['error']) || isset($data['message'])) {
            $result->error = $data['error'] ?? $data['message'] ?? 'Unknown API error';
            return $result;
        }

        // The API may return data in different formats
        $mediaData = $data['data'] ?? $data['graphql']['shortcode_media'] ?? $data['items'][0] ?? $data;

        // Extract caption
        $result->caption = $mediaData['caption']['text'] ?? 
                          $mediaData['edge_media_to_caption']['edges'][0]['node']['text'] ?? 
                          $mediaData['caption'] ?? '';
        
        // Extract username
        $result->username = $mediaData['user']['username'] ?? 
                           $mediaData['owner']['username'] ?? '';
        
        // Extract thumbnail
        $result->thumbnail = $mediaData['thumbnail_url'] ?? 
                            $mediaData['display_url'] ?? 
                            $mediaData['image_versions2']['candidates'][0]['url'] ?? '';

        // Try different response formats
        $media = [];

        // Format 1: video_url / display_url directly
        if (isset($mediaData['video_url'])) {
            $item = new MediaItem();
            $item->type = 'video';
            $item->url = $mediaData['video_url'];
            $item->thumbnail = $result->thumbnail;
            $item->width = $mediaData['dimensions']['width'] ?? 0;
            $item->height = $mediaData['dimensions']['height'] ?? 0;
            $media[] = $item;
        }

        // Format 2: video_versions array
        if (isset($mediaData['video_versions']) && is_array($mediaData['video_versions'])) {
            $item = new MediaItem();
            $item->type = 'video';
            $item->url = $mediaData['video_versions'][0]['url'] ?? '';
            $item->thumbnail = $mediaData['image_versions2']['candidates'][0]['url'] ?? $result->thumbnail;
            $item->width = $mediaData['video_versions'][0]['width'] ?? 0;
            $item->height = $mediaData['video_versions'][0]['height'] ?? 0;
            if (!empty($item->url)) {
                $media[] = $item;
            }
        }

        // Format 3: Carousel media
        if (isset($mediaData['carousel_media']) || isset($mediaData['edge_sidecar_to_children'])) {
            $result->mediaType = 'carousel';
            $carouselItems = $mediaData['carousel_media'] ?? 
                            $mediaData['edge_sidecar_to_children']['edges'] ?? [];
            
            foreach ($carouselItems as $carouselItem) {
                $node = $carouselItem['node'] ?? $carouselItem;
                $item = $this->parseMediaNode($node);
                if ($item) {
                    $media[] = $item;
                }
            }
        }

        // Format 4: Single image (if not video)
        if (empty($media) && isset($mediaData['display_url'])) {
            $item = new MediaItem();
            $item->type = ($mediaData['is_video'] ?? false) ? 'video' : 'image';
            $item->url = $mediaData['display_url'];
            $item->thumbnail = $item->url;
            $item->width = $mediaData['dimensions']['width'] ?? 0;
            $item->height = $mediaData['dimensions']['height'] ?? 0;
            $media[] = $item;
        }

        // Format 5: image_versions2
        if (empty($media) && isset($mediaData['image_versions2']['candidates'])) {
            $item = new MediaItem();
            $item->type = 'image';
            $item->url = $mediaData['image_versions2']['candidates'][0]['url'];
            $item->thumbnail = $item->url;
            $item->width = $mediaData['image_versions2']['candidates'][0]['width'] ?? 0;
            $item->height = $mediaData['image_versions2']['candidates'][0]['height'] ?? 0;
            $media[] = $item;
        }

        // Check if we found any media
        if (!empty($media)) {
            $result->success = true;
            $result->media = $media;
            Log::info('RapidAPI extraction success', ['media_count' => count($media)]);
        } else {
            $result->error = 'No downloadable media found in API response';
            Log::warning('RapidAPI: No media found', ['response_keys' => array_keys($mediaData)]);
        }

        return $result;
    }

    protected function parseMediaNode(array $node): ?MediaItem
    {
        $item = new MediaItem();

        $isVideo = ($node['media_type'] ?? 0) == 2 || 
                   ($node['is_video'] ?? false) || 
                   isset($node['video_url']) ||
                   isset($node['video_versions']);

        if ($isVideo) {
            $item->type = 'video';
            $item->url = $node['video_url'] ?? 
                        $node['video_versions'][0]['url'] ?? '';
            $item->thumbnail = $node['thumbnail_url'] ?? 
                              $node['display_url'] ?? 
                              $node['image_versions2']['candidates'][0]['url'] ?? '';
            $item->duration = $node['video_duration'] ?? null;
        } else {
            $item->type = 'image';
            $item->url = $node['display_url'] ?? 
                        $node['image_versions2']['candidates'][0]['url'] ?? '';
            $item->thumbnail = $item->url;
        }

        $item->width = $node['original_width'] ?? 
                      $node['dimensions']['width'] ?? 0;
        $item->height = $node['original_height'] ?? 
                       $node['dimensions']['height'] ?? 0;

        return !empty($item->url) ? $item : null;
    }
}
