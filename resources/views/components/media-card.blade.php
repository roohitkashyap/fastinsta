<!-- Media Card Component -->
@props([
    'media' => [],
    'index' => 0
])

<div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden group">
    <!-- Media Preview -->
    <div class="relative aspect-square bg-gray-100 overflow-hidden">
        @if($media['type'] === 'video')
            <video 
                x-ref="video{{ $index }}"
                src="{{ $media['url'] }}"
                poster="{{ $media['thumbnail'] ?? '' }}"
                class="w-full h-full object-cover"
                preload="metadata"
                muted
            ></video>
            <div class="absolute inset-0 flex items-center justify-center">
                <button @click="$refs.video{{ $index }}.paused ? $refs.video{{ $index }}.play() : $refs.video{{ $index }}.pause()"
                        class="w-16 h-16 bg-black/60 rounded-full flex items-center justify-center hover:bg-black/80 transition">
                    <svg class="w-8 h-8 text-white pl-1" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z"/>
                    </svg>
                </button>
            </div>
        @else
            <img src="{{ $media['url'] }}" alt="Instagram Media {{ $index + 1 }}" class="w-full h-full object-cover">
        @endif
        
        <!-- Type Badge -->
        <div class="absolute top-3 left-3">
            <span class="px-2.5 py-1 text-xs font-semibold uppercase rounded-full 
                {{ $media['type'] === 'video' ? 'bg-purple-500 text-white' : 'bg-blue-500 text-white' }}">
                {{ $media['type'] }}
            </span>
        </div>
    </div>
    
    <!-- Download Button -->
    <div class="p-4">
        <a href="{{ $media['url'] }}" 
           download="instagram_{{ $index + 1 }}.{{ $media['type'] === 'video' ? 'mp4' : 'jpg' }}"
           class="w-full inline-flex items-center justify-center px-4 py-3 text-sm font-semibold text-white gradient-bg rounded-xl hover:opacity-90 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            Download {{ ucfirst($media['type']) }}
        </a>
    </div>
</div>
