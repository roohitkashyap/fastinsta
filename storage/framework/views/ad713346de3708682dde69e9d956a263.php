<!-- Voice Search Optimized How-To Component -->
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'steps' => [],
    'title' => 'How To Download',
    'gradient' => 'from-brand-500 to-pink-500'
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
    'steps' => [],
    'title' => 'How To Download',
    'gradient' => 'from-brand-500 to-pink-500'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<section class="py-16 bg-gray-50" itemscope itemtype="https://schema.org/HowTo">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-12" itemprop="name"><?php echo e($title); ?></h2>
        <meta itemprop="description" content="Step by step guide to download Instagram content">
        
        <div class="space-y-6">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <div class="flex items-start gap-4 bg-white p-6 rounded-2xl shadow-sm border border-gray-100" 
                 itemscope itemprop="step" itemtype="https://schema.org/HowToStep">
                <meta itemprop="position" content="<?php echo e($index + 1); ?>">
                
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br <?php echo e($gradient); ?> flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                    <?php echo e($index + 1); ?>

                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1" itemprop="name"><?php echo e($step['title']); ?></h3>
                    <p class="text-gray-600" itemprop="text"><?php echo e($step['description']); ?></p>
                </div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    </div>
</section>
<?php /**PATH C:\xampp\htdocs\fastinsta\resources\views/components/how-to.blade.php ENDPATH**/ ?>