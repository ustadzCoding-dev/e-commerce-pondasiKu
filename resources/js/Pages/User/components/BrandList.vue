<script setup>
import {usePage, Link} from "@inertiajs/vue3";

const brand_global = usePage().props.brand_global || [];

const resolveImageSrc = (path) => {
    if (!path) {
        return '/images/logo/logo-square.webp';
    }
    if (path.startsWith('http://') || path.startsWith('https://') || path.startsWith('/')) {
        return path;
    }
    return `/${path}`;
}
</script>

<template>
    <section class="bg-surface py-16 border-b border-outline-variant">
        <div class="max-w-[1440px] mx-auto px-margin-desktop">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
                <div class="max-w-xl">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="h-1 w-6 bg-primary"></span>
                        <span class="text-xs font-bold text-primary uppercase tracking-wider">Produsen Terpercaya</span>
                    </div>
                    <h2 class="pk-title text-2xl md:text-3xl lg:text-4xl">Pabrikan Mitra <br class="hidden md:block"/><span class="text-on-surface-variant">Konstruksi Nasional</span></h2>
                </div>
                <p class="text-on-surface-variant text-sm max-w-sm md:text-right font-medium">
                    Kami bekerja sama dengan produsen terkemuka untuk memastikan setiap proyek Anda menggunakan material standar SNI.
                </p>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                <Link 
                    v-for="(item, index) in brand_global" 
                    :key="item.id"
                    :href="route('product.index', {brand_id: item.id})"
                    class="group relative bg-white border border-outline-variant rounded p-6 hover:border-primary transition-all flex flex-col items-center justify-center cursor-pointer text-center shadow-none"
                >
                    <div class="relative z-10 flex items-center justify-center h-16 w-full mb-3">
                        <img 
                            v-if="item.image"
                            class="max-h-12 max-w-full object-contain filter grayscale group-hover:grayscale-0 transition-all duration-300 group-hover:scale-105" 
                            :alt="item.name" 
                            :src="resolveImageSrc(item.image)" 
                        />
                        <div v-else class="h-10 w-10 rounded bg-surface flex items-center justify-center text-on-surface-variant font-bold text-sm border border-outline-variant">
                            {{ item.name.charAt(0) }}
                        </div>
                    </div>
                    
                    <span class="relative z-10 text-xs font-bold uppercase tracking-wider text-on-surface-variant group-hover:text-primary transition-colors">
                        {{ item.name }}
                    </span>
                </Link>
            </div>
        </div>
    </section>
</template>