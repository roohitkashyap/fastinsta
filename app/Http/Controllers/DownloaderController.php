<?php

namespace App\Http\Controllers;

use App\Services\Instagram\InstagramService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;

class DownloaderController extends Controller
{
    protected InstagramService $instagram;

    public function __construct(InstagramService $instagram)
    {
        $this->instagram = $instagram;
    }

    /**
     * Process download request
     */
    public function process(Request $request): JsonResponse
    {
        // Rate limiting
        $key = 'download:' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($key, 30)) {
            $seconds = RateLimiter::availableIn($key);
            return response()->json([
                'success' => false,
                'error' => "Too many requests. Please try again in {$seconds} seconds.",
            ], 429);
        }

        RateLimiter::hit($key, 60);

        // Validate
        $validator = Validator::make($request->all(), [
            'url' => 'required|url|max:500',
            'turnstile_token' => 'nullable|string', // Cloudflare Turnstile
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Please enter a valid Instagram URL.',
            ], 422);
        }

        // Verify Turnstile if enabled
        if (config('services.turnstile.secret') && $request->filled('turnstile_token')) {
            if (!$this->verifyTurnstile($request->turnstile_token)) {
                return response()->json([
                    'success' => false,
                    'error' => 'Security verification failed. Please try again.',
                ], 422);
            }
        }

        // Process download
        try {
            $result = $this->instagram->download($request->url);

            return response()->json($result->toArray());

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'An error occurred. Please try again.',
            ], 500);
        }
    }

    /**
     * Verify Cloudflare Turnstile token
     */
    protected function verifyTurnstile(string $token): bool
    {
        $response = \Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret' => config('services.turnstile.secret'),
            'response' => $token,
            'remoteip' => request()->ip(),
        ]);

        $data = $response->json();

        return $data['success'] ?? false;
    }

    /**
     * Proxy download (to avoid CORS issues)
     */
    public function proxy(Request $request): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $validator = Validator::make($request->all(), [
            'url' => 'required|url',
            'filename' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            abort(400, 'Invalid request');
        }

        $url = $request->url;
        $filename = $request->filename ?? 'instagram_media';

        // Only allow Instagram CDN URLs
        if (!preg_match('/^https:\/\/(scontent|video)[-\w]*\.cdninstagram\.com/i', $url) &&
            !preg_match('/^https:\/\/instagram\..*\.fbcdn\.net/i', $url)) {
            abort(403, 'Invalid download URL');
        }

        // Detect media type from URL and add extension if missing
        $isVideo = str_contains($url, 'video') || str_contains($url, '.mp4');
        $extension = $isVideo ? '.mp4' : '.jpg';
        $contentType = $isVideo ? 'video/mp4' : 'image/jpeg';
        
        // Add extension if filename doesn't have one
        if (!str_contains($filename, '.')) {
            $filename .= $extension;
        }

        return response()->streamDownload(function () use ($url) {
            $stream = fopen($url, 'r');
            fpassthru($stream);
            fclose($stream);
        }, $filename, [
            'Content-Type' => $contentType,
            'Cache-Control' => 'no-cache',
        ]);
    }

    /**
     * oEmbed proxy for client-side fallback extraction
     * Instagram's oEmbed API is public and works well for extracting thumbnails
     */
    public function oembed(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'url' => 'required|url',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid URL'], 422);
        }

        try {
            $oembedUrl = 'https://api.instagram.com/oembed/?url=' . urlencode($request->url);
            
            $client = new \GuzzleHttp\Client([
                'timeout' => 10,
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                    'Accept' => 'application/json',
                    'Accept-Encoding' => 'gzip, deflate',
                ],
                'verify' => false,
            ]);

            $response = $client->get($oembedUrl);
            $data = json_decode((string) $response->getBody(), true);

            return response()->json($data);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Could not fetch oEmbed data',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
