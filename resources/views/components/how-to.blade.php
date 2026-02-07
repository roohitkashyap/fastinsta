<!-- Voice Search Optimized How-To Component -->
@props([
    'steps' => [],
    'title' => 'How To Download',
    'gradient' => 'from-brand-500 to-pink-500'
])

<section class="py-16 bg-gray-50" itemscope itemtype="https://schema.org/HowTo">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-12" itemprop="name">{{ $title }}</h2>
        <meta itemprop="description" content="Step by step guide to download Instagram content">
        
        <div class="space-y-6">
            @foreach($steps as $index => $step)
            <div class="flex items-start gap-4 bg-white p-6 rounded-2xl shadow-sm border border-gray-100" 
                 itemscope itemprop="step" itemtype="https://schema.org/HowToStep">
                <meta itemprop="position" content="{{ $index + 1 }}">
                
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br {{ $gradient }} flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                    {{ $index + 1 }}
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1" itemprop="name">{{ $step['title'] }}</h3>
                    <p class="text-gray-600" itemprop="text">{{ $step['description'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
