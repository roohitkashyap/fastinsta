@extends('layouts.app')

@section('content')
<article class="py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Featured Image -->
        @if($article->featured_image)
        <img src="{{ asset('storage/' . $article->featured_image) }}" 
             alt="{{ $article->title }}"
             class="w-full h-64 md:h-96 object-cover rounded-2xl mb-8">
        @endif

        <!-- Header -->
        <header class="mb-8">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                {{ $article->title }}
            </h1>
            
            <div class="flex items-center gap-4 text-gray-500">
                <time datetime="{{ $article->published_at?->toIso8601String() }}">
                    {{ $article->published_at?->format('F d, Y') }}
                </time>
                <span>•</span>
                <span>{{ number_format($article->views_count) }} views</span>
            </div>
        </header>

        <!-- Ad -->
        <div class="mb-8">
            {!! \App\Models\AdSlot::render('before_results') !!}
        </div>

        <!-- Content -->
        <div class="prose prose-lg max-w-none prose-headings:text-gray-900 prose-a:text-brand-500 prose-img:rounded-xl">
            {!! $article->content !!}
        </div>

        <!-- Ad -->
        <div class="my-8">
            {!! \App\Models\AdSlot::render('after_results') !!}
        </div>

        <!-- Share -->
        <div class="border-t border-gray-200 pt-8 mt-8">
            <h3 class="text-lg font-semibold mb-4">Share this article</h3>
            <div class="flex gap-3">
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($article->title) }}"
                   target="_blank"
                   class="p-3 bg-gray-100 hover:bg-gray-200 rounded-xl transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/>
                    </svg>
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                   target="_blank"
                   class="p-3 bg-gray-100 hover:bg-gray-200 rounded-xl transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/>
                    </svg>
                </a>
                <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . request()->url()) }}"
                   target="_blank"
                   class="p-3 bg-gray-100 hover:bg-gray-200 rounded-xl transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Back to Blog -->
        <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 mt-8 text-brand-500 hover:text-brand-600 font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Blog
        </a>
    </div>
</article>

@push('schema')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "Article",
    "headline": "{{ $article->title }}",
    "datePublished": "{{ $article->published_at?->toIso8601String() }}",
    "dateModified": "{{ $article->updated_at->toIso8601String() }}",
    "author": {
        "@@type": "Organization",
        "name": "FastInsta"
    }
}
</script>
@endpush
@endsection
