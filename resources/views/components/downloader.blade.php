<!-- Premium Downloader with Clean Design -->
<div x-data="godLevelDownloader()" class="w-full">
    
    <!-- Premium Input Form -->
    <form @submit.prevent="download">
        <div class="flex flex-col sm:flex-row gap-3">
            <!-- Input Field with Icon -->
            <div class="relative flex-grow">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-purple-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                    </svg>
                </div>
                <input type="url" 
                    x-model="url" 
                    placeholder="Paste Instagram URL here..."
                    class="w-full pl-12 pr-4 py-4 rounded-2xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 outline-none text-base transition"
                    :disabled="loading" 
                    required>
            </div>
            
            <!-- Download Button with Gradient -->
            <button type="submit" 
                :disabled="loading || !url"
                class="px-10 py-4 bg-gradient-to-r from-purple-600 to-pink-500 hover:from-purple-700 hover:to-pink-600 text-white font-bold rounded-2xl shadow-lg hover:shadow-xl transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                <svg x-show="!loading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                <span x-show="!loading">Download</span>
                <span x-show="loading">Loading...</span>
            </button>
        </div>
    </form>
    
    <!-- Keyboard Shortcuts Hint -->
    <div class="mt-4 flex flex-wrap gap-2 justify-center text-xs text-gray-500">
        <span class="inline-flex items-center gap-1 px-2 py-1 rounded bg-gray-50">
            <kbd class="px-1.5 py-0.5 rounded bg-white border border-gray-300 font-mono text-gray-700">Ctrl</kbd> + 
            <kbd class="px-1.5 py-0.5 rounded bg-white border border-gray-300 font-mono text-gray-700">V</kbd>
            Auto paste
        </span>
        <span class="inline-flex items-center gap-1 px-2 py-1 rounded bg-gray-50">
            <kbd class="px-1.5 py-0.5 rounded bg-white border border-gray-300 font-mono text-gray-700">Enter</kbd>
            Download
        </span>
    </div>

    <!-- Download History Dropdown -->
    <div x-show="downloadHistory.length > 0" class="mt-6">
        <button @click="showHistory = !showHistory"
            class="flex items-center gap-2 px-4 py-2 rounded-xl bg-gradient-to-r from-gray-100 to-gray-50 hover:from-gray-200 hover:to-gray-100 text-gray-700 font-medium transition-all duration-300 shadow-sm hover:shadow-md">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span x-text="`Recent Downloads (${downloadHistory.length})`"></span>
            <svg :class="{'rotate-180': showHistory}" class="w-4 h-4 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
        </button>

        <!-- History Dropdown -->
        <div x-show="showHistory" x-cloak x-transition 
            class="mt-2 glass-card rounded-2xl shadow-2xl border border-white/30 overflow-hidden max-h-96 overflow-y-auto bg-white isolate">
            
            <!-- Header -->
            <div class="sticky top-0 bg-gradient-to-r from-purple-500/10 to-pink-500/10 px-4 py-3 flex items-center justify-between border-b border-gray-200/50 backdrop-blur-sm z-10">
                <span class="font-bold text-gray-900">Download History</span>
                <button @click="clearHistory()"
                    class="text-sm text-red-500 hover:text-red-600 font-medium hover:underline">
                    Clear All
                </button>
            </div>

            <!-- History Items -->
            <div class="divide-y divide-gray-100">
                <template x-for="(item, index) in downloadHistory" :key="index">
                    <div @click="loadFromHistory(item.url)"
                        class="px-4 py-3 hover:bg-purple-50/50 cursor-pointer transition-colors duration-200 flex items-start gap-3">
                        <!-- Thumbnail or Icon -->
                        <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-purple-100 to-pink-100 flex items-center justify-center flex-shrink-0 overflow-hidden">
                            <template x-if="item.thumbnail">
                                <img :src="item.thumbnail" 
                                     referrerpolicy="no-referrer"
                                     x-on:error="$el.style.display='none'; $el.nextElementSibling.style.display='flex'"
                                     class="w-full h-full object-cover" alt="Thumbnail">
                            </template>
                            <template x-if="!item.thumbnail">
                                <svg class="w-6 h-6 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                </svg>
                            </template>
                        </div>

                        <!-- Info -->
                        <div class="flex-1 min-w-0 overflow-hidden">
                            <p class="text-sm font-medium text-gray-900 truncate mb-1" x-text="item.url"></p>
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="text-xs px-2 py-0.5 rounded-full bg-purple-100 text-purple-700 font-medium uppercase whitespace-nowrap" x-text="item.mediaType"></span>
                                <span class="text-xs text-gray-500 whitespace-nowrap" x-text="`${item.mediaCount} file(s)`"></span>
                                <span class="text-xs text-gray-400 whitespace-nowrap" x-text="formatTimestamp(item.timestamp)"></span>
                            </div>
                        </div>

                        <!-- Download Again Icon -->
                        <svg class="w-5 h-5 text-purple-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- Keyboard Shortcuts Hint -->
    <div class="mt-4 flex flex-wrap gap-2 justify-center text-xs text-gray-500">
        <span class="inline-flex items-center gap-1 px-2 py-1 rounded bg-gray-100">
            <kbd class="px-1.5 py-0.5 rounded bg-white border border-gray-300 font-mono text-gray-700">Ctrl</kbd> + 
            <kbd class="px-1.5 py-0.5 rounded bg-white border border-gray-300 font-mono text-gray-700">V</kbd>
            Auto paste
        </span>
        <span class="inline-flex items-center gap-1 px-2 py-1 rounded bg-gray-100">
            <kbd class="px-1.5 py-0.5 rounded bg-white border border-gray-300 font-mono text-gray-700">Enter</kbd>
            Download
        </span>
        <span class="inline-flex items-center gap-1 px-2 py-1 rounded bg-gray-100">
            <kbd class="px-1.5 py-0.5 rounded bg-white border border-gray-300 font-mono text-gray-700">Esc</kbd>
            Close preview
        </span>
    </div>

    <!-- Error Message -->
    <div x-show="error" x-cloak class="mt-6 p-5 bg-gradient-to-r from-red-500/10 to-pink-500/10 border border-red-200 rounded-2xl">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
            </div>
            <span class="text-red-600 font-medium" x-text="error"></span>
        </div>
    </div>

    <!-- Quality Selector Modal -->
    <div x-show="showQualityModal" x-cloak @click.self="showQualityModal = false"
        class="fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm">
        <div @click.stop class="glass-card-strong rounded-3xl p-8 max-w-md w-full mx-4 transform transition-all duration-300"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95">
            
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-purple-600 to-pink-500">
                    Select Quality
                </h3>
                <button @click="showQualityModal = false" class="text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>

            <!-- Quality Options -->
            <div class="space-y-4 mb-6">
                <!-- HD Option -->
                <button @click="selectedQuality = 'hd'" 
                    :class="selectedQuality === 'hd' ? 'border-purple-500 bg-purple-50/50' : 'border-gray-200'"
                    class="w-full p-5 rounded-2xl border-2 transition-all duration-300 hover:border-purple-400 hover:shadow-lg group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"/>
                            </svg>
                        </div>
                        <div class="flex-grow text-left">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-lg text-gray-900">HD Quality</span>
                                <span class="px-2 py-0.5 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 text-white text-xs font-bold">Best</span>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">High Definition - Original quality</p>
                        </div>
                        <div class="flex-shrink-0">
                            <div :class="selectedQuality === 'hd' ? 'bg-purple-500' : 'bg-gray-300'"
                                class="w-6 h-6 rounded-full flex items-center justify-center transition-colors">
                                <svg x-show="selectedQuality === 'hd'" class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </button>

                <!-- SD Option -->
                <button @click="selectedQuality = 'sd'"
                    :class="selectedQuality === 'sd' ? 'border-blue-500 bg-blue-50/50' : 'border-gray-200'"
                    class="w-full p-5 rounded-2xl border-2 transition-all duration-300 hover:border-blue-400 hover:shadow-lg group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="flex-grow text-left">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-lg text-gray-900">SD Quality</span>
                                <span class="px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 text-xs font-bold">Faster</span>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">Standard Definition - Smaller file size</p>
                        </div>
                        <div class="flex-shrink-0">
                            <div :class="selectedQuality === 'sd' ? 'bg-blue-500' : 'bg-gray-300'"
                                class="w-6 h-6 rounded-full flex items-center justify-center transition-colors">
                                <svg x-show="selectedQuality === 'sd'" class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </button>
            </div>

            <!-- Actions -->
            <div class="flex gap-3">
                <button @click="showQualityModal = false" 
                    class="flex-1 px-6 py-3 rounded-xl bg-gray-100 text-gray-700 font-semibold hover:bg-gray-200 transition">
                    Cancel
                </button>
                <button @click="confirmQualityDownload()" 
                    class="flex-1 px-6 py-3 rounded-xl bg-gradient-to-r from-purple-600 to-pink-500 text-white font-semibold hover:shadow-lg hover:shadow-purple-500/30 transition">
                    Download
                </button>
            </div>
        </div>
    </div>

    <!-- Results Section - God Level -->
    <div x-show="result && result.success" x-cloak class="mt-10">
        
        <!-- Header with Gradient Background -->
        <div class="relative p-6 bg-gradient-to-r from-purple-600/10 via-pink-500/10 to-orange-400/10 rounded-3xl mb-8 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-purple-400/20 to-pink-400/20 rounded-full blur-2xl"></div>
            
            <div class="relative flex flex-wrap items-center gap-4">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-pink-500 rounded-full blur-md opacity-50"></div>
                    <span class="relative inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-bold text-white bg-gradient-to-r from-purple-600 to-pink-500 shadow-lg">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M4 8H2v12a2 2 0 002 2h12v-2H4V8zm16-6H8a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V4a2 2 0 00-2-2zm-8 12.5v-9l6 4.5-6 4.5z"/>
                        </svg>
                        <span x-text="result.media_type ? result.media_type.toUpperCase() : 'MEDIA'"></span>
                    </span>
                </div>
                
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold bg-white/80 text-gray-700 shadow-sm border border-white/50">
                    <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span x-text="(result.media_count || 0) + ' file(s) ready'"></span>
                </span>
                
                <button x-show="result.media && result.media.length > 1" @click="downloadAll" 
                    class="ml-auto inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-500 text-white font-bold rounded-2xl hover:shadow-xl hover:shadow-green-500/30 hover:scale-105 active:scale-95 transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download All
                </button>
            </div>
        </div>

        <!-- Caption with Smart Read More -->
        <div x-show="result.caption" x-data="{ captionExpanded: false }" class="mb-8 p-5 glass-card rounded-2xl border border-purple-100 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b from-purple-500 to-pink-500"></div>
            <p class="text-gray-700 text-sm pl-4" 
               :class="!captionExpanded && result.caption && result.caption.length > 150 ? 'line-clamp-3' : ''"
               x-text="result.caption"></p>
            <button x-show="result.caption && result.caption.length > 150" 
                    @click="captionExpanded = !captionExpanded"
                    class="mt-2 ml-4 text-purple-600 hover:text-purple-700 font-semibold text-sm flex items-center gap-1 transition">
                <span x-text="captionExpanded ? 'Read Less' : 'Read More'"></span>
                <svg :class="{'rotate-180': captionExpanded}" class="w-4 h-4 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>
        </div>

        <!-- God Level Media Cards Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8">
            <template x-for="(media, index) in result.media" :key="index">
                <div class="group relative">
                    <!-- Card Glow Effect -->
                    <div class="absolute -inset-1 bg-gradient-to-r from-purple-600 via-pink-500 to-orange-400 rounded-[2rem] blur-lg opacity-0 group-hover:opacity-40 transition-opacity duration-500"></div>
                    
                    <!-- Main Card -->
                    <div class="relative bg-white rounded-[1.5rem] shadow-2xl overflow-hidden transform transition-all duration-500 group-hover:-translate-y-3">
                        
                        <!-- Phone Frame Style Container -->
                        <div class="relative p-3 bg-gradient-to-b from-gray-100 to-gray-200">
                            
                            <!-- Phone Notch -->
                            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-24 h-5 bg-gray-200 rounded-b-2xl flex items-center justify-center gap-2 z-10">
                                <div class="w-2 h-2 rounded-full bg-gray-400"></div>
                                <div class="w-8 h-1.5 rounded-full bg-gray-400"></div>
                            </div>
                            
                            <!-- Video Screen -->
                            <div class="relative aspect-[9/16] rounded-2xl overflow-hidden bg-black cursor-pointer" @click="openPreview(media, index)">
                                
                                <!-- Thumbnail -->
                                <img :src="media.thumbnail" 
                                     referrerpolicy="no-referrer"
                                     onerror="this.style.display='none'" 
                                     class="w-full h-full object-cover transition-all duration-700 group-hover:scale-105 group-hover:brightness-110" 
                                     loading="lazy">
                                
                                <!-- Instagram-style Gradient Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-black/30"></div>
                                
                                <!-- Top Bar -->
                                <div class="absolute top-3 left-3 right-3 flex items-center justify-between z-10">
                                    <div class="flex items-center gap-2 px-2 py-1 bg-black/40 backdrop-blur-sm rounded-full">
                                        <!-- Instagram Gradient Ring -->
                                        <div class="w-7 h-7 rounded-full bg-gradient-to-tr from-yellow-400 via-pink-500 to-purple-600 p-0.5 flex-shrink-0">
                                            <div class="w-full h-full rounded-full bg-white flex items-center justify-center">
                                                <svg class="w-3.5 h-3.5 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <span class="text-white text-xs font-semibold pr-1" x-text="result.username || 'Instagram'"></span>
                                    </div>
                                    
                                    <div class="flex items-center gap-2">
                                        <span x-show="media.width >= 1080" class="px-2 py-0.5 bg-gradient-to-r from-amber-400 to-orange-500 rounded-md text-xs font-bold text-white shadow-lg">HD</span>
                                        <span class="px-2 py-0.5 rounded-md text-xs font-bold text-white shadow-lg"
                                              :class="media.type === 'video' ? 'bg-gradient-to-r from-purple-500 to-pink-500' : 'bg-gradient-to-r from-blue-500 to-cyan-500'"
                                              x-text="media.type.toUpperCase()"></span>
                                    </div>
                                </div>
                                
                                <!-- Center Play Button -->
                                <div x-show="media.type === 'video'" class="absolute inset-0 flex items-center justify-center">
                                    <div class="relative">
                                        <div class="absolute inset-0 w-24 h-24 -m-2 rounded-full bg-white/20 animate-ping"></div>
                                        <div class="absolute inset-0 w-20 h-20 rounded-full bg-white/30 animate-pulse"></div>
                                        <div class="relative w-20 h-20 rounded-full bg-white/95 backdrop-blur-xl flex items-center justify-center shadow-2xl group-hover:scale-110 transition-transform duration-300">
                                            <svg class="w-10 h-10 ml-1 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M8 5v14l11-7z"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Bottom Info -->
                                <div class="absolute bottom-0 left-0 right-0 p-4 z-10">
                                    <div x-show="media.duration" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-black/50 backdrop-blur-sm rounded-full text-white text-xs font-medium mb-3">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span x-text="formatDuration(media.duration)"></span>
                                    </div>
                                    
                                    <div class="flex items-center justify-between">
                                        <span class="text-white/80 text-xs" x-text="(media.width || 720) + ' × ' + (media.height || 1280)"></span>
                                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-white/20 backdrop-blur-sm rounded-full text-white text-xs font-medium">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            Click to Preview
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Bar -->
                        <div class="p-4 bg-gradient-to-b from-white to-gray-50">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-4">
                                    <button class="text-gray-700 hover:text-red-500 hover:scale-110 transition-all">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                    </button>
                                    <button class="text-gray-700 hover:text-blue-500 hover:scale-110 transition-all">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                                        </svg>
                                    </button>
                                </div>
                                <span class="w-8 h-8 flex items-center justify-center bg-gradient-to-r from-purple-100 to-pink-100 rounded-full text-xs font-bold text-purple-600" x-text="index + 1"></span>
                            </div>
                            
                            <div class="flex gap-3">
                                <button @click="openPreview(media, index)" 
                                    class="flex-1 flex items-center justify-center gap-2 py-3.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-all duration-300 hover:scale-[1.02] active:scale-[0.98]">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Preview
                                </button>
                                <a :href="getDownloadUrl(media.url, media.type, index)" 
                                   :download="'instagram_' + media.type + '_' + (index + 1) + (media.type === 'video' ? '.mp4' : '.jpg')" 
                                   target="_blank"
                                   class="flex-1 flex items-center justify-center gap-2 py-3.5 bg-gradient-to-r from-purple-600 via-pink-500 to-orange-400 text-white font-semibold rounded-xl hover:shadow-xl hover:shadow-purple-500/30 hover:scale-[1.02] active:scale-[0.98] transition-all duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                    <span>Download <span class="text-white/80 text-sm" x-text="media.type === 'video' ? '.mp4' : '.jpg'"></span></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Premium Video Preview Modal -->
    <div x-show="showPreview" x-cloak @click.self="closePreview()" @keydown.escape.window="closePreview()"
         class="fixed inset-0 z-50 flex items-center justify-center p-4">
        
        <!-- Animated Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-purple-900/95 via-black/95 to-pink-900/95 backdrop-blur-xl"></div>
        
        <!-- Decorative -->
        <div class="absolute top-20 left-20 w-64 h-64 bg-purple-500/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-20 w-64 h-64 bg-pink-500/20 rounded-full blur-3xl animate-pulse"></div>
        
        <!-- Close Button -->
        <button @click="closePreview()" class="absolute top-6 right-6 z-50 w-14 h-14 bg-white/10 hover:bg-white/20 rounded-2xl text-white flex items-center justify-center transition-all duration-300 hover:scale-110 hover:rotate-90 backdrop-blur-sm border border-white/10">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        
        <!-- Modal Content -->
        <div class="relative w-full max-w-lg mx-auto">
            
            <!-- Phone Frame -->
            <div class="relative p-3 bg-gradient-to-b from-gray-800 to-gray-900 rounded-[3rem] shadow-2xl">
                <div class="relative bg-black rounded-[2.5rem] overflow-hidden">
                    
                    <!-- Notch -->
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-7 bg-black rounded-b-3xl z-20 flex items-center justify-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-gray-800"></div>
                        <div class="w-16 h-4 rounded-full bg-gray-800"></div>
                    </div>
                    
                    <!-- Video Container -->
                    <div class="relative aspect-[9/16] bg-black">
                        <!-- Loading Spinner -->
                        <div x-show="previewLoading" class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-purple-900 to-pink-900 z-10">
                            <div class="relative">
                                <div class="w-20 h-20 border-4 border-white/20 border-t-white rounded-full animate-spin"></div>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Video Player -->
                        <video x-show="previewMedia && previewMedia.type === 'video'" x-ref="videoPlayer"
                            :src="previewMedia ? previewMedia.url : ''" 
                            class="w-full h-full object-contain"
                            controls autoplay playsinline
                            @loadstart="previewLoading = true"
                            @canplay="previewLoading = false"></video>
                        
                        <!-- Image -->
                        <img x-show="previewMedia && previewMedia.type === 'image'" 
                             :src="previewMedia ? getDownloadUrl(previewMedia.url, 'image', previewIndex) : ''" 
                             referrerpolicy="no-referrer"
                             onerror="this.style.display='none'; previewLoading = false"
                             class="w-full h-full object-contain"
                             @load="previewLoading = false">
                    </div>
                    
                    <!-- Bottom Bar -->
                    <div class="absolute bottom-2 left-1/2 -translate-x-1/2 w-32 h-1 bg-gray-700 rounded-full"></div>
                </div>
            </div>
            
            <!-- Info & Download -->
            <div class="mt-8 flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-sm rounded-xl border border-white/10">
                        <span class="w-3 h-3 rounded-full animate-pulse" :class="previewMedia && previewMedia.type === 'video' ? 'bg-purple-500' : 'bg-blue-500'"></span>
                        <span class="text-white font-medium" x-text="previewMedia ? previewMedia.type.toUpperCase() : ''"></span>
                    </div>
                    <div class="text-white/60 text-sm" x-text="previewMedia ? (previewMedia.width || 720) + ' × ' + (previewMedia.height || 1280) : ''"></div>
                </div>
                
                <a x-show="previewMedia" 
                   :href="previewMedia ? getDownloadUrl(previewMedia.url, previewMedia.type, previewIndex) : '#'" 
                   :download="previewMedia ? 'instagram_' + previewMedia.type + '_' + (previewIndex + 1) + (previewMedia.type === 'video' ? '.mp4' : '.jpg') : ''"
                   target="_blank"
                   class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-purple-600 via-pink-500 to-orange-400 text-white font-bold rounded-2xl hover:shadow-2xl hover:shadow-purple-500/40 hover:scale-105 active:scale-95 transition-all duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download <span class=\"text-white/80\" x-text=\"previewMedia && previewMedia.type === 'video' ? '.mp4' : '.jpg'\"></span>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.shadow-3xl { box-shadow: 0 35px 60px -12px rgba(0, 0, 0, 0.25); }
video::-webkit-media-controls-panel { background: linear-gradient(to top, rgba(0,0,0,0.8), transparent); }
</style>

<script>
// Define Laravel routes as global variables
window.FASTINSTA_ROUTES = {
    download: '{{ route("api.download") }}',
    proxy: '{{ route("api.proxy") }}',
    csrfToken: '{{ csrf_token() }}'
};
</script>

@verbatim
<script>
function godLevelDownloader() {
    return {
        url: '',
        loading: false,
        error: '',
        result: { success: false, media: [], caption: '', media_type: '', media_count: 0 },
        turnstileToken: '',
        showPreview: false,
        previewMedia: null,
        previewIndex: 0,
        previewLoading: false,
        downloadHistory: [],
        showHistory: false,
        showQualityModal: false,
        selectedQuality: 'hd',
        pendingDownload: null,
        batchProgress: 0,
        estimatedTime: 0,
        contentType: null,
        showProfilePopup: false,
        profileData: {
            username: '',
            fullname: '',
            bio: '',
            posts: 0,
            followers: 0,
            following: 0
        },

        init() {
            // Load download history from localStorage
            this.loadHistory();
            
            // Setup keyboard shortcuts
            this.setupKeyboardShortcuts();
        },

        setupKeyboardShortcuts() {
            document.addEventListener('keydown', (e) => {
                // Ctrl+V or Cmd+V - Auto paste from clipboard
                if ((e.ctrlKey || e.metaKey) && e.key === 'v') {
                    // Small delay to let native paste happen first
                    setTimeout(() => this.pasteFromClipboard(), 100);
                }
                
                // Enter key - Trigger download if URL is present
                if (e.key === 'Enter' && this.url && !this.loading) {
                    const activeElement = document.activeElement;
                    // Only trigger if not in textarea or contenteditable
                    if (activeElement.tagName !== 'TEXTAREA' && !activeElement.isContentEditable) {
                        this.download();
                    }
                }
                
                // Escape key - Close preview modal or quality modal
                if (e.key === 'Escape') {
                    if (this.showQualityModal) {
                        this.showQualityModal = false;
                    } else if (this.showPreview) {
                        this.closePreview();
                    }
                }
            });
        },

        loadHistory() {
            try {
                const stored = localStorage.getItem('fastinsta_history');
                if (stored) {
                    this.downloadHistory = JSON.parse(stored);
                }
            } catch (err) {
                console.error('Error loading history:', err);
                this.downloadHistory = [];
            }
        },

        saveToHistory(url, result) {
            try {
                const historyItem = {
                    url: url,
                    timestamp: Date.now(),
                    mediaType: result.media_type || 'unknown',
                    mediaCount: result.media_count || 0,
                    thumbnail: result.media && result.media[0] ? result.media[0].thumbnail : null
                };
                
                // Add to beginning of array
                this.downloadHistory.unshift(historyItem);
                
                // Keep only last 10 items
                this.downloadHistory = this.downloadHistory.slice(0, 10);
                
                // Save to localStorage
                localStorage.setItem('fastinsta_history', JSON.stringify(this.downloadHistory));
            } catch (err) {
                console.error('Error saving to history:', err);
            }
        },

        clearHistory() {
            this.downloadHistory = [];
            localStorage.removeItem('fastinsta_history');
            this.showHistory = false;
        },

        loadFromHistory(url) {
            this.url = url;
            this.showHistory = false;
            this.download();
        },

        formatTimestamp(timestamp) {
            const now = Date.now();
            const diff = now - timestamp;
            const minutes = Math.floor(diff / 60000);
            const hours = Math.floor(diff / 3600000);
            const days = Math.floor(diff / 86400000);
            
            if (minutes < 1) return 'Just now';
            if (minutes < 60) return `${minutes}m ago`;
            if (hours < 24) return `${hours}h ago`;
            return `${days}d ago`;
        },

        async download() {
            if (!this.url) return;
            this.loading = true;
            this.error = '';
            this.result = null;

            try {
                const response = await fetch(window.FASTINSTA_ROUTES.download, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': window.FASTINSTA_ROUTES.csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ url: this.url, turnstile_token: this.turnstileToken }),
                });
                const data = await response.json();
                if (data.success) {
                    this.result = data;
                    // Save to history
                    this.saveToHistory(this.url, data);
                } else {
                    throw new Error(data.error || 'Failed to download');
                }
            } catch (err) {
                this.error = err.message || 'An error occurred';
            } finally {
                this.loading = false;
            }
        },

        async pasteFromClipboard() {
            try {
                const text = await navigator.clipboard.readText();
                if (text && text.includes('instagram.com')) {
                    this.url = text;
                    // Optional: Auto-trigger download after paste
                    // setTimeout(() => this.download(), 500);
                }
            } catch (err) {
                console.log('Clipboard access denied or failed');
            }
        },

        getDownloadUrl(url, type, index) {
            return window.FASTINSTA_ROUTES.proxy + '?url=' + encodeURIComponent(url) + '&filename=instagram_' + type + '_' + (index + 1);
        },

        formatDuration(seconds) {
            if (!seconds) return '';
            return Math.floor(seconds / 60) + ':' + String(Math.floor(seconds % 60)).padStart(2, '0');
        },

        openPreview(media, index) {
            this.previewMedia = media;
            this.previewIndex = index;
            this.previewLoading = true;
            this.showPreview = true;
            document.body.style.overflow = 'hidden';
        },

        closePreview() {
            this.showPreview = false;
            this.previewMedia = null;
            this.previewLoading = false;
            document.body.style.overflow = '';
            if (this.$refs.videoPlayer) this.$refs.videoPlayer.pause();
        },

        openQualitySelector(media, index) {
            this.pendingDownload = { media, index };
            this.selectedQuality = 'hd';
            this.showQualityModal = true;
        },

        confirmQualityDownload() {
            if (!this.pendingDownload) return;
            
            const { media, index } = this.pendingDownload;
            const link = document.createElement('a');
            link.href = this.getDownloadUrl(media.url, media.type, index, this.selectedQuality);
            link.target = '_blank';
            link.click();
            
            this.showQualityModal = false;
            this.pendingDownload = null;
        },

        getDownloadUrl(url, type, index, quality = 'hd') {
            return window.FASTINSTA_ROUTES.proxy + '?url=' + encodeURIComponent(url) + 
                   '&filename=instagram_' + type + '_' + (index + 1) + 
'&quality=' + quality;
        },

        downloadAll() {
            if (!this.result || !this.result.media) return;
            
            const total = this.result.media.length;
            let completed = 0;
            this.batchProgress = 0;
            this.estimatedTime = total * 2; // 2 seconds per file estimate
            
            const interval = setInterval(() => {
                if (this.estimatedTime > 0) this.estimatedTime--;
            }, 1000);
            
            this.result.media.forEach((media, index) => {
                setTimeout(() => {
                    const link = document.createElement('a');
                    link.href = this.getDownloadUrl(media.url, media.type, index, 'hd');
                    link.target = '_blank';
                    link.click();
                    
                    completed++;
                    this.batchProgress = Math.round((completed / total) * 100);
                    
                    if (completed === total) {
                        clearInterval(interval);
                        setTimeout(() => {
                            this.batchProgress = 0;
                            this.estimatedTime = 0;
                        }, 2000);
                    }
                }, index * 500);
            });
        }
    }
}

function onTurnstileSuccess(token) {
    if (window.Alpine) {
        const el = document.querySelector('[x-data]');
        if (el && el.__x) el.__x.$data.turnstileToken = token;
    }
}
</script>
@endverbatim
