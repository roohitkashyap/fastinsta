<!-- Voice Search Optimized FAQ Component -->
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'faqs' => [],
    'title' => 'Frequently Asked Questions'
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'faqs' => [],
    'title' => 'Frequently Asked Questions'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<section class="py-16 bg-white" itemscope itemtype="https://schema.org/FAQPage">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-12"><?php echo e($title); ?></h2>
        
        <div x-data="{ open: null }" class="space-y-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <div class="border border-gray-200 rounded-xl overflow-hidden" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                <button @click="open = open === <?php echo e($index); ?> ? null : <?php echo e($index); ?>"
                        class="w-full text-left px-6 py-4 flex items-center justify-between bg-white hover:bg-gray-50 transition">
                    <span class="font-medium text-gray-900" itemprop="name"><?php echo e($faq['q']); ?></span>
                    <svg :class="{ 'rotate-180': open === <?php echo e($index); ?> }" 
                         class="w-5 h-5 text-gray-500 transition-transform duration-200" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open === <?php echo e($index); ?>" 
                     x-collapse 
                     x-cloak 
                     itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer"
                     class="px-6 pb-4">
                    <p class="text-gray-600" itemprop="text"><?php echo e($faq['a']); ?></p>
                </div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    </div>
</section>
<?php /**PATH C:\xampp\htdocs\fastinsta\resources\views/components/faq.blade.php ENDPATH**/ ?>