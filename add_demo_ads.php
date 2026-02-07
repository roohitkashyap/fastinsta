<?php

/**
 * Add Demo Ads Script
 * Run with: php artisan tinker < add_demo_ads.php
 */

use App\Models\AdSlot;
use Illuminate\Support\Facades\Cache;

// Clear cache
Cache::forget('ad_slots_active');
Cache::forget('ad_slots_active_by_position');

// Demo Ad HTML Templates
$demoAds = [
    'header' => '
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 12px; text-align: center; border-radius: 8px; margin: 8px 0;">
            <p style="color: white; font-size: 14px; margin: 0; font-weight: 600;">📢 Demo Header Ad - 728x90</p>
            <p style="color: rgba(255,255,255,0.9); font-size: 12px; margin: 4px 0 0px;">Premium advertising space</p>
        </div>
    ',
   
    'belowHero' => '
        <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); padding: 20px; text-align: center; border-radius: 12px; margin: 16px 0;">
            <p style="color: white; font-size: 16px; margin: 0; font-weight: 700;">🎯 Demo Below Hero Ad - 970x90</p>
            <p style="color: rgba(255,255,255,0.95); font-size: 14px; margin: 8px 0 0;">High-visibility banner placement</p>
        </div>
    ',
    
    'sidebar' => '
        <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); padding: 16px; text-align: center; border-radius: 10px; margin: 12px 0;">
            <p style="color: white; font-size: 14px; margin: 0; font-weight: 600;">📱 Demo Sidebar Ad</p>
            <p style="color: rgba(255,255,255,0.9); font-size: 13px; margin: 6px 0 0;">300x250 / 300x600</p>
        </div>
    ',
    
    'sidebarSticky' => '
        <div style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); padding: 16px; text-align: center; border-radius: 10px; margin: 12px 0; position: sticky; top: 80px;">
            <p style="color: white; font-size: 14px; margin: 0; font-weight: 600;">📌 Demo Sidebar Sticky</p>
            <p style="color: rgba(255,255,255,0.9); font-size: 13px; margin: 6px 0 0;">Stays visible on scroll</p>
        </div>
    ',
    
    'beforeResults' => '
        <div style="background: linear-gradient(135deg, #30cfd0 0%, #330867 100%); padding: 18px; text-align: center; border-radius: 12px; margin: 16px 0;">
            <p style="color: white; font-size: 15px; margin: 0; font-weight: 600;">⬆️ Demo Before Results Ad</p>
            <p style="color: rgba(255,255,255,0.95); font-size: 13px; margin: 6px 0 0;">Shown before download results</p>
        </div>
    ',
    
    'afterResults' => '
        <div style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); padding: 18px; text-align: center; border-radius: 12px; margin: 16px 0;">
            <p style="color: #333; font-size: 15px; margin: 0; font-weight: 600;">⬇️ Demo After Results Ad</p>
            <p style="color: #555; font-size: 13px; margin: 6px 0 0;">Shown after download results</p>
        </div>
    ',
    
    'inArticle' => '
        <div style="background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%); padding: 16px; text-align: center; border-radius: 10px; margin: 20px 0;">
            <p style="color: #333; font-size: 14px; margin: 0; font-weight: 600;">📝 Demo In-Article Ad</p>
            <p style="color: #555; font-size: 13px; margin: 6px 0 0;">Embedded in content</p>
        </div>
    ',
    
    'footer' => '
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 12px; text-align: center; border-radius: 8px; margin: 8px 0;">
            <p style="color: white; font-size: 14px; margin: 0; font-weight: 600;">📍 Demo Footer Ad - 728x90</p>
            <p style="color: rgba(255,255,255,0.9); font-size: 12px; margin: 4px 0 0;">Bottom placement</p>
        </div>
    ',
];

// Update ad slots with demo content
$updates = [
    ['position' => 'header', 'code' => $demoAds['header']],
    ['position' => 'below_hero', 'code' => $demoAds['belowHero']],
    ['position' => 'sidebar', 'code' => $demoAds['sidebar']],
    ['position' => 'sidebar_sticky', 'code' => $demoAds['sidebarSticky']],
    ['position' => 'before_results', 'code' => $demoAds['beforeResults']],
    ['position' => 'after_results', 'code' => $demoAds['afterResults']],
    ['position' => 'content', 'code' => $demoAds['inArticle']],
    ['position' => 'footer', 'code' => $demoAds['footer']],
];

echo "Adding demo ads to all ad slots...\n\n";

foreach ($updates as $update) {
    $slot = AdSlot::where('position', $update['position'])->first();
    
    if ($slot) {
        $slot->code = $update['code'];
        $slot->is_active = true;
        $slot->save();
        echo "✅ Updated: {$slot->name} ({$update['position']})\n";
    } else {
        echo "❌ Not found: {$update['position']}\n";
    }
}

echo "\n✨ Demo ads added successfully!\n";
echo "🔄 Cache cleared automatically.\n";
