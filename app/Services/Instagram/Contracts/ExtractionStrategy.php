<?php

namespace App\Services\Instagram\Contracts;

use App\Services\Instagram\DTOs\MediaResult;

interface ExtractionStrategy
{
    /**
     * Get strategy name for logging
     */
    public function getName(): string;

    /**
     * Extract media from Instagram
     */
    public function extract(string $shortcode, string $mediaType): MediaResult;

    /**
     * Check if this strategy supports the media type
     */
    public function supports(string $mediaType): bool;
}
