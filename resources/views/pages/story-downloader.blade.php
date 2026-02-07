@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden">
    <div class="absolute inset-0 gradient-bg opacity-5"></div>
    <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-orange-500/20 to-yellow-500/20 rounded-full blur-3xl"></div>
    
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
        <div class="text-center mb-10">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-900 mb-4">
                {{ $seo['h1'] ?? 'Instagram Story Downloader' }}
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Download Instagram Stories before they disappear. Save photos and videos from public stories.
            </p>
        </div>

        <div class="bg-white rounded-3xl shadow-2xl p-6 sm:p-8 border border-gray-100">
            @include('components.downloader')
        </div>

        <div class="flex flex-wrap justify-center gap-3 mt-8">
            @foreach(['Photos & Videos', 'Save Before Expire', 'Anonymous View', 'No Login Required'] as $feature)
            <span class="inline-flex items-center px-4 py-2 rounded-full bg-white shadow-sm border border-gray-100 text-sm font-medium text-gray-700">
                <svg class="w-4 h-4 mr-2 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
                {{ $feature }}
            </span>
            @endforeach
        </div>
    </div>
</section>

<div class="max-w-4xl mx-auto px-4 py-4">
    {!! \App\Models\AdSlot::render('below_hero') !!}
</div>

<!-- How To Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">How to Download Instagram Stories</h2>
        
        <div class="space-y-6">
            @foreach([
                ['step' => '1', 'title' => 'Get Story URL', 'desc' => 'Open Instagram, go to the profile with the story, and copy the story link from your browser.'],
                ['step' => '2', 'title' => 'Paste URL Here', 'desc' => 'Enter the story URL in the download box and click the Download button.'],
                ['step' => '3', 'title' => 'Save Story', 'desc' => 'Download the story photo or video before it expires after 24 hours.']
            ] as $item)
            <div class="flex items-start gap-4 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-orange-500 to-yellow-500 flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
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
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Story Download FAQ</h2>
        
        <div x-data="{ open: null }" class="space-y-4">
            @foreach([
                ['q' => 'Can I download stories anonymously?', 'a' => 'Yes, the story owner will not know you downloaded their story through our service.'],
                ['q' => 'Do stories expire here too?', 'a' => 'No! Once downloaded, the story is saved permanently on your device.'],
                ['q' => 'Can I download Highlights?', 'a' => 'Yes, you can download both active stories and saved highlights from public profiles.'],
                ['q' => 'Why cant I download some stories?', 'a' => 'Stories from private accounts cannot be downloaded without logging in.']
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
    "name": "Instagram Story Downloader",
    "description": "Download Instagram Stories before they expire"
}
</script>
@endpush
@endsection
