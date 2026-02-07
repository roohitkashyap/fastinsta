@extends('layouts.app')

@section('content')
<div class="py-16">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold text-center text-gray-900 mb-12">Frequently Asked Questions</h1>
        
        <div x-data="{ open: null }" class="space-y-4">
            @foreach([
                ['q' => 'Is FastInsta free to use?', 'a' => 'Yes, FastInsta is completely free to use. There are no hidden fees or premium plans.'],
                ['q' => 'Do I need to create an account?', 'a' => 'No account is required. Simply paste your Instagram URL and download immediately.'],
                ['q' => 'Can I download from private Instagram accounts?', 'a' => 'No, we can only download content from public Instagram profiles. Private content requires login which we do not support for security reasons.'],
                ['q' => 'What types of content can I download?', 'a' => 'You can download Instagram Videos, Reels, Photos, Stories, and IGTV content.'],
                ['q' => 'Is it safe to use FastInsta?', 'a' => 'Absolutely! We do not ask for your Instagram login credentials and we do not store any of the content you download.'],
                ['q' => 'What quality are files downloaded in?', 'a' => 'We always try to download content in the highest quality available - typically 1080p for videos and full resolution for photos.'],
                ['q' => 'Why did my download fail?', 'a' => 'Downloads may fail if the content is from a private account, has been deleted, or if Instagram is temporarily blocking requests. Try again later.'],
                ['q' => 'Can I download multiple photos from a carousel?', 'a' => 'Yes! When you paste a carousel post URL, all photos and videos from that post will be available for download.'],
                ['q' => 'Does FastInsta work on mobile?', 'a' => 'Yes, FastInsta works on all devices including smartphones, tablets, and computers. Just visit our website in your browser.'],
                ['q' => 'Is downloading Instagram content legal?', 'a' => 'Downloading content for personal use is generally acceptable, but you should respect copyright and only use content with permission. Do not re-upload or distribute content without the creator\'s consent.'],
                ['q' => 'Why do I see ads?', 'a' => 'Ads help us keep FastInsta free for everyone. We try to keep ads non-intrusive.'],
                ['q' => 'How can I contact support?', 'a' => 'You can reach us through our Contact page. We typically respond within 24 hours.']
            ] as $index => $faq)
            <div class="border border-gray-200 rounded-xl overflow-hidden">
                <button @click="open = open === {{ $index }} ? null : {{ $index }}"
                        class="w-full text-left px-6 py-4 flex items-center justify-between bg-white hover:bg-gray-50 transition">
                    <span class="font-medium text-gray-900">{{ $faq['q'] }}</span>
                    <svg :class="{ 'rotate-180': open === {{ $index }} }" 
                         class="w-5 h-5 text-gray-500 transition-transform duration-200 flex-shrink-0 ml-4" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open === {{ $index }}" 
                     x-collapse 
                     x-cloak 
                     class="px-6 pb-4 text-gray-600">
                    {{ $faq['a'] }}
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="mt-12 text-center">
            <p class="text-gray-600 mb-4">Still have questions?</p>
            <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 px-6 py-3 gradient-bg text-white font-semibold rounded-xl hover:opacity-90 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                Contact Us
            </a>
        </div>
    </div>
</div>
@endsection
