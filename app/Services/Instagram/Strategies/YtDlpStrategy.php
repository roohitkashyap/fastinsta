<?php

namespace App\Services\Instagram\Strategies;

use App\Services\Instagram\Contracts\ExtractionStrategy;
use App\Services\Instagram\DTOs\MediaResult;
use App\Services\Instagram\DTOs\MediaItem;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * YtDlpStrategy - Uses yt-dlp (Python) for Instagram media extraction
 * 
 * yt-dlp is a free, actively maintained tool that handles Instagram's
 * anti-scraping measures. It's the most reliable free method.
 * 
 * Requirements: yt-dlp must be installed (pip install yt-dlp)
 */
class YtDlpStrategy implements ExtractionStrategy
{
    protected string $ytDlpPath;
    protected string $outputDir;

    public function __construct()
    {
        // Try to find yt-dlp in PATH or common locations
        $this->ytDlpPath = $this->findYtDlp();
        
        // Temp directory for downloads
        $this->outputDir = storage_path('app/temp/instagram');
        
        // Ensure output directory exists
        if (!is_dir($this->outputDir)) {
            mkdir($this->outputDir, 0755, true);
        }
    }

    public function getName(): string
    {
        return 'yt-dlp';
    }

    public function supports(string $mediaType): bool
    {
        // yt-dlp supports all Instagram media types
        return in_array($mediaType, ['post', 'reel', 'story', 'igtv', 'carousel']);
    }

    public function extract(string $shortcode, string $mediaType): MediaResult
    {
        $result = new MediaResult();
        $result->strategyUsed = $this->getName();
        $result->shortcode = $shortcode;
        $result->mediaType = $mediaType;

        if (empty($this->ytDlpPath)) {
            $result->error = 'yt-dlp is not installed. Run: pip install yt-dlp';
            Log::error('yt-dlp not found in system PATH');
            return $result;
        }

        try {
            // Build Instagram URL
            $url = $this->buildInstagramUrl($shortcode, $mediaType);
            
            Log::info('yt-dlp extraction starting', [
                'shortcode' => $shortcode,
                'type' => $mediaType,
                'url' => $url
            ]);

            // Get media info using yt-dlp --dump-json
            $mediaInfo = $this->getMediaInfo($url);

            if (empty($mediaInfo)) {
                // If yt-dlp fails (e.g. for some image posts), return error so we can try fallback
                $result->error = 'yt-dlp could not extract info (possibly image-only post)';
                return $result;
            }

            // Parse the media info
            return $this->parseMediaInfo($mediaInfo, $shortcode, $mediaType);

        } catch (\Exception $e) {
            $result->error = 'Extraction failed: ' . $e->getMessage();
            Log::error('yt-dlp extraction failed', ['error' => $e->getMessage()]);
        }

        return $result;
    }

    protected function findYtDlp(): string
    {
        // Check if yt-dlp is in PATH
        $command = PHP_OS_FAMILY === 'Windows' ? 'where yt-dlp 2>nul' : 'which yt-dlp 2>/dev/null';
        $path = trim(shell_exec($command) ?? '');
        
        if (!empty($path)) {
            // On Windows, 'where' might return multiple lines
            $paths = explode("\n", $path);
            return trim($paths[0]);
        }

        // Try common locations
        $commonPaths = PHP_OS_FAMILY === 'Windows' 
            ? ['C:\\Python311\\Scripts\\yt-dlp.exe', 'C:\\Python310\\Scripts\\yt-dlp.exe', 'C:\\Python39\\Scripts\\yt-dlp.exe']
            : ['/usr/local/bin/yt-dlp', '/usr/bin/yt-dlp', '~/.local/bin/yt-dlp'];

        foreach ($commonPaths as $p) {
            if (file_exists($p)) {
                return $p;
            }
        }

        // Just return 'yt-dlp' and hope it's in PATH
        return 'yt-dlp';
    }

    protected function buildInstagramUrl(string $shortcode, string $mediaType): string
    {
        switch ($mediaType) {
            case 'reel':
                return "https://www.instagram.com/reel/{$shortcode}/";
            case 'igtv':
                return "https://www.instagram.com/tv/{$shortcode}/";
            case 'story':
                return "https://www.instagram.com/stories/highlights/{$shortcode}/";
            default:
                return "https://www.instagram.com/p/{$shortcode}/";
        }
    }

    protected function getMediaInfo(string $url): ?array
    {
        // Use yt-dlp to get media info as JSON (no actual download)
        $command = sprintf(
            '%s --dump-json --no-warnings --quiet "%s" 2>&1',
            escapeshellarg($this->ytDlpPath),
            $url
        );

        Log::debug('yt-dlp command', ['command' => $command]);

        $output = shell_exec($command);

        if (empty($output)) {
            Log::warning('yt-dlp returned empty output');
            return null;
        }

        // yt-dlp may return multiple JSON objects for carousels
        $lines = array_filter(explode("\n", trim($output)));
        $mediaItems = [];

        foreach ($lines as $line) {
            $json = json_decode($line, true);
            if (json_last_error() === JSON_ERROR_NONE && $json) {
                $mediaItems[] = $json;
            }
        }

        if (empty($mediaItems)) {
            Log::warning('yt-dlp: No valid JSON in output', ['output' => substr($output, 0, 500)]);
            return null;
        }

        return $mediaItems;
    }

    protected function parseMediaInfo(array $mediaItems, string $shortcode, string $mediaType): MediaResult
    {
        $result = new MediaResult();
        $result->success = true;
        $result->strategyUsed = $this->getName();
        $result->shortcode = $shortcode;
        $result->mediaType = count($mediaItems) > 1 ? 'carousel' : $mediaType;

        foreach ($mediaItems as $info) {
            $item = new MediaItem();

            // Determine if video or image based on format or ext
            $ext = $info['ext'] ?? '';
            $isVideo = in_array($ext, ['mp4', 'webm', 'm4a']) || isset($info['fps']);

            $item->type = $isVideo ? 'video' : 'image';
            
            // Get the best URL
            if ($isVideo) {
                // For video, get the direct URL
                $item->url = $info['url'] ?? $this->getBestVideoUrl($info);
            } else {
                $item->url = $info['url'] ?? $info['thumbnail'] ?? '';
            }

            $item->thumbnail = $info['thumbnail'] ?? $info['url'] ?? '';
            $item->width = $info['width'] ?? 0;
            $item->height = $info['height'] ?? 0;
            $item->duration = $info['duration'] ?? null;

            if (!empty($item->url)) {
                $result->media[] = $item;
            }

            // Extract caption and username from first item
            if (empty($result->caption)) {
                $result->caption = $info['description'] ?? $info['title'] ?? '';
            }
            if (empty($result->username)) {
                $result->username = $info['uploader'] ?? $info['uploader_id'] ?? '';
            }
            if (empty($result->thumbnail)) {
                $result->thumbnail = $info['thumbnail'] ?? '';
            }
        }

        if (empty($result->media)) {
            $result->success = false;
            $result->error = 'No downloadable media found';
        } else {
            Log::info('yt-dlp extraction success', [
                'media_count' => count($result->media),
                'types' => array_map(fn($m) => $m->type, $result->media)
            ]);
        }

        return $result;
    }

    protected function getBestVideoUrl(array $info): string
    {
        // Try to get the best quality video URL
        if (isset($info['formats']) && is_array($info['formats'])) {
            // Sort by quality (height)
            $formats = $info['formats'];
            usort($formats, fn($a, $b) => ($b['height'] ?? 0) - ($a['height'] ?? 0));

            foreach ($formats as $format) {
                if (isset($format['url']) && ($format['vcodec'] ?? 'none') !== 'none') {
                    return $format['url'];
                }
            }
        }

        return $info['url'] ?? '';
    }
}
