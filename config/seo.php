<?php

return [

    /*
    |--------------------------------------------------------------------------
    | SEO Configuration
    |--------------------------------------------------------------------------
    */

    // Default meta tags
    'defaults' => [
        'title' => 'FastInsta - Free Instagram Video & Photo Downloader',
        'description' => 'Download Instagram videos, reels, photos, stories & IGTV in HD quality. Fast, free, and works on any device. No login required.',
        'keywords' => 'instagram downloader, instagram video download, instagram reels download, download instagram, save instagram, instagram photo download',
        'author' => 'FastInsta',
    ],

    // Page-specific SEO
    'pages' => [
        'home' => [
            'title' => 'FastInsta - Free Instagram Video & Photo Downloader | HD Quality',
            'description' => 'Download Instagram videos, reels, photos, stories & IGTV in HD quality. Fast, free, and works on any device.',
            'h1' => 'Free Instagram Video & Photo Downloader',
        ],
        'video' => [
            'title' => 'Instagram Video Downloader - Download IG Videos in HD | FastInsta',
            'description' => 'Download Instagram videos in MP4 format with HD quality. Save any video from Instagram posts for free.',
            'h1' => 'Instagram Video Downloader',
        ],
        'reels' => [
            'title' => 'Instagram Reels Downloader - Save Reels in HD | FastInsta',
            'description' => 'Download Instagram Reels in HD quality with audio. Save trending reels to watch offline.',
            'h1' => 'Instagram Reels Downloader',
        ],
        'story' => [
            'title' => 'Instagram Story Downloader - Download Stories Anonymously | FastInsta',
            'description' => 'Download Instagram Stories before they disappear. Save photos and videos from public stories anonymously.',
            'h1' => 'Instagram Story Downloader',
        ],
        'photo' => [
            'title' => 'Instagram Photo Downloader - Save Photos in Full Resolution | FastInsta',
            'description' => 'Download Instagram photos in full resolution. Save high-quality images from any public post.',
            'h1' => 'Instagram Photo Downloader',
        ],
        'igtv' => [
            'title' => 'IGTV Downloader - Download Instagram IGTV Videos | FastInsta',
            'description' => 'Download IGTV videos in HD quality. Save long-form Instagram content to watch offline.',
            'h1' => 'Instagram IGTV Downloader',
        ],
    ],

    // Schema.org settings
    'schema' => [
        'organization' => [
            'name' => 'FastInsta',
            'logo' => '/icons/icon-512.png',
        ],
    ],

    // Social sharing
    'social' => [
        'og_image' => '/images/og-image.jpg',
        'twitter_site' => '@fastinsta',
    ],

];
