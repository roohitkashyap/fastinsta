<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Instagram Service Configuration
    |--------------------------------------------------------------------------
    */

    // API Keys
    'rapidapi_key' => env('RAPIDAPI_KEY', ''),
    'rapidapi_host' => env('RAPIDAPI_HOST', 'instagram-scraper-api2.p.rapidapi.com'),

    // Session cookie for age-restricted content
    'session_id' => env('INSTAGRAM_SESSION_ID', ''),

    // Rate Limiting
    'rate_limit_per_minute' => env('INSTAGRAM_RATE_LIMIT', 30),
    'rate_limit_per_proxy' => env('INSTAGRAM_PROXY_RATE_LIMIT', 10),

    // Proxy Settings
    'proxy' => [
        'enabled' => env('INSTAGRAM_PROXY_ENABLED', false),
        'max_failures' => 3,           // Auto-ban after this many consecutive failures
        'ban_duration' => 30,          // Minutes to ban proxy
        'rotation_strategy' => 'round_robin', // round_robin, random, least_used
    ],

    // Extraction Settings
    'strategies' => [
        'direct_scrape' => [
            'enabled' => true,
            'timeout' => 10,
            'priority' => 1,
        ],
        'rapidapi' => [
            'enabled' => true,
            'timeout' => 15,
            'priority' => 2,
        ],
    ],

    // User Agent rotation
    'user_agents' => [
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
        'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
        'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.0 Mobile/15E148 Safari/604.1',
    ],

    // Caching
    'cache' => [
        'enabled' => true,
        'ttl' => 3600, // 1 hour
        'prefix' => 'instagram_',
    ],

    // FFmpeg for DASH streams (HD video merging)
    'ffmpeg' => [
        'enabled' => env('FFMPEG_ENABLED', false),
        'path' => env('FFMPEG_PATH', '/usr/bin/ffmpeg'),
    ],

];
