<script setup>
import {Splide, SplideSlide} from "@splidejs/vue-splide";
import {usePage, Link} from "@inertiajs/vue3";
const banner_global = usePage().props.banner_global;

const resolveImageSrc = (path) => {
    if (!path) {
        return '/images/logo/logo-main.webp';
    }
    if (path.startsWith('http://') || path.startsWith('https://') || path.startsWith('/')) {
        return path;
    }
    return `/${path}`;
}
</script>

<template>
    <section class="relative bg-primary bg-gradient-to-r from-primary to-primary-400 pt-24 pb-20 overflow-hidden border-b border-primary-600">
        <!-- Grid Pattern Overlay -->
        <div class="absolute inset-0 opacity-[0.05] pointer-events-none z-0" 
             style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 32px 32px;"></div>

        <div class="max-w-[1440px] px-margin-desktop mx-auto grid grid-cols-1 lg:grid-cols-12 gap-lg relative z-10 items-center">
            <!-- Left Grid: Headline text -->
            <div class="lg:col-span-7 z-10 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/20 text-white border border-white/30 backdrop-blur-sm font-bold text-xs rounded mb-6 uppercase tracking-wider animate-fade-in">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded bg-white opacity-75"></span>
                      <span class="relative inline-flex rounded h-2 w-2 bg-white"></span>
                    </span>
                    Material Bangunan Demak
                </div>
                
                <h1 class="font-display text-4xl md:text-5xl xl:text-6xl font-bold tracking-tight leading-[1.1] text-white mb-8 drop-shadow-sm">
                    Pusat Material Bangunan <br class="hidden md:block" />
                    Untuk <span class="text-white/80 drop-shadow-[0_0_10px_rgba(255,255,255,0.3)]">Konstruksi Kokoh</span> Anda
                </h1>
                
                <p class="text-slate-300 text-base mb-10 max-w-2xl mx-auto lg:mx-0 leading-relaxed font-medium">
                    Solusi pengadaan material konstruksi terpercaya dengan stok real-time dan pengiriman cargo profesional langsung ke lokasi proyek Anda.
                </p>
                
                <div class="flex flex-wrap justify-center lg:justify-start gap-4">
                    <Link :href="route('product.index')" class="pk-btn-accent px-8 py-4 group text-white shadow-[0_4px_14px_0_rgba(249,115,22,0.39)] hover:shadow-[0_6px_20px_rgba(249,115,22,0.23)] hover:-translate-y-0.5 transition-all duration-200">
                        <span class="text-white">Belanja Sekarang</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 transition-transform group-hover:translate-x-1 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </Link>
                    <Link :href="route('calculator.index')" class="bg-white/10 hover:bg-white/20 text-white border border-white/20 rounded font-bold px-8 py-4 transition-all duration-200 backdrop-blur-sm">
                        Hitung Kebutuhan
                    </Link>
                </div>

                <div class="mt-12 pt-10 border-t border-white/20 grid grid-cols-3 gap-8">
                    <div>
                        <p class="text-2xl font-bold text-white">500+</p>
                        <p class="text-xs font-bold text-white/70 uppercase tracking-wider">Produk SNI</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-white">24/7</p>
                        <p class="text-xs font-bold text-white/70 uppercase tracking-wider">Dukungan Proyek</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-white">Cargo</p>
                        <p class="text-xs font-bold text-white/70 uppercase tracking-wider">Pengiriman Cepat</p>
                    </div>
                </div>
            </div>

            <!-- Right Grid: Splide Carousel with Floating Elements -->
            <div class="lg:col-span-5 relative">
                <div class="relative z-10 rounded overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.3)] border border-white/20 aspect-square group bg-primary-700">
                    <Splide v-if="banner_global && banner_global.length > 0" 
                            :options="{ type : 'fade', rewind: true, gap: '0', autoplay: true, arrows: false, pagination: true, speed: 1000}" 
                            aria-label="Banner Images" class="w-full h-full">
                        <SplideSlide v-for="item in banner_global" :key="item.id" class="w-full h-full">
                            <img :src="resolveImageSrc(item.image)" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 opacity-90" :alt="item.name">
                        </SplideSlide>
                    </Splide>
                    <div v-else class="w-full h-full">
                        <img class="w-full h-full object-cover opacity-90" src="https://images.unsplash.com/photo-1541888946425-d81bb19240f5?auto=format&fit=crop&q=80&w=800" alt="Material" />
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-secondary/80 to-transparent pointer-events-none z-10"></div>
                </div>

                <div class="absolute bottom-4 left-4 bg-white/95 backdrop-blur-md p-4 rounded border border-white/60 hidden sm:flex items-center gap-4 z-20 shadow-lg">
                    <div class="bg-primary/10 p-3 rounded text-primary flex items-center justify-center">
                        <span class="material-symbols-outlined text-3xl">local_shipping</span>
                    </div>
                    <div>
                        <p class="font-bold text-sm text-on-surface">Layanan Kargo</p>
                        <p class="text-xs font-medium text-on-surface-variant">Siap kirim ke Demak & Sekitarnya</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes bounce-slow {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.animate-fade-in {
    animation: fade-in 0.6s ease-out forwards;
}

.animate-bounce-slow {
    animation: bounce-slow 4s ease-in-out infinite;
}

:deep(.splide),
:deep(.splide__track),
:deep(.splide__list),
:deep(.splide__slide) {
    height: 100% !important;
}

:deep(.splide__pagination) {
    bottom: 1rem;
    z-index: 25;
}
</style>