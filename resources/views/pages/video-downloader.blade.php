@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden">
    <div class="absolute inset-0 gradient-bg opacity-5"></div>
    <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-full blur-3xl"></div>
    
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
        <div class="text-center mb-10">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-900 mb-4">
                {{ $seo['h1'] ?? 'Instagram Video Downloader' }}
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Download Instagram videos in HD quality. Save any video from Instagram posts to your device for free.
            </p>
        </div>

        <div class="bg-white rounded-3xl shadow-2xl p-6 sm:p-8 border border-gray-100">
            @include('components.downloader')
        </div>

        <div class="flex flex-wrap justify-center gap-3 mt-8">
            @foreach(['MP4 Format', 'HD Quality', 'No Watermark', 'Fast Download'] as $feature)
            <span class="inline-flex items-center px-4 py-2 rounded-full bg-white shadow-sm border border-gray-100 text-sm font-medium text-gray-700">
                <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
                {{ $feature }}
            </span>
            @endforeach
        </div>
    </div>
</section>

<!-- Ad -->
<div class="max-w-4xl mx-auto px-4 py-4">
    {!! \App\Models\AdSlot::render('below_hero') !!}
</div>

<!-- How To Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">How to Download Instagram Videos</h2>
        
        <div class="space-y-6">
            @foreach([
                ['step' => '1', 'title' => 'Copy the Video URL', 'desc' => 'Open Instagram and find the video you want to download. Tap the three dots and select "Copy Link".'],
                ['step' => '2', 'title' => 'Paste URL Above', 'desc' => 'Paste the copied video URL into the input field above and click the Download button.'],
                ['step' => '3', 'title' => 'Save to Device', 'desc' => 'Preview the video and click Download to save the MP4 file directly to your device.']
            ] as $item)
            <div class="flex items-start gap-4 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <div class="w-12 h-12 rounded-xl gradient-bg flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                    {{ $item['step'] }}
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $item['title'] }}</h3>
                    <p class="text-gray-600">{{ $item['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-16 bg-white">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Video Download FAQ</h2>
        
        <div x-data="{ open: null }" class="space-y-4">
            @foreach([
                ['q' => 'What video quality can I download?', 'a' => 'We provide the highest quality available - typically 1080p HD for most Instagram videos.'],
                ['q' => 'Can I download private videos?', 'a' => 'No, only public Instagram videos can be downloaded. Private accounts require login which we do not support.'],
                ['q' => 'Is there a video length limit?', 'a' => 'No limit! You can download Instagram videos of any length, including long IGTV content.'],
                ['q' => 'What format are videos downloaded in?', 'a' => 'All videos are downloaded in MP4 format, which is compatible with all devices and players.']
            ] as $index => $faq)
            <div class="border border-gray-200 rounded-xl overflow-hidden">
                <button @click="open = open === {{ $index }} ? null : {{ $index }}"
                        class="w-full text-left px-6 py-4 flex items-center justify-between bg-white hover:bg-gray-50 transition">
                    <span class="font-medium text-gray-900">{{ $faq['q'] }}</span>
                    <svg :class="{ 'rotate-180': open === {{ $index }} }" class="w-5 h-5 text-gray-500 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open === {{ $index }}" x-collapse x-cloak class="px-6 pb-4 text-gray-600">
                    {{ $faq['a'] }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@push('schema')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "WebPage",
    "name": "Instagram Video Downloader",
    "description": "Download Instagram videos in HD quality for free"
}
</script>
@endpush
@endsection
