<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $articles = Article::published()->get();
        
        $content = view('sitemap.index', [
            'articles' => $articles,
        ])->render();

        return response($content, 200)
            ->header('Content-Type', 'application/xml');
    }
}
