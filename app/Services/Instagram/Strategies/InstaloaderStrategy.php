<?php

namespace App\Services\Instagram\Strategies;

use App\Services\Instagram\Contracts\ExtractionStrategy;
use App\Services\Instagram\DTOs\MediaResult;
use App\Services\Instagram\DTOs\MediaItem;
use Illuminate\Support\Facades\Log;

/**
 * InstaloaderStrategy - Uses instaloader Python library
 * Best for images and profile data where yt-dlp might fail
 */
class InstaloaderStrategy implements ExtractionStrategy
{
    public function getName(): string
    {
        return 'instaloader';
    }

    public function supports(string $mediaType): bool
    {
        return in_array($mediaType, ['post', 'reel', 'story', 'carousel']);
    }

    public function extract(string $shortcode, string $mediaType): MediaResult
    {
        $result = new MediaResult();
        $result->strategyUsed = $this->getName();
        $result->shortcode = $shortcode;
        $result->mediaType = $mediaType;

        try {
            // Using python -m instaloader to avoid PATH issues
            // -Q = quiet, --no-videos = we only want metadata/images if yt-dlp failed, 
            // but actually we want EVERYTHING.
            // --filename-pattern={shortcode} to keep filenames predictable?
            // Actually, we just want JSON. But instaloader doesn't output JSON easily without downloading.
            // We can use --no-download --quiet --iphone (to simulate mobile) and some internal flags?
            // Simpler: Use a python script wrapper that imports instaloader and prints JSON.
            
            // Let's create a temporary python script to extract data using instaloader module
            $scriptPath = storage_path('app/temp/instaloader_script.py');
            if (!file_exists(dirname($scriptPath))) {
                mkdir(dirname($scriptPath), 0755, true);
            }
            
            $pythonCode = <<<PYTHON
import instaloader
import json
import sys

L = instaloader.Instaloader(
    download_pictures=False,
    download_videos=False, 
    download_video_thumbnails=False,
    compress_json=False, 
    save_metadata=False
)

try:
    post = instaloader.Post.from_shortcode(L.context, '$shortcode')
    
    data = {
        'caption': post.caption,
        'owner_username': post.owner_username,
        'typename': post.typename,
        'url': post.url,
        'video_url': post.video_url,
        'is_video': post.is_video,
        'thumbnail_url': post.url, # For images, url is the image
        'media': []
    }
    
    if post.typename == 'GraphSidecar':
        for node in post.get_sidecar_nodes():
            data['media'].append({
                'is_video': node.is_video,
                'url': node.video_url if node.is_video else node.display_url,
                'thumbnail': node.display_url
            })
    else:
        data['media'].append({
            'is_video': post.is_video,
            'url': post.video_url if post.is_video else post.url,
            'thumbnail': post.url
        })
        
    print('###JSON_START###')
    print(json.dumps(data))
    
except Exception as e:
    print('###JSON_START###')
    print(json.dumps({'error': str(e)}))
    sys.exit(1)
PYTHON;

            file_put_contents($scriptPath, $pythonCode);
            
            // Use venv python if available (Docker), otherwise system python
            $pythonPath = file_exists('/opt/venv/bin/python') ? '/opt/venv/bin/python' : 'python';
            $command = "$pythonPath \"$scriptPath\" 2>&1";
            $output = shell_exec($command);
            
            // Clean up
            @unlink($scriptPath);

            if (empty($output)) {
                $result->error = 'Instaloader returned empty output';
                return $result;
            }

            // Parse output - find JSON after delimiter
            $jsonPart = $output;
            if (strpos($output, '###JSON_START###') !== false) {
                $parts = explode('###JSON_START###', $output);
                $jsonPart = end($parts);
            }

            $data = json_decode($jsonPart, true);
            
            if (isset($data['error'])) {
                $result->error = 'Instaloader error: ' . $data['error'];
                return $result;
            }
            
            if (!$data) {
                // Check if output contains Python error
                $result->error = 'Instaloader failed: ' . substr($output, 0, 200);
                return $result;
            }

            // Parse success data
            $result->success = true;
            $result->caption = $data['caption'] ?? '';
            $result->username = $data['owner_username'] ?? '';
            $result->thumbnail = $data['thumbnail_url'] ?? ''; // Main thumbnail

            foreach ($data['media'] as $media) {
                $item = new MediaItem();
                $item->type = ($media['is_video'] ?? false) ? 'video' : 'image';
                $item->url = $media['url'] ?? '';
                $item->thumbnail = $media['thumbnail'] ?? '';
                
                if (!empty($item->url)) {
                    $result->media[] = $item;
                }
            }
            
            if (count($result->media) > 1) {
                $result->mediaType = 'carousel';
            }

            Log::info('Instaloader success', ['shortcode' => $shortcode, 'count' => count($result->media)]);

        } catch (\Exception $e) {
            $result->error = $e->getMessage();
            Log::error('Instaloader exception', ['error' => $e->getMessage()]);
        }

        return $result;
    }
}
