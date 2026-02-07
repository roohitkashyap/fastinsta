<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\AdSlot;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@fastinsta.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        );

        // Create default ad slots
        $adSlots = [
            ['name' => 'header_banner', 'label' => 'Header Banner', 'position' => 'header', 'order' => 1],
            ['name' => 'below_hero', 'label' => 'Below Hero Section', 'position' => 'below_hero', 'order' => 2],
            ['name' => 'sidebar_top', 'label' => 'Sidebar Top', 'position' => 'sidebar', 'order' => 3],
            ['name' => 'sidebar_sticky', 'label' => 'Sidebar Sticky', 'position' => 'sidebar', 'order' => 4],
            ['name' => 'before_results', 'label' => 'Before Download Results', 'position' => 'before_results', 'order' => 5],
            ['name' => 'after_results', 'label' => 'After Download Results', 'position' => 'after_results', 'order' => 6],
            ['name' => 'in_article', 'label' => 'In Article Content', 'position' => 'content', 'order' => 7],
            ['name' => 'footer_banner', 'label' => 'Footer Banner', 'position' => 'footer', 'order' => 8],
        ];

        foreach ($adSlots as $slot) {
            AdSlot::firstOrCreate(['name' => $slot['name']], $slot);
        }

        // Create default settings
        $settings = [
            // General
            ['key' => 'site_name', 'value' => 'FastInsta', 'type' => 'text', 'group' => 'general', 'label' => 'Site Name'],
            ['key' => 'site_description', 'value' => 'Free Instagram Video, Reels, Photo & Story Downloader', 'type' => 'textarea', 'group' => 'general', 'label' => 'Site Description'],
            ['key' => 'site_logo', 'value' => '', 'type' => 'image', 'group' => 'general', 'label' => 'Site Logo'],
            ['key' => 'site_favicon', 'value' => '', 'type' => 'image', 'group' => 'general', 'label' => 'Favicon'],
            
            // SEO
            ['key' => 'default_meta_title', 'value' => 'FastInsta - Free Instagram Downloader', 'type' => 'text', 'group' => 'seo', 'label' => 'Default Meta Title'],
            ['key' => 'default_meta_description', 'value' => 'Download Instagram videos, reels, photos, stories and IGTV in HD quality for free.', 'type' => 'textarea', 'group' => 'seo', 'label' => 'Default Meta Description'],
            
            // Analytics
            ['key' => 'google_analytics_id', 'value' => '', 'type' => 'text', 'group' => 'analytics', 'label' => 'Google Analytics ID'],
            ['key' => 'facebook_pixel_id', 'value' => '', 'type' => 'text', 'group' => 'analytics', 'label' => 'Facebook Pixel ID'],
            
            // API
            ['key' => 'rapidapi_key', 'value' => '', 'type' => 'text', 'group' => 'api', 'label' => 'RapidAPI Key'],
            ['key' => 'instagram_session_id', 'value' => '', 'type' => 'textarea', 'group' => 'api', 'label' => 'Instagram Session Cookie'],
            
            // Security
            ['key' => 'turnstile_site_key', 'value' => '', 'type' => 'text', 'group' => 'security', 'label' => 'Cloudflare Turnstile Site Key'],
            ['key' => 'turnstile_secret_key', 'value' => '', 'type' => 'text', 'group' => 'security', 'label' => 'Cloudflare Turnstile Secret Key'],
        ];

        foreach ($settings as $setting) {
            Setting::firstOrCreate(['key' => $setting['key']], $setting);
        }

        $this->command->info('Default admin, ad slots, and settings created!');
        $this->command->info('Admin Login: admin@fastinsta.com / password');
    }
}
