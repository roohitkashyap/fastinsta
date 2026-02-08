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

// Debug Route (Temporary) - Check Python, yt-dlp, etc.
Route::get('/debug-env', function () {
    $results = [];
    
    // Database check
    try {
        \DB::connection()->getPdo();
        $results['DB_STATUS'] = "Connected: " . \DB::connection()->getDatabaseName();
    } catch (\Exception $e) {
        $results['DB_STATUS'] = "Failed: " . $e->getMessage();
    }
    
    // Check yt-dlp
    $ytdlpPath = file_exists('/opt/venv/bin/yt-dlp') ? '/opt/venv/bin/yt-dlp' : 'yt-dlp';
    $ytdlpVersion = trim(shell_exec("$ytdlpPath --version 2>&1") ?? 'not found');
    
    // Check Python
    $pythonPath = file_exists('/opt/venv/bin/python') ? '/opt/venv/bin/python' : 'python';
    $pythonVersion = trim(shell_exec("$pythonPath --version 2>&1") ?? 'not found');
    
    // Check instaloader
    $instaloaderCheck = trim(shell_exec("$pythonPath -c 'import instaloader; print(instaloader.__version__)' 2>&1") ?? 'not found');
    
    // Test yt-dlp with a known public reel
    $testUrl = 'https://www.instagram.com/reel/CzTGAi_rDQz/';
    $testCommand = "$ytdlpPath --dump-json \"$testUrl\" 2>&1 | head -c 500";
    $testResult = trim(shell_exec($testCommand) ?? 'failed');
    
    return [
        'APP_ENV' => env('APP_ENV'),
        'APP_DEBUG' => env('APP_DEBUG'),
        'PHP_VERSION' => phpversion(),
        'PYTHON_VERSION' => $pythonVersion,
        'PYTHON_PATH' => $pythonPath,
        'YTDLP_PATH' => $ytdlpPath,
        'YTDLP_VERSION' => $ytdlpVersion,
        'INSTALOADER_VERSION' => $instaloaderCheck,
        'DB_CONNECTION' => env('DB_CONNECTION'),
        'DB_STATUS' => $results['DB_STATUS'],
        'TEST_YTDLP' => substr($testResult, 0, 500),
    ];
});
