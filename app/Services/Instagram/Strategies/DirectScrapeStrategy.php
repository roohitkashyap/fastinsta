<?php

namespace App\Services\Instagram\Strategies;

use App\Services\Instagram\Contracts\ExtractionStrategy;
use App\Services\Instagram\DTOs\MediaResult;
use App\Services\Instagram\DTOs\MediaItem;
use App\Models\Proxy;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class DirectScrapeStrategy implements ExtractionStrategy
{
    protected Client $client;
    protected ?Proxy $proxy = null;

    protected array $headers = [
        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
        'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8',
        'Accept-Language' => 'en-US,en;q=0.9',
        'Accept-Encoding' => 'gzip, deflate', // Removed 'br' (brotli) - not supported by cURL on Windows
        'X-IG-App-ID' => '936619743392459',
        'X-Requested-With' => 'XMLHttpRequest',
        'Sec-Fetch-Dest' => 'document',
        'Sec-Fetch-Mode' => 'navigate',
        'Sec-Fetch-Site' => 'none',
        'Sec-Fetch-User' => '?1',
        'Cache-Control' => 'max-age=0',
        'Referer' => 'https://www.instagram.com/',
    ];

    public function __construct()
    {
        $config = [
            'timeout' => 30,
            'connect_timeout' => 10,
            'headers' => $this->headers,
            'verify' => false,
        ];

        // Try to get a proxy
        $this->proxy = Proxy::getNext();
        if ($this->proxy) {
            $config = array_merge($config, $this->proxy->toGuzzleConfig());
            $this->proxy->markUsed();
        }

        $this->client = new Client($config);
    }

    public function getName(): string
    {
        return 'direct_scrape';
    }

    public function supports(string $mediaType): bool
    {
        // Supports all except stories (need login)
        return in_array($mediaType, ['post', 'reel', 'igtv', 'carousel']);
    }

    public function extract(string $shortcode, string $mediaType): MediaResult
    {
        $result = new MediaResult();
        $result->strategyUsed = $this->getName();

        try {
            // Try embed endpoint first (more reliable)
            $embedData = $this->fetchEmbed($shortcode);
            
            if ($embedData) {
                return $this->parseEmbedData($embedData, $shortcode, $mediaType);
            }

            // Fallback to HTML scraping
            $htmlData = $this->fetchHtml($shortcode);
            
            if ($htmlData) {
                return $this->parseHtmlData($htmlData, $shortcode, $mediaType);
            }

            throw new \Exception('No data found');

        } catch (RequestException $e) {
            $this->handleProxyFailure();
            
            $result->error = 'Request failed: ' . $e->getMessage();
            Log::warning('DirectScrape failed', [
                'shortcode' => $shortcode,
                'error' => $e->getMessage()
            ]);
        } catch (\Exception $e) {
            $this->handleProxyFailure();
            
            $result->error = $e->getMessage();
            Log::warning('DirectScrape error', [
                'shortcode' => $shortcode,
                'error' => $e->getMessage()
            ]);
        }

        return $result;
    }

    protected function fetchEmbed(string $shortcode): ?array
    {
        $url = "https://www.instagram.com/p/{$shortcode}/embed/captioned/";

        try {
            $response = $this->client->get($url);
            $html = (string) $response->getBody();

            // Extract JSON from embed page
            if (preg_match('/window\.__additionalDataLoaded\s*\(\s*[\'"]extra[\'"]\s*,\s*(\{.+?\})\s*\)\s*;/s', $html, $matches)) {
                return json_decode($matches[1], true);
            }

            // Alternative pattern
            if (preg_match('/"gql_data"\s*:\s*(\{.+?\})\s*,\s*"config"/s', $html, $matches)) {
                return json_decode($matches[1], true);
            }

        } catch (\Exception $e) {
            Log::debug('Embed fetch failed', ['error' => $e->getMessage()]);
        }

        return null;
    }

    protected function fetchHtml(string $shortcode): ?array
    {
        $url = "https://www.instagram.com/p/{$shortcode}/?__a=1&__d=dis";

        try {
            $response = $this->client->get($url);
            $data = json_decode((string) $response->getBody(), true);

            if (isset($data['graphql']['shortcode_media']) || isset($data['items'])) {
                return $data;
            }

        } catch (\Exception $e) {
            Log::debug('HTML fetch failed', ['error' => $e->getMessage()]);
        }

        return null;
    }

    protected function parseEmbedData(array $data, string $shortcode, string $mediaType): MediaResult
    {
        $result = new MediaResult();
        $result->success = true;
        $result->strategyUsed = $this->getName();
        $result->shortcode = $shortcode;
        $result->mediaType = $mediaType;

        // Navigate to media data
        $media = $data['shortcode_media'] ?? $data['graphql']['shortcode_media'] ?? null;

        if (!$media) {
            $result->success = false;
            $result->error = 'Could not parse media data';
            return $result;
        }

        $result->caption = $media['edge_media_to_caption']['edges'][0]['node']['text'] ?? '';
        $result->username = $media['owner']['username'] ?? '';
        $result->thumbnail = $media['display_url'] ?? $media['thumbnail_src'] ?? '';

        // Check if carousel
        if (isset($media['edge_sidecar_to_children']['edges'])) {
            $result->mediaType = 'carousel';
            foreach ($media['edge_sidecar_to_children']['edges'] as $edge) {
                $item = $this->parseMediaNode($edge['node']);
                if ($item) {
                    $result->media[] = $item;
                }
            }
        } else {
            // Single media
            $item = $this->parseMediaNode($media);
            if ($item) {
                $result->media[] = $item;
            }
        }

        $this->handleProxySuccess();

        return $result;
    }

    protected function parseHtmlData(array $data, string $shortcode, string $mediaType): MediaResult
    {
        $result = new MediaResult();
        $result->success = true;
        $result->strategyUsed = $this->getName();
        $result->shortcode = $shortcode;
        $result->mediaType = $mediaType;

        $items = $data['items'] ?? [];
        
        foreach ($items as $item) {
            if (isset($item['video_versions'])) {
                $mediaItem = new MediaItem();
                $mediaItem->type = 'video';
                $mediaItem->url = $item['video_versions'][0]['url'] ?? '';
                $mediaItem->thumbnail = $item['image_versions2']['candidates'][0]['url'] ?? '';
                $mediaItem->width = $item['video_versions'][0]['width'] ?? 0;
                $mediaItem->height = $item['video_versions'][0]['height'] ?? 0;
                $result->media[] = $mediaItem;
            } elseif (isset($item['image_versions2'])) {
                $mediaItem = new MediaItem();
                $mediaItem->type = 'image';
                $mediaItem->url = $item['image_versions2']['candidates'][0]['url'] ?? '';
                $mediaItem->thumbnail = $mediaItem->url;
                $mediaItem->width = $item['image_versions2']['candidates'][0]['width'] ?? 0;
                $mediaItem->height = $item['image_versions2']['candidates'][0]['height'] ?? 0;
                $result->media[] = $mediaItem;
            }

            $result->caption = $item['caption']['text'] ?? '';
            $result->username = $item['user']['username'] ?? '';
        }

        $this->handleProxySuccess();

        return $result;
    }

    protected function parseMediaNode(array $node): ?MediaItem
    {
        $item = new MediaItem();

        if ($node['is_video'] ?? false) {
            $item->type = 'video';
            $item->url = $node['video_url'] ?? '';
            $item->thumbnail = $node['display_url'] ?? '';
            $item->duration = $node['video_duration'] ?? null;
        } else {
            $item->type = 'image';
            $item->url = $node['display_url'] ?? $node['display_resources'][0]['src'] ?? '';
            $item->thumbnail = $item->url;
        }

        $item->width = $node['dimensions']['width'] ?? 0;
        $item->height = $node['dimensions']['height'] ?? 0;

        return !empty($item->url) ? $item : null;
    }

    protected function handleProxySuccess(): void
    {
        if ($this->proxy) {
            $this->proxy->recordSuccess();
        }
    }

    protected function handleProxyFailure(): void
    {
        if ($this->proxy) {
            $this->proxy->recordFailure();
        }
    }
}
