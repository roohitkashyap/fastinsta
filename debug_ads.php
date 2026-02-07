<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$slots = App\Models\AdSlot::whereIn('position', ['header', 'below_hero', 'before_results', 'footer'])->get();

foreach ($slots as $slot) {
    echo "Position: " . $slot->position . "\n";
    echo "Active: " . ($slot->is_active ? 'YES' : 'NO') . "\n";
    echo "Length: " . strlen($slot->code) . "\n";
    echo "Substr(0, 100): " . substr($slot->code, 0, 100) . "\n";
    echo "----------------------------------------\n";
}
