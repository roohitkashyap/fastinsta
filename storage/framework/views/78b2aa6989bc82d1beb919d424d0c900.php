<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <!-- Primary Meta Tags -->
    <title><?php echo e($seo['title'] ?? config('app.name', 'FastInsta')); ?></title>
    <meta name="title" content="<?php echo e($seo['title'] ?? config('app.name')); ?>">
    <meta name="description" content="<?php echo e($seo['description'] ?? ''); ?>">
    <meta name="keywords" content="<?php echo e($seo['keywords'] ?? ''); ?>">
    <meta name="author" content="FastInsta Team">
    <meta name="generator" content="Laravel <?php echo e(app()->version()); ?>">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <link rel="canonical" href="<?php echo e(url()->current()); ?>">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo e(url()->current()); ?>">
    <meta property="og:title" content="<?php echo e($seo['title'] ?? config('app.name')); ?>">
    <meta property="og:description" content="<?php echo e($seo['description'] ?? ''); ?>">
    <meta property="og:image" content="<?php echo e(asset('images/og-image.jpg')); ?>">
    <meta property="og:site_name" content="<?php echo e(config('app.name', 'FastInsta')); ?>">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo e(url()->current()); ?>">
    <meta property="twitter:title" content="<?php echo e($seo['title'] ?? config('app.name')); ?>">
    <meta property="twitter:description" content="<?php echo e($seo['description'] ?? ''); ?>">
    <meta property="twitter:image" content="<?php echo e(asset('images/og-image.jpg')); ?>">
    
    <!-- PWA -->
    <link rel="manifest" href="<?php echo e(asset('manifest.json')); ?>">
    <meta name="theme-color" content="#E1306C">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="apple-touch-icon" href="<?php echo e(asset('icons/icon-192.png')); ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('favicon-32x32.png')); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(asset('favicon-16x16.png')); ?>">
    
    <!-- Performance Optimization -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://cdn.tailwindcss.com">
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" as="style">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- God-Level Visual Enhancements -->
    <link rel="stylesheet" href="<?php echo e(asset('css/god-level.css')); ?>">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        instagram: {
                            pink: '#E1306C',
                            purple: '#833AB4',
                            orange: '#F77737',
                            yellow: '#FCAF45',
                            blue: '#405DE6',
                        },
                        brand: {
                            50: '#FFF0F5',
                            100: '#FFE0EB',
                            500: '#E1306C',
                            600: '#C72A5F',
                            700: '#A82350',
                        }
                    },
                    animation: {
                        'gradient': 'gradient 8s ease infinite',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    }
                }
            }
        }
    </script>
    
    <style>
        /* Fix FOUC - Hide Alpine components until ready */
        [x-cloak] { 
            display: none !important; 
        }
        
        /* Smooth page load - no glitch */
        body {
            opacity: 0;
            animation: fadeIn 0.3s ease-in forwards;
        }
        
        @keyframes fadeIn {
            to { opacity: 1; }
        }
        
        @keyframes gradient {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        .gradient-bg {
            background: linear-gradient(-45deg, #E1306C, #833AB4, #405DE6, #5851DB);
            background-size: 400% 400%;
            animation: gradient 8s ease infinite;
        }
        .glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
        .text-gradient {
            background: linear-gradient(135deg, #E1306C, #833AB4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
    
    <!-- Alpine.js - Deferred for Performance -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Lazy Load Images Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('img[loading="lazy"]');
            if ('loading' in HTMLImageElement.prototype) {
                // Browser supports lazy loading
            } else {
                // Fallback for older browsers
                const script = document.createElement('script');
                script.src = 'https://cdn.jsdelivr.net/npm/lazysizes@5.3.2/lazysizes.min.js';
                document.body.appendChild(script);
            }
        });
    </script>
    
    <!-- Cloudflare Turnstile (if enabled) -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(config('services.turnstile.site_key')): ?>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    
    <!-- JSON-LD Schema -->
    <?php echo $__env->yieldPushContent('schema'); ?>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900 min-h-screen flex flex-col">
    <!-- Skip Link -->
    <a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-brand-500 text-white px-4 py-2 rounded">
        Skip to main content
    </a>

    <!-- Navigation -->
    <?php echo $__env->make('components.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <!-- Header Banner Ad -->
    <?php if (isset($component)) { $__componentOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ad-slot','data' => ['position' => 'header','class' => 'my-4','style' => 'border: 5px solid red; padding: 20px; background: yellow;']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ad-slot'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['position' => 'header','class' => 'my-4','style' => 'border: 5px solid red; padding: 20px; background: yellow;']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805)): ?>
<?php $attributes = $__attributesOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805; ?>
<?php unset($__attributesOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805)): ?>
<?php $component = $__componentOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805; ?>
<?php unset($__componentOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805); ?>
<?php endif; ?>
    
    <!-- Main Content -->
    <main id="main" class="flex-grow">
        <?php echo $__env->yieldContent('content'); ?>
    </main>
    
    <!-- Footer -->
    <?php echo $__env->make('components.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <!-- Footer Ad -->
    <?php echo \App\Models\AdSlot::render('footer_banner'); ?>

    
    <!-- Service Worker -->
    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js').catch(() => {});
        }
    </script>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\fastinsta\resources\views/layouts/app.blade.php ENDPATH**/ ?>