<!-- Voice Search Optimized FAQ Component -->
@props([
    'faqs' => [],
    'title' => 'Frequently Asked Questions'
])

<section class="py-16 bg-white" itemscope itemtype="https://schema.org/FAQPage">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">{{ $title }}</h2>
        
        <div x-data="{ open: null }" class="space-y-4">
            @foreach($faqs as $index => $faq)
            <div class="border border-gray-200 rounded-xl overflow-hidden" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                <button @click="open = open === {{ $index }} ? null : {{ $index }}"
                        class="w-full text-left px-6 py-4 flex items-center justify-between bg-white hover:bg-gray-50 transition">
                    <span class="font-medium text-gray-900" itemprop="name">{{ $faq['q'] }}</span>
                    <svg :class="{ 'rotate-180': open === {{ $index }} }" 
                         class="w-5 h-5 text-gray-500 transition-transform duration-200" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open === {{ $index }}" 
                     x-collapse 
                     x-cloak 
                     itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer"
                     class="px-6 pb-4">
                    <p class="text-gray-600" itemprop="text">{{ $faq['a'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
