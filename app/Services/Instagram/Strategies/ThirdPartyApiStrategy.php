<?php

namespace App\Services\Instagram\Strategies;

use App\Services\Instagram\Contracts\ExtractionStrategy;
use App\Services\Instagram\DTOs\MediaResult;
use App\Services\Instagram\DTOs\MediaItem;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

/**
 * Uses free third-party services that scrape Instagram
 * These services have their own anti-detection mechanisms
 */
class ThirdPartyApiStrategy implements ExtractionStrategy
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 30,
            'connect_timeout' => 15,
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'Accept-Language' => 'en-US,en;q=0.9',
                'Accept-Encoding' => 'gzip, deflate', // NO brotli
            ],
            'verify' => false,
        ]);
    }

    public function getName(): string
    {
        return 'third_party_api';
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

        // Build full Instagram URL
        $instagramUrl = $this->buildInstagramUrl($shortcode, $mediaType);

        // Try multiple services
        $services = [
            'sssinstagram' => fn() => $this->trySssInstagram($instagramUrl),
            'fastdl' => fn() => $this->tryFastDl($instagramUrl),
            'inflact' => fn() => $this->tryInflact($shortcode),
        ];

        foreach ($services as $name => $fetchMethod) {
            try {
                Log::debug("Trying third-party service", ['service' => $name, 'shortcode' => $shortcode]);
                
                $media = $fetchMethod();
                
                if (!empty($media)) {
                    $result->success = true;
                    $result->media = $media;
                    
                    Log::info("Third-party API success", [
                        'service' => $name,
                        'media_count' => count($media)
                    ]);
                    
                    return $result;
                }
            } catch (\Exception $e) {
                Log::debug("Third-party service failed", [
                    'service' => $name,
                    'error' => $e->getMessage()
                ]);
                continue;
            }
        }

        $result->error = 'All third-party APIs failed';
        return $result;
    }

    protected function buildInstagramUrl(string $shortcode, string $mediaType): string
    {
        switch ($mediaType) {
            case 'reel':
                return "https://www.instagram.com/reel/{$shortcode}/";
            default:
                return "https://www.instagram.com/p/{$shortcode}/";
        }
    }

    /**
     * SSS Instagram API
     */
    protected function trySssInstagram(string $url): array
    {
        $response = $this->client->post('https://sssinstagram.com/api/v1/download', [
            'headers' => [
                'Origin' => 'https://sssinstagram.com',
                'Referer' => 'https://sssinstagram.com/',
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'form_params' => [
                'url' => $url,
            ],
        ]);

        $data = json_decode((string) $response->getBody(), true);
        $media = [];

        if (!empty($data['video'])) {
            $item = new MediaItem();
            $item->type = 'video';
            $item->url = $data['video'];
            $item->thumbnail = $data['thumbnail'] ?? $data['video'];
            $media[] = $item;
        }

        if (!empty($data['image'])) {
            $item = new MediaItem();
            $item->type = 'image';
            $item->url = $data['image'];
            $item->thumbnail = $data['image'];
            $media[] = $item;
        }

        // Handle multiple items
        if (!empty($data['items'])) {
            foreach ($data['items'] as $item) {
                $mediaItem = new MediaItem();
                $mediaItem->type = isset($item['video']) ? 'video' : 'image';
                $mediaItem->url = $item['video'] ?? $item['image'] ?? '';
                $mediaItem->thumbnail = $item['thumbnail'] ?? $mediaItem->url;
                if (!empty($mediaItem->url)) {
                    $media[] = $mediaItem;
                }
            }
        }

        return $media;
    }

    /**
     * FastDL Instagram API
     */
    protected function tryFastDl(string $url): array
    {
        $response = $this->client->post('https://fastdl.app/api/convert', [
            'headers' => [
                'Origin' => 'https://fastdl.app',
                'Referer' => 'https://fastdl.app/',
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'url' => $url,
            ],
        ]);

        $data = json_decode((string) $response->getBody(), true);
        $media = [];

        if (!empty($data['url'])) {
            foreach ($data['url'] as $mediaUrl) {
                $item = new MediaItem();
                $item->type = str_contains($mediaUrl['url'] ?? $mediaUrl, '.mp4') ? 'video' : 'image';
                $item->url = is_array($mediaUrl) ? $mediaUrl['url'] : $mediaUrl;
                $item->thumbnail = $item->url;
                if (!empty($item->url)) {
                    $media[] = $item;
                }
            }
        }

        return $media;
    }

    /**
     * Inflact (formerly Ingramer) API
     */
    protected function tryInflact(string $shortcode): array
    {
        // This endpoint returns JSON directly
        $response = $this->client->get("https://inflact.com/downloader/ajax/get-media/{$shortcode}/", [
            'headers' => [
                'X-Requested-With' => 'XMLHttpRequest',
                'Referer' => 'https://inflact.com/downloader/instagram/video/',
            ],
        ]);

        $data = json_decode((string) $response->getBody(), true);
        $media = [];

        if (!empty($data['medias'])) {
            foreach ($data['medias'] as $m) {
                $item = new MediaItem();
                $item->type = ($m['type'] ?? '') === 'video' ? 'video' : 'image';
                $item->url = $m['url'] ?? '';
                $item->thumbnail = $m['preview'] ?? $m['url'] ?? '';
                if (!empty($item->url)) {
                    $media[] = $item;
                }
            }
        }

        return $media;
    }
}
