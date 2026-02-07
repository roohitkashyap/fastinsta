<!-- Header Navigation -->
<header x-data="{ mobileMenuOpen: false }" class="sticky top-0 z-50 glass shadow-sm">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <a href="<?php echo e(route('home')); ?>" class="flex items-center space-x-2 group">
                <div class="w-10 h-10 gradient-bg rounded-xl flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073z"/>
                        <path d="M12 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                    </svg>
                </div>
                <span class="text-xl font-bold text-gradient hidden sm:block">FastInsta</span>
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-1">
                <a href="<?php echo e(route('home')); ?>" class="px-4 py-2 rounded-lg text-gray-700 hover:text-brand-500 hover:bg-brand-50 font-medium transition <?php echo e(request()->routeIs('home') ? 'text-brand-500 bg-brand-50' : ''); ?>">
                    Home
                </a>
                <a href="<?php echo e(route('video-downloader')); ?>" class="px-4 py-2 rounded-lg text-gray-700 hover:text-brand-500 hover:bg-brand-50 font-medium transition <?php echo e(request()->routeIs('video-downloader') ? 'text-brand-500 bg-brand-50' : ''); ?>">
                    Video
                </a>
                <a href="<?php echo e(route('reels-downloader')); ?>" class="px-4 py-2 rounded-lg text-gray-700 hover:text-brand-500 hover:bg-brand-50 font-medium transition <?php echo e(request()->routeIs('reels-downloader') ? 'text-brand-500 bg-brand-50' : ''); ?>">
                    Reels
                </a>
                <a href="<?php echo e(route('story-downloader')); ?>" class="px-4 py-2 rounded-lg text-gray-700 hover:text-brand-500 hover:bg-brand-50 font-medium transition <?php echo e(request()->routeIs('story-downloader') ? 'text-brand-500 bg-brand-50' : ''); ?>">
                    Story
                </a>
                <a href="<?php echo e(route('photo-downloader')); ?>" class="px-4 py-2 rounded-lg text-gray-700 hover:text-brand-500 hover:bg-brand-50 font-medium transition <?php echo e(request()->routeIs('photo-downloader') ? 'text-brand-500 bg-brand-50' : ''); ?>">
                    Photo
                </a>
                <a href="<?php echo e(route('blog.index')); ?>" class="px-4 py-2 rounded-lg text-gray-700 hover:text-brand-500 hover:bg-brand-50 font-medium transition <?php echo e(request()->routeIs('blog.*') ? 'text-brand-500 bg-brand-50' : ''); ?>">
                    Blog
                </a>
            </div>

            <!-- Gradient Preset Selector -->
            <div x-data="{
                showPresets: false,
                presets: [
                    { name: 'Purple Pink', colors: 'from-purple-600 via-pink-500 to-orange-400' },
                    { name: 'Blue Cyan', colors: 'from-blue-600 via-cyan-500 to-teal-400' },
                    { name: 'Green Emerald', colors: 'from-green-600 via-emerald-500 to-lime-400' },
                    { name: 'Red Orange', colors: 'from-red-600 via-orange-500 to-yellow-400' }
                ]
            }" class="relative ml-2">
                <button @click="showPresets = !showPresets" class="p-2 rounded-lg hover:bg-gray-100 transition" title="Theme colors">
                    <svg class="w-5 h-5 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 2a2 2 0 00-2 2v11a3 3 0 106 0V4a2 2 0 00-2-2H4zm1 14a1 1 0 100-2 1 1 0 000 2zm5-1.757l4.9-4.9a2 2 0 000-2.828L13.485 5.1a2 2 0 00-2.828 0L10 5.757v8.486zM16 18H9.071l6-6H16a2 2 0 012 2v2a2 2 0 01-2 2z" clip-rule="evenodd"/>
                    </svg>
                </button>
                <div x-show="showPresets" x-cloak @click.away="showPresets = false" class="absolute right-0 top-full mt-2 p-3 glass-card rounded-xl shadow-2xl w-48 z-50">
                    <p class="text-xs font-semibold text-gray-600 mb-2">Theme Colors</p>
                    <template x-for="preset in presets" :key="preset.name">
                        <button class="w-full mb-2 last:mb-0" @click="showPresets = false">
                            <div :class="'h-8 rounded-lg bg-gradient-to-r ' + preset.colors"></div>
                            <p class="text-xs text-gray-700 mt-1" x-text="preset.name"></p>
                        </button>
                    </template>
                </div>
            </div>

            <!-- Dark Mode Toggle -->
            <div x-data="{
                darkMode: false,
                init() {
                    // Check localStorage or system preference
                    this.darkMode = localStorage.getItem('theme') === 'dark' || 
                        (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches);
                    this.updateTheme();
                },
                toggle() {
                    this.darkMode = !this.darkMode;
                    this.updateTheme();
                },
                updateTheme() {
                    if (this.darkMode) {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('theme', 'dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('theme', 'light');
                    }
                }
            }" class="ml-2">
                <button @click="toggle()" 
                    class="theme-toggle"
                    title="Toggle dark mode">
                    <div class="theme-toggle-slider">
                        <!-- Sun Icon (Light Mode) -->
                        <svg x-show="!darkMode" class="theme-toggle-icon text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"/>
                        </svg>
                        <!-- Moon Icon (Dark Mode) -->
                        <svg x-show="darkMode" x-cloak class="theme-toggle-icon text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/>
                        </svg>
                    </div>
                </button>
            </div>

            <!-- Mobile Menu Button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100">
                <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Mobile Navigation -->
        <div x-show="mobileMenuOpen" x-cloak x-transition class="md:hidden pb-4">
            <div class="flex flex-col space-y-1">
                <a href="<?php echo e(route('home')); ?>" class="px-4 py-3 rounded-lg text-gray-700 hover:bg-brand-50 hover:text-brand-500 font-medium">Home</a>
                <a href="<?php echo e(route('video-downloader')); ?>" class="px-4 py-3 rounded-lg text-gray-700 hover:bg-brand-50 hover:text-brand-500 font-medium">Video Downloader</a>
                <a href="<?php echo e(route('reels-downloader')); ?>" class="px-4 py-3 rounded-lg text-gray-700 hover:bg-brand-50 hover:text-brand-500 font-medium">Reels Downloader</a>
                <a href="<?php echo e(route('story-downloader')); ?>" class="px-4 py-3 rounded-lg text-gray-700 hover:bg-brand-50 hover:text-brand-500 font-medium">Story Downloader</a>
                <a href="<?php echo e(route('photo-downloader')); ?>" class="px-4 py-3 rounded-lg text-gray-700 hover:bg-brand-50 hover:text-brand-500 font-medium">Photo Downloader</a>
                <a href="<?php echo e(route('blog.index')); ?>" class="px-4 py-3 rounded-lg text-gray-700 hover:bg-brand-50 hover:text-brand-500 font-medium">Blog</a>
            </div>
        </div>
    </nav>
</header>
<?php /**PATH C:\xampp\htdocs\fastinsta\resources\views/components/header.blade.php ENDPATH**/ ?>