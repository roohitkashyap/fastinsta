<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\View\View;

class BlogController extends Controller
{
    /**
     * Blog listing page
     */
    public function index(): View
    {
        $articles = Article::published()
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        return view('blog.index', [
            'articles' => $articles,
        ]);
    }

    /**
     * Single article page
     */
    public function show(Article $article): View
    {
        // Only show published articles
        if (!$article->is_published) {
            abort(404);
        }

        // Increment view count
        $article->incrementViews();

        // Get related articles
        $related = Article::published()
            ->where('id', '!=', $article->id)
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        return view('blog.show', [
            'article' => $article,
            'related' => $related,
        ]);
    }
}
