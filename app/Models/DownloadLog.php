<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DownloadLog extends Model
{
    protected $fillable = [
        'url',
        'shortcode',
        'media_type',
        'status',
        'strategy_used',
        'ip_address',
        'user_agent',
        'error_message',
        'media_count',
    ];

    protected $casts = [
        'media_count' => 'integer',
    ];

    /**
     * Scope for successful downloads
     */
    public function scopeSuccessful($query)
    {
        return $query->where('status', 'success');
    }

    /**
     * Scope for failed downloads
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /**
     * Scope for today
     */
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    /**
     * Scope for this week
     */
    public function scopeThisWeek($query)
    {
        return $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    /**
     * Scope for this month
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
                     ->whereYear('created_at', now()->year);
    }

    /**
     * Log a download attempt
     */
    public static function log(array $data): self
    {
        return self::create([
            'url' => $data['url'],
            'shortcode' => $data['shortcode'] ?? null,
            'media_type' => $data['media_type'] ?? null,
            'status' => $data['status'] ?? 'pending',
            'strategy_used' => $data['strategy_used'] ?? null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'error_message' => $data['error_message'] ?? null,
            'media_count' => $data['media_count'] ?? 0,
        ]);
    }

    /**
     * Get download stats
     */
    public static function stats(): array
    {
        return [
            'today' => self::today()->count(),
            'today_success' => self::today()->successful()->count(),
            'week' => self::thisWeek()->count(),
            'month' => self::thisMonth()->count(),
            'total' => self::count(),
            'success_rate' => self::count() > 0 
                ? round((self::successful()->count() / self::count()) * 100, 1) 
                : 0,
        ];
    }
}
