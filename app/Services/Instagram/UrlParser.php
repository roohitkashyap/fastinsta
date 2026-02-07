<?php

namespace App\Services\Instagram;

class UrlParser
{
    protected string $url;
    protected string $shortcode = '';
    protected string $type = '';
    protected string $username = '';

    // Regex patterns for Instagram URLs
    protected array $patterns = [
        'post' => '/instagram\.com\/p\/([A-Za-z0-9_-]+)/i',
        'reel' => '/instagram\.com\/reels?\/([A-Za-z0-9_-]+)/i',
        'story' => '/instagram\.com\/stories\/([A-Za-z0-9._]+)\/(\d+)/i',
        'igtv' => '/instagram\.com\/tv\/([A-Za-z0-9_-]+)/i',
        'profile' => '/instagram\.com\/([A-Za-z0-9._]+)\/?$/i',
    ];

    public function __construct(string $url)
    {
        $this->url = $this->normalizeUrl($url);
        $this->parse();
    }

    protected function normalizeUrl(string $url): string
    {
        // Remove query params and trailing slashes
        $url = trim($url);
        $url = preg_replace('/\?.*$/', '', $url);
        $url = rtrim($url, '/');
        
        // Add https if missing
        if (!preg_match('/^https?:\/\//i', $url)) {
            $url = 'https://' . $url;
        }
        
        // Normalize www
        $url = preg_replace('/^(https?:\/\/)www\./i', '$1', $url);
        
        return $url;
    }

    protected function parse(): void
    {
        // Story (special case - has username and story ID)
        if (preg_match($this->patterns['story'], $this->url, $matches)) {
            $this->type = 'story';
            $this->username = $matches[1];
            $this->shortcode = $matches[2];
            return;
        }

        // Post
        if (preg_match($this->patterns['post'], $this->url, $matches)) {
            $this->type = 'post';
            $this->shortcode = $matches[1];
            return;
        }

        // Reel
        if (preg_match($this->patterns['reel'], $this->url, $matches)) {
            $this->type = 'reel';
            $this->shortcode = $matches[1];
            return;
        }

        // IGTV
        if (preg_match($this->patterns['igtv'], $this->url, $matches)) {
            $this->type = 'igtv';
            $this->shortcode = $matches[1];
            return;
        }

        // Profile (for getting latest posts, not for direct download)
        if (preg_match($this->patterns['profile'], $this->url, $matches)) {
            $this->type = 'profile';
            $this->username = $matches[1];
            return;
        }
    }

    public function isValid(): bool
    {
        return !empty($this->type) && (!empty($this->shortcode) || !empty($this->username));
    }

    public function getShortcode(): string
    {
        return $this->shortcode;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function isPost(): bool
    {
        return $this->type === 'post';
    }

    public function isReel(): bool
    {
        return $this->type === 'reel';
    }

    public function isStory(): bool
    {
        return $this->type === 'story';
    }

    public function isIgtv(): bool
    {
        return $this->type === 'igtv';
    }

    public function isProfile(): bool
    {
        return $this->type === 'profile';
    }
}
