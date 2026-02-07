<?php

namespace App\Services\Instagram;

use App\Services\Instagram\DTOs\MediaResult;
use App\Services\Instagram\Strategies\YtDlpStrategy;
use App\Services\Instagram\Strategies\InstaloaderStrategy;
use App\Services\Instagram\Strategies\RapidApiStrategy;
use App\Services\Instagram\Strategies\ThirdPartyApiStrategy;
use App\Services\Instagram\Strategies\DirectScrapeStrategy;
use App\Models\DownloadLog;
use Illuminate\Support\Facades\Log;
use Exception;

class InstagramService
{
    /**
     * Strategies in order of priority:
     * 1. YtDlp - FREE, most reliable (uses Python yt-dlp)
     * 2. RapidApi - Paid API (if key configured)
     * 3. ThirdPartyApi - Free APIs (often blocked)
     * 4. DirectScrape - Last resort (often blocked)
     */
    protected array $strategies = [
        YtDlpStrategy::class,           // FREE - most reliable for video
        InstaloaderStrategy::class,     // FREE - reliable fallback for images/posts
        RapidApiStrategy::class,        // PAID - needs RapidAPI key
        ThirdPartyApiStrategy::class,   // FREE fallback
        DirectScrapeStrategy::class,    // Last resort
    ];

    /**
     * Download media from Instagram URL
     */
    public function download(string $url): MediaResult
    {
        // Parse URL
        $parser = new UrlParser($url);

        if (!$parser->isValid()) {
            return MediaResult::error('Invalid Instagram URL. Please provide a valid post, reel, story, or IGTV link.');
        }

        $shortcode = $parser->getShortcode();
        $mediaType = $parser->getType();

        // Log the attempt
        $log = DownloadLog::log([
            'url' => $url,
            'shortcode' => $shortcode,
            'media_type' => $mediaType,
            'status' => 'pending',
        ]);

        // Try each strategy
        foreach ($this->strategies as $strategyClass) {
            try {
                $strategy = new $strategyClass();

                // Check if strategy supports this media type
                if (!$strategy->supports($mediaType)) {
                    continue;
                }

                $result = $strategy->extract($shortcode, $mediaType);

                if ($result->isSuccess()) {
                    // Update log with success
                    $log->update([
                        'status' => 'success',
                        'strategy_used' => $result->strategyUsed,
                        'media_count' => count($result->media),
                    ]);

                    Log::info('Instagram download success', [
                        'shortcode' => $shortcode,
                        'strategy' => $result->strategyUsed,
                        'media_count' => count($result->media),
                    ]);

                    return $result;
                }

            } catch (Exception $e) {
                Log::warning('Instagram strategy failed', [
                    'strategy' => $strategyClass,
                    'shortcode' => $shortcode,
                    'error' => $e->getMessage(),
                ]);
                continue;
            }
        }

        // All strategies failed
        $log->update([
            'status' => 'failed',
            'error_message' => 'All extraction strategies failed',
        ]);

        return MediaResult::error('Could not download this content. It may be private, expired, or Instagram may have blocked the request. Please try again later.');
    }

    /**
     * Get supported media types
     */
    public function getSupportedTypes(): array
    {
        return ['post', 'reel', 'story', 'igtv', 'carousel'];
    }

    /**
     * Validate Instagram URL format
     */
    public function isValidUrl(string $url): bool
    {
        $parser = new UrlParser($url);
        return $parser->isValid();
    }

    /**
     * Get media type from URL
     */
    public function getMediaType(string $url): string
    {
        $parser = new UrlParser($url);
        return $parser->getType();
    }
}
