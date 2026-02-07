<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
    ];

    /**
     * Clear cache when setting is updated
     */
    protected static function boot()
    {
        parent::boot();

        static::saved(function ($setting) {
            Cache::forget('settings_all');
            Cache::forget('setting_' . $setting->key);
        });
    }

    /**
     * Get setting value by key (cached)
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::remember('setting_' . $key, 3600, function () use ($key, $default) {
            $setting = self::where('key', $key)->first();
            
            if (!$setting) {
                return $default;
            }

            return match ($setting->type) {
                'boolean' => filter_var($setting->value, FILTER_VALIDATE_BOOLEAN),
                'json' => json_decode($setting->value, true),
                default => $setting->value,
            };
        });
    }

    /**
     * Set setting value by key
     */
    public static function set(string $key, mixed $value, string $type = 'text', string $group = 'general'): void
    {
        $storedValue = is_array($value) ? json_encode($value) : (string) $value;
        
        self::updateOrCreate(
            ['key' => $key],
            ['value' => $storedValue, 'type' => $type, 'group' => $group]
        );
    }

    /**
     * Get all settings (cached)
     */
    public static function all($columns = ['*'])
    {
        return Cache::remember('settings_all', 3600, function () use ($columns) {
            return parent::all($columns);
        });
    }

    /**
     * Get settings by group
     */
    public static function byGroup(string $group): array
    {
        $settings = self::where('group', $group)->get();
        
        return $settings->mapWithKeys(function ($setting) {
            return [$setting->key => self::get($setting->key)];
        })->toArray();
    }
}
