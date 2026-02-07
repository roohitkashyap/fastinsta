@extends('layouts.app')

@section('content')
<div class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Blog</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Tips, guides, and news about downloading Instagram content
            </p>
        </div>

        <!-- Articles Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($articles as $article)
            <article class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 group hover:shadow-xl transition-shadow">
                @if($article->featured_image)
                <a href="{{ route('blog.show', $article) }}">
                    <img src="{{ asset('storage/' . $article->featured_image) }}" 
                         alt="{{ $article->title }}"
                         class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                </a>
                @else
                <div class="w-full h-48 gradient-bg opacity-20"></div>
                @endif
                
                <div class="p-6">
                    <a href="{{ route('blog.show', $article) }}">
                        <h2 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-brand-500 transition">
                            {{ $article->title }}
                        </h2>
                    </a>
                    
                    @if($article->excerpt)
                    <p class="text-gray-600 line-clamp-3 mb-4">
                        {{ $article->excerpt }}
                    </p>
                    @endif
                    
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <span>{{ $article->published_at?->format('M d, Y') }}</span>
                        <span>{{ number_format($article->views_count) }} views</span>
                    </div>
                </div>
            </article>
            @empty
            <div class="col-span-full text-center py-12">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="text-gray-500 text-lg">No articles published yet.</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($articles->hasPages())
        <div class="mt-12">
            {{ $articles->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Ad -->
<div class="max-w-4xl mx-auto px-4 py-4">
    {!! \App\Models\AdSlot::render('footer_banner') !!}
</div>
@endsection
