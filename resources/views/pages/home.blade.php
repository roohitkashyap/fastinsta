@extends('layouts.app')

@section('content')
<!-- Background Gradient -->
<div class="fixed inset-0 z-0 overflow-hidden pointer-events-none">
    <div class="absolute inset-0 bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50"></div>
</div>


<!-- Hero Section -->
<section class="relative z-10">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
        
        <!-- Title -->
        <div class="text-center mb-8">
            <h1 class="text-3xl sm:text-5xl font-bold bg-gradient-to-r from-purple-600 via-pink-500 to-blue-600 bg-clip-text text-transparent mb-4 animate-gradient-x">
                Instagram Downloader
            </h1>
            <p class="text-base sm:text-lg text-gray-700 max-w-2xl mx-auto">
                Download videos, reels, photos & stories in HD quality. Fast, free, and secure.
            </p>
        </div>

        <!-- Tabs -->
        <div class="flex justify-center mb-6">
            <div x-data="{ activeTab: 'all' }" class="inline-flex bg-white/70 backdrop-blur-md rounded-2xl p-1.5 shadow-lg border border-gray-200/50">
                <button @click="activeTab = 'all'" 
                    :class="activeTab === 'all' ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white' : 'text-gray-600'"
                    class="px-5 py-2.5 rounded-xl font-semibold text-sm transition">All</button>
                <button @click="activeTab = 'video'" 
                    :class="activeTab === 'video' ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white' : 'text-gray-600'"
                    class="px-5 py-2.5 rounded-xl font-semibold text-sm transition">Video</button>
                <button @click="activeTab = 'reels'" 
                    :class="activeTab === 'reels' ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white' : 'text-gray-600'"
                    class="px-5 py-2.5 rounded-xl font-semibold text-sm transition">Reels</button>
                <button @click="activeTab = 'stories'" 
                    :class="activeTab === 'stories' ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white' : 'text-gray-600'"
                    class="px-5 py-2.5 rounded-xl font-semibold text-sm transition">Stories</button>
            </div>
        </div>

        <!-- Downloader Box -->
        <div class="glass-card-strong rounded-3xl shadow-2xl p-6 sm:p-8 border border-white/50">
            @include('components.downloader')
        </div>

        <!-- Below Hero Ad -->
        <x-ad-slot position="below_hero" class="my-6" />

        <!-- Supported Types Pills -->
        <div class="flex flex-wrap justify-center gap-3 mt-8">
            @foreach(['Videos', 'Reels', 'Photos', 'Stories', 'IGTV', 'Carousel'] as $type)
            <span class="px-4 py-2 rounded-full glass-card text-sm font-semibold text-gray-800 hover:scale-105 transition">
                <svg class="w-4 h-4 mr-2 text-green-500 inline-block" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
                {{ $type }}
            </span>
            @endforeach
        </div>
    </div>
</section>

<!-- Before Results Ad -->
<x-ad-slot position="before_results" class="my-6" style="border: 5px solid blue; padding: 20px; background: lightgreen;" />

<!-- Features Section -->
<section class="relative z-10 py-16 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent mb-12">
            ⚡ Powerful Features
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="glass-card p-8 rounded-3xl text-center hover:shadow-2xl transition card-3d">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center mb-6 mx-auto">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">HD Quality</h3>
                <p class="text-gray-600">Download in original high-definition quality</p>
            </div>

            <div class="glass-card p-8 rounded-3xl text-center hover:shadow-2xl transition card-3d">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center mb-6 mx-auto">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Super Fast</h3>
                <p class="text-gray-600">Lightning-fast downloads with optimized servers</p>
            </div>

            <div class="glass-card p-8 rounded-3xl text-center hover:shadow-2xl transition card-3d">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-500 rounded-2xl flex items-center justify-center mb-6 mx-auto">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">100% Safe</h3>
                <p class="text-gray-600">Secure downloads with no data collection</p>
            </div>
        </div>
    </div>
</section>

<!-- How To Guide -->
@include('components.how-to')

<!-- Trending Downloads Section - Functional -->
<section class="relative z-10 py-16 bg-gradient-to-br from-purple-50 to-pink-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent mb-12">
            🔥 Trending Downloads
        </h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6" x-data="{
            trendingItems: [
                { id: 1, title: 'Fitness Motivation', type: 'Reel', views: '2.5M', gradient: 'from-red-400 to-orange-400' },
                { id: 2, title: 'Travel Vlog', type: 'Video', views: '1.8M', gradient: 'from-blue-400 to-cyan-400' },
                { id: 3, title: 'Recipe Tutorial', type: 'Carousel', views: '950K', gradient: 'from-green-400 to-emerald-400' },
                { id: 4, title: 'Daily Highlights', type: 'Story', views: '650K', gradient: 'from-purple-400 to-pink-400' },
                { id: 5, title: 'Tech Review', type: 'IGTV', views: '580K', gradient: 'from-indigo-400 to-purple-400' },
                { id: 6, title: 'Fashion Show', type: 'Reel', views: '420K', gradient: 'from-pink-400 to-rose-400' },
                { id: 7, title: 'Music Cover', type: 'Video', views: '320K', gradient: 'from-yellow-400 to-orange-400' },
                { id: 8, title: 'Art Process', type: 'Reel', views: '280K', gradient: 'from-teal-400 to-cyan-400' }
            ],
            scrollToDownloader() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }">
            <template x-for="item in trendingItems" :key="item.id">
                <div @click="scrollToDownloader()" 
                    class="glass-card rounded-2xl overflow-hidden hover:shadow-2xl transition-all duration-300 cursor-pointer transform hover:-translate-y-2 group">
                    <!-- Thumbnail with gradient -->
                    <div class="aspect-square relative overflow-hidden" :class="'bg-gradient-to-br ' + item.gradient">
                        <!-- Play Icon Overlay -->
                        <div class="absolute inset-0 flex items-center justify-center bg-black/20 group-hover:bg-black/40 transition">
                            <div class="w-16 h-16 rounded-full bg-white/90 flex items-center justify-center transform group-hover:scale-110 transition">
                                <svg class="w-8 h-8 text-purple-600 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Type Badge -->
                        <div class="absolute top-3 left-3">
                            <span class="px-3 py-1 rounded-full text-xs font-bold text-white bg-black/50 backdrop-blur-sm" x-text="item.type"></span>
                        </div>
                        
                        <!-- Download Count Badge -->
                        <div class="absolute top-3 right-3">
                            <span class="px-3 py-1 rounded-full text-xs font-bold text-white bg-black/50 backdrop-blur-sm">
                                <svg class="w-3 h-3 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                                <span x-text="item.views"></span>
                            </span>
                        </div>
                    </div>
                    
                    <!-- Card Info -->
                    <div class="p-4 bg-white">
                        <p class="font-semibold text-gray-900 truncate mb-1" x-text="item.title"></p>
                        <div class="flex items-center justify-between text-sm text-gray-600">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                </svg>
                                <span x-text="item.views"></span>
                            </span>
                            <span class="text-purple-600 font-medium group-hover:underline">Download →</span>
                        </div>
                    </div>
                </div>
            </template>
        </div>
        
        <!-- View All Button -->
        <div class="text-center mt-10">
            <button @click="scrollToDownloader()" class="px-8 py-3 bg-gradient-to-r from-purple-600 to-pink-500 text-white font-bold rounded-2xl hover:shadow-xl transition">
                Start Downloading
            </button>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="relative z-10 py-16 bg-gradient-to-r from-purple-600 via-pink-500 to-blue-600 text-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-4xl font-bold mb-2">10M+</div>
                <div class="text-purple-100">Downloads</div>
            </div>
            <div>
                <div class="text-4xl font-bold mb-2">500K+</div>
                <div class="text-purple-100">Happy Users</div>
            </div>
            <div>
                <div class="text-4xl font-bold mb-2">99.9%</div>
                <div class="text-purple-100">Uptime</div>
            </div>
            <div>
                <div class="text-4xl font-bold mb-2">24/7</div>
                <div class="text-purple-100">Support</div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="relative z-10 py-16 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent mb-12">
            💬 What Users Say
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach([
                ['name' => 'Sarah M.', 'text' => 'Best Instagram downloader I&#39;ve used! Super fast and easy to use.', 'rating' => 5],
                ['name' => 'John D.', 'text' => 'Love the HD quality downloads. Works perfectly every time!', 'rating' => 5],
                ['name' => 'Emily R.', 'text' => 'Clean interface and no annoying ads. Highly recommended!', 'rating' => 5]
            ] as $testimonial)
            <div class="glass-card p-6 rounded-2xl">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white font-bold text-lg">
                        {{ substr($testimonial['name'], 0, 1) }}
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">{{ $testimonial['name'] }}</p>
                        <div class="flex text-yellow-400">
                            @for($i = 0; $i < $testimonial['rating']; $i++)
                            ⭐
                            @endfor
                        </div>
                    </div>
                </div>
                <p class="text-gray-600 italic">"{{ $testimonial['text'] }}"</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- FAQ Section -->
@include('components.faq')

<!-- CTA Section -->
<section class="relative z-10 py-16 bg-gradient-to-br from-purple-100 to-pink-100">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Ready to Download?</h2>
        <p class="text-lg text-gray-600 mb-8">Start downloading Instagram content in HD quality now!</p>
        <a href="#top" class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-purple-600 to-pink-500 text-white font-bold rounded-2xl hover:shadow-2xl transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            Get Started Free
        </a>
    </div>
</section>

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Organization",
  "name": "FastInsta",
  "url": "{{ url('/') }}",
  "logo": "{{ asset('icons/icon-512.png') }}",
  "description": "Free Instagram video, photo, reels, and story downloader in HD quality",
  "sameAs": [
    "https://facebook.com/fastinsta",
    "https://twitter.com/fastinsta",
    "https://instagram.com/fastinsta"
  ]
}
</script>

<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "WebSite",
  "name": "FastInsta",
  "url": "{{ url('/') }}",
  "potentialAction": {
    "@@type": "SearchAction",
    "target": "{{ url('/') }}?url={search_term_string}",
    "query-input": "required name=search_term_string"
  }
}
</script>

<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "SoftwareApplication",
  "name": "FastInsta - Instagram Downloader",
  "applicationCategory": "MultimediaApplication",
  "operatingSystem": "Web Browser",
  "offers": {
    "@@type": "Offer",
    "price": "0",
    "priceCurrency": "USD"
  },
  "aggregateRating": {
    "@@type": "AggregateRating",
    "ratingValue": "4.8",
    "ratingCount": "12500"
  }
}
</script>
@endpush

@endsection
