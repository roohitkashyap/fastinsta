<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PopulateDemoAds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ads:populate-demo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate all ad slots with colorful demo HTML ads for testing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Populating ad slots with demo content...');
        
        // Clear cache
        \Cache::forget('ad_slots_active');
        \Cache::forget('ad_slots_active_by_position');
        
        // Demo ad HTML templates
        $demoAds = [
            'header' => '<div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 12px; text-align: center; border-radius: 8px; margin: 8px 0;"><p style="color: white; font-size: 14px; margin: 0; font-weight: 600;">📢 Demo Header Ad - 728x90</p><p style="color: rgba(255,255,255,0.9); font-size: 12px; margin: 4px 0 0;">Premium advertising space</p></div>',
            
            'below_hero' => '<div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); padding: 20px; text-align: center; border-radius: 12px; margin: 16px 0;"><p style="color: white; font-size: 16px; margin: 0; font-weight: 700;">🎯 Demo Below Hero Ad - 970x90</p><p style="color: rgba(255,255,255,0.95); font-size: 14px; margin: 8px 0 0;">High-visibility banner placement</p></div>',
            
            'sidebar' => '<div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); padding: 16px; text-align: center; border-radius: 10px; margin: 12px 0;"><p style="color: white; font-size: 14px; margin: 0; font-weight: 600;">📱 Demo Sidebar Ad</p><p style="color: rgba(255,255,255,0.9); font-size: 13px; margin: 6px 0 0;">300x250 / 300x600</p></div>',
            
            'sidebar_sticky' => '<div style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); padding: 16px; text-align: center; border-radius: 10px; margin: 12px 0; position: sticky; top: 80px;"><p style="color: white; font-size: 14px; margin: 0; font-weight: 600;">📌 Demo Sidebar Sticky</p><p style="color: rgba(255,255,255,0.9); font-size: 13px; margin: 6px 0 0;">Stays visible on scroll</p></div>',
            
            'before_results' => '<div style="background: linear-gradient(135deg, #30cfd0 0%, #330867 100%); padding: 18px; text-align: center; border-radius: 12px; margin: 16px 0;"><p style="color: white; font-size: 15px; margin: 0; font-weight: 600;">⬆️ Demo Before Results Ad</p><p style="color: rgba(255,255,255,0.95); font-size: 13px; margin: 6px 0 0;">Shown before download results</p></div>',
            
            'after_results' => '<div style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); padding: 18px; text-align: center; border-radius: 12px; margin: 16px 0;"><p style="color: #333; font-size: 15px; margin: 0; font-weight: 600;">⬇️ Demo After Results Ad</p><p style="color: #555; font-size: 13px; margin: 6px 0 0;">Shown after download results</p></div>',
            
            'content' => '<div style="background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%); padding: 16px; text-align: center; border-radius: 10px; margin: 20px 0;"><p style="color: #333; font-size: 14px; margin: 0; font-weight: 600;">📝 Demo In-Article Ad</p><p style="color: #555; font-size: 13px; margin: 6px 0 0;">Embedded in content</p></div>',
            
            'footer' => '<div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 12px; text-align: center; border-radius: 8px; margin: 8px 0;"><p style="color: white; font-size: 14px; margin: 0; font-weight: 600;">📍 Demo Footer Ad - 728x90</p><p style="color: rgba(255,255,255,0.9); font-size: 12px; margin: 4px 0 0;">Bottom placement</p></div>',
        ];
        
        // Update each ad slot
        foreach ($demoAds as $position => $code) {
            $slot = \App\Models\AdSlot::where('position', $position)->first();
            
            if ($slot) {
                $slot->code = $code;
                $slot->is_active = true;
                $slot->save();
                $this->info("✅ Updated: {$slot->name} ({$position})");
            } else {
                $this->warn("❌ Not found: {$position}");
            }
        }
        
        $this->info("\n✨ Demo ads added successfully!");
        $this->info("🔄 Cache cleared automatically.");
        
        return 0;
    }
}
