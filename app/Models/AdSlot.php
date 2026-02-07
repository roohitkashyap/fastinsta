<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class AdSlot extends Model
{
    protected $fillable = [
        'name',
        'label',
        'code',
        'position',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Clear cache when ad slot is updated
     */
    protected static function boot()
    {
        parent::boot();

        static::saved(function () {
            Cache::forget('ad_slots_active');
            Cache::forget('ad_slots_active_by_position');
        });

        static::deleted(function () {
            Cache::forget('ad_slots_active');
            Cache::forget('ad_slots_active_by_position');
        });
    }

    /**
     * Scope for active slots only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get active ad by name (NO CACHE - always fresh from DB)
     */
    public static function getByName(string $name): ?self
    {
        return self::where('name', $name)
                   ->where('is_active', true)
                   ->first();
    }

    /**
     * Get active ad by position (NO CACHE - always fresh from DB)
     */
    public static function getByPosition(string $position): ?self
    {
        return self::where('position', $position)
                   ->where('is_active', true)
                   ->first();
    }

    /**
     * Render ad code if active
     */
    public static function render(string $name): string
    {
        $slot = self::getByName($name);

        if (!$slot || empty($slot->code)) {
            return '';
        }

        return '<div class="sf-widget sf-widget-' . $name . '" data-name="' . $name . '" style="display: block !important; visibility: visible !important; opacity: 1 !important;">' 
             . $slot->code 
             . '</div>';
    }
}
