<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Home page
     */
    public function home(): View
    {
        return view('pages.home', [
            'seo' => $this->getSeoData('home'),
        ]);
    }

    /**
     * Video downloader page
     */
    public function videoDownloader(): View
    {
        return view('pages.video-downloader', [
            'seo' => $this->getSeoData('video'),
        ]);
    }

    /**
     * Reels downloader page
     */
    public function reelsDownloader(): View
    {
        return view('pages.reels-downloader', [
            'seo' => $this->getSeoData('reels'),
        ]);
    }

    /**
     * Story downloader page
     */
    public function storyDownloader(): View
    {
        return view('pages.story-downloader', [
            'seo' => $this->getSeoData('story'),
        ]);
    }

    /**
     * Photo downloader page
     */
    public function photoDownloader(): View
    {
        return view('pages.photo-downloader', [
            'seo' => $this->getSeoData('photo'),
        ]);
    }

    /**
     * IGTV downloader page
     */
    public function igtvDownloader(): View
    {
        return view('pages.igtv-downloader', [
            'seo' => $this->getSeoData('igtv'),
        ]);
    }

    /**
     * Get SEO data for page
     */
    protected function getSeoData(string $page): array
    {
        $siteName = Setting::get('site_name', 'FastInsta');
        
        $seoData = [
            'home' => [
                'title' => "Instagram Downloader - Download Videos, Reels, Photos & Stories | {$siteName}",
                'description' => 'Download Instagram videos, reels, photos, stories, and IGTV in HD quality for free. Fast, easy, and no login required. Works on mobile and desktop.',
                'keywords' => 'instagram downloader, download instagram video, instagram reels downloader, instagram story downloader, save instagram photos',
                'h1' => 'Free Instagram Video & Photo Downloader',
            ],
            'video' => [
                'title' => "Instagram Video Downloader - Download IG Videos in HD | {$siteName}",
                'description' => 'Download Instagram videos in HD quality for free. Save any public Instagram video to your device in seconds. No login required.',
                'keywords' => 'instagram video downloader, download ig video, save instagram video, instagram video saver',
                'h1' => 'Instagram Video Downloader',
            ],
            'reels' => [
                'title' => "Instagram Reels Downloader - Download IG Reels for Free | {$siteName}",
                'description' => 'Download Instagram Reels videos in HD quality. Save your favorite reels from Instagram to your phone or computer for free.',
                'keywords' => 'instagram reels downloader, download reels, save instagram reels, ig reels download',
                'h1' => 'Instagram Reels Downloader',
            ],
            'story' => [
                'title' => "Instagram Story Downloader - Save IG Stories Online | {$siteName}",
                'description' => 'Download Instagram stories before they disappear. Save public Instagram stories and highlights in HD quality for free.',
                'keywords' => 'instagram story downloader, download ig stories, save instagram story, instagram story saver',
                'h1' => 'Instagram Story Downloader',
            ],
            'photo' => [
                'title' => "Instagram Photo Downloader - Download IG Images in Full Quality | {$siteName}",
                'description' => 'Download Instagram photos in original quality. Save carousel photos, profile pictures, and posts. Fast and free.',
                'keywords' => 'instagram photo downloader, download instagram image, save ig photos, instagram picture download',
                'h1' => 'Instagram Photo Downloader',
            ],
            'igtv' => [
                'title' => "IGTV Downloader - Download Instagram IGTV Videos | {$siteName}",
                'description' => 'Download IGTV videos from Instagram in HD quality. Save long-form Instagram videos to your device easily.',
                'keywords' => 'igtv downloader, download igtv, instagram tv download, save igtv video',
                'h1' => 'IGTV Video Downloader',
            ],
        ];

        return $seoData[$page] ?? $seoData['home'];
    }
}
