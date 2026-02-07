<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class Article extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'meta_title',
        'meta_description',
        'is_published',
        'published_at',
        'views_count',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'views_count' => 'integer',
    ];

    /**
     * Auto-generate slug from title
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
        });
    }

    /**
     * Scope for published articles
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    /**
     * Get the SEO title (meta_title or title)
     */
    protected function seoTitle(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->meta_title ?: $this->title,
        );
    }

    /**
     * Get excerpt with fallback
     */
    protected function shortExcerpt(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->excerpt ?: Str::limit(strip_tags($this->content), 160),
        );
    }

    /**
     * Increment view count
     */
    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    /**
     * Get route key name for URL binding
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
