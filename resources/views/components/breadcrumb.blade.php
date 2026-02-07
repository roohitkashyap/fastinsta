<!-- Breadcrumb Navigation with Schema -->
@props([
    'items' => []
])

<nav aria-label="Breadcrumb" class="py-4 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <ol class="flex items-center space-x-2 text-sm" itemscope itemtype="https://schema.org/BreadcrumbList">
        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-purple-600 transition" itemprop="item">
                <span itemprop="name">Home</span>
            </a>
            <meta itemprop="position" content="1">
        </li>
        
        @foreach($items as $index => $item)
            <li class="flex items-center" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <svg class="w-4 h-4 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
                
                @if($loop->last)
                    <span class="text-gray-900 font-medium" itemprop="name">{{ $item['title'] }}</span>
                    <meta itemprop="item" content="{{ $item['url'] ?? url()->current() }}">
                @else
                    <a href="{{ $item['url'] }}" class="text-gray-500 hover:text-purple-600 transition" itemprop="item">
                        <span itemprop="name">{{ $item['title'] }}</span>
                    </a>
                @endif
                
                <meta itemprop="position" content="{{ $index + 2 }}">
            </li>
        @endforeach
    </ol>
</nav>
