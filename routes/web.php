<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DownloaderController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\SitemapController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Main Pages (SEO-friendly URLs)
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/instagram-video-downloader', [PageController::class, 'videoDownloader'])->name('video-downloader');
Route::get('/instagram-reels-downloader', [PageController::class, 'reelsDownloader'])->name('reels-downloader');
Route::get('/instagram-story-downloader', [PageController::class, 'storyDownloader'])->name('story-downloader');
Route::get('/instagram-photo-downloader', [PageController::class, 'photoDownloader'])->name('photo-downloader');
Route::get('/instagram-igtv-downloader', [PageController::class, 'igtvDownloader'])->name('igtv-downloader');

// Download API
Route::post('/api/download', [DownloaderController::class, 'process'])->name('api.download');
Route::get('/api/proxy', [DownloaderController::class, 'proxy'])->name('api.proxy');
Route::get('/api/oembed', [DownloaderController::class, 'oembed'])->name('api.oembed');

// Blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{article:slug}', [BlogController::class, 'show'])->name('blog.show');

// Static Pages
Route::view('/about', 'pages.about')->name('about');
Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/privacy-policy', 'pages.privacy')->name('privacy');
Route::view('/terms-of-service', 'pages.terms')->name('terms');
Route::view('/faq', 'pages.faq')->name('faq');

// Sitemap
Route::get('/sitemap.xml', function () {
    return response()->view('sitemap.index')
        ->header('Content-Type', 'application/xml');
})->name('sitemap');
