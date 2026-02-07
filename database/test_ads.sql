-- Test Ad Codes for All 8 Positions
-- Run this in admin panel or tinker to add test ad codes

-- 1. Header Banner (Sticky Top Ad)
UPDATE ad_slots SET code = '
<div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 12px 20px; text-align: center; color: white; font-weight: bold; border-radius: 8px; margin: 10px 0;">
    📢 HEADER AD SPACE - Perfect for announcements or promotions
</div>
' WHERE name = 'header_banner';

-- 2. Below Hero (After Main CTA)
UPDATE ad_slots SET code = '
<div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); padding: 20px; text-align: center; color: white; border-radius: 12px; margin: 20px 0; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
    <h3 style="margin: 0 0 10px 0; font-size: 20px;">💎 Premium Feature</h3>
    <p style="margin: 0; opacity: 0.9;">Below Hero Ad Slot - High visibility placement</p>
</div>
' WHERE name = 'below_hero';

-- 3. Sidebar Top (Right Side Ad)
UPDATE ad_slots SET code = '
<div style="background: #ffffff; border: 2px solid #667eea; padding: 20px; border-radius: 10px; margin: 15px 0; text-align: center;">
    <div style="background: #667eea; color: white; padding: 8px; border-radius: 6px; margin-bottom: 12px; font-weight: bold;">
        🎨 SIDEBAR TOP
    </div>
    <p style="margin: 0; color: #333; font-size: 14px;">300x250 Ad Space<br>Sticky sidebar placement</p>
</div>
' WHERE name = 'sidebar_top';

-- 4. Sidebar Sticky (Follows scroll)
UPDATE ad_slots SET code = '
<div style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); padding: 15px; border-radius: 10px; text-align: center; color: #333; font-weight: 600;">
    📌 STICKY SIDEBAR<br/>
    <small style="opacity: 0.8;">Follows user scroll</small>
</div>
' WHERE name = 'sidebar_sticky';

-- 5. Before Download Results
UPDATE ad_slots SET code = '
<div style="background: #f7fafc; border-left: 4px solid #48bb78; padding: 16px 20px; margin: 20px 0; border-radius: 6px;">
    <div style="display: flex; align-items: center; gap: 10px;">
        <span style="font-size: 24px;">✅</span>
        <div>
            <strong style="color: #2d3748;">Before Results Ad</strong>
            <p style="margin: 5px 0 0 0; font-size: 13px; color: #718096;">Perfect for related offers</p>
        </div>
    </div>
</div>
' WHERE name = 'before_results';

-- 6. After Download Results
UPDATE ad_slots SET code = '
<div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); padding: 20px; border-radius: 12px; text-align: center; color: white; margin: 20px 0;">
    <div style="font-size: 28px; margin-bottom: 8px;">🎯</div>
    <strong>After Results Ad Slot</strong>
    <p style="margin: 8px 0 0 0; opacity: 0.9; font-size: 14px;">User just downloaded - high engagement!</p>
</div>
' WHERE name = 'after_results';

-- 7. In Article Content
UPDATE ad_slots SET code = '
<div style="background: #fff3cd; border: 1px solid #ffc107; padding: 15px; border-radius: 8px; margin: 20px 0; text-align: center;">
    <strong style="color: #856404;">📰 IN-ARTICLE AD</strong>
    <p style="margin: 8px 0 0 0; color: #856404; font-size: 14px;">Embedded within blog content</p>
</div>
' WHERE name = 'in_article';

-- 8. Footer Banner (Bottom of page)
UPDATE ad_slots SET code = '
<div style="background: linear-gradient(135deg, #89f7fe 0%, #66a6ff 100%); padding: 16px 20px; text-align: center; color: white; font-weight: bold; border-radius: 10px 10px 0 0;">
    🔥 FOOTER BANNER - Last impression before user leaves
</div>
' WHERE name = 'footer_banner';
