<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proxy extends Model
{
    protected $fillable = [
        'address',
        'credentials',
        'type',
        'status',
        'fail_count',
        'success_count',
        'last_used_at',
        'banned_until',
    ];

    protected $casts = [
        'fail_count' => 'integer',
        'success_count' => 'integer',
        'last_used_at' => 'datetime',
        'banned_until' => 'datetime',
    ];

    const MAX_FAIL_COUNT = 3;
    const BAN_DURATION_MINUTES = 30;

    /**
     * Scope for active proxies
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for available proxies (not banned, not cooling)
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'active')
                     ->where(function ($q) {
                         $q->whereNull('banned_until')
                           ->orWhere('banned_until', '<', now());
                     });
    }

    /**
     * Get next available proxy (round-robin)
     */
    public static function getNext(): ?self
    {
        return self::available()
                   ->orderBy('last_used_at', 'asc')
                   ->orderBy('success_count', 'desc')
                   ->first();
    }

    /**
     * Mark proxy as used
     */
    public function markUsed(): void
    {
        $this->update(['last_used_at' => now()]);
    }

    /**
     * Record success
     */
    public function recordSuccess(): void
    {
        $this->update([
            'success_count' => $this->success_count + 1,
            'fail_count' => 0,
            'status' => 'active',
        ]);
    }

    /**
     * Record failure and potentially ban
     */
    public function recordFailure(): void
    {
        $failCount = $this->fail_count + 1;

        if ($failCount >= self::MAX_FAIL_COUNT) {
            $this->update([
                'fail_count' => $failCount,
                'status' => 'banned',
                'banned_until' => now()->addMinutes(self::BAN_DURATION_MINUTES),
            ]);
        } else {
            $this->update(['fail_count' => $failCount]);
        }
    }

    /**
     * Get Guzzle proxy config
     */
    public function toGuzzleConfig(): array
    {
        $proxy = $this->address;

        if ($this->credentials) {
            [$user, $pass] = explode(':', $this->credentials, 2);
            $proxy = "{$user}:{$pass}@{$this->address}";
        }

        $scheme = match($this->type) {
            'socks4' => 'socks4',
            'socks5' => 'socks5',
            default => 'http',
        };

        return [
            'proxy' => "{$scheme}://{$proxy}",
        ];
    }

    /**
     * Unban expired proxies (run via scheduler)
     */
    public static function unbanExpired(): int
    {
        return self::where('status', 'banned')
                   ->where('banned_until', '<', now())
                   ->update([
                       'status' => 'active',
                       'fail_count' => 0,
                       'banned_until' => null,
                   ]);
    }
}
