<?php

namespace App\Services\Instagram\DTOs;

class MediaResult
{
    public bool $success = false;
    public string $error = '';
    public string $mediaType = '';      // post, reel, story, igtv, carousel
    public string $shortcode = '';
    public string $caption = '';
    public string $username = '';
    public string $thumbnail = '';
    public array $media = [];           // Array of MediaItem
    public string $strategyUsed = '';

    public function isSuccess(): bool
    {
        return $this->success && count($this->media) > 0;
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'error' => $this->error,
            'media_type' => $this->mediaType,
            'shortcode' => $this->shortcode,
            'caption' => $this->caption,
            'username' => $this->username,
            'thumbnail' => $this->thumbnail,
            'media' => array_map(fn($m) => $m->toArray(), $this->media),
            'media_count' => count($this->media),
            'strategy_used' => $this->strategyUsed,
        ];
    }

    public static function error(string $message): self
    {
        $result = new self();
        $result->success = false;
        $result->error = $message;
        return $result;
    }
}

class MediaItem
{
    public string $type = '';           // video, image
    public string $url = '';            // Download URL
    public string $thumbnail = '';
    public int $width = 0;
    public int $height = 0;
    public string $quality = 'hd';      // hd, sd
    public ?int $duration = null;       // For videos (seconds)
    public bool $hasAudio = true;

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'url' => $this->url,
            'thumbnail' => $this->thumbnail,
            'width' => $this->width,
            'height' => $this->height,
            'quality' => $this->quality,
            'duration' => $this->duration,
            'has_audio' => $this->hasAudio,
        ];
    }
}
