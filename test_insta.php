<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$service = new App\Services\Instagram\InstagramService();
// Failing image post
$url = 'https://www.instagram.com/p/DTsoan8jc_Z/';

echo "Testing URL: $url\n";
$result = $service->download($url);

echo "Success: " . ($result->success ? 'YES' : 'NO') . "\n";
echo "Strategy: " . $result->strategyUsed . "\n";
echo "Error: " . $result->error . "\n";
echo "Media Count: " . count($result->media) . "\n";

if ($result->success) {
    echo "Media 1 URL: " . $result->media[0]->url . "\n";
    echo "Media 1 Type: " . $result->media[0]->type . "\n";
}
