<script setup>
import {usePage, Link} from "@inertiajs/vue3";

const category_global = usePage().props.category_global || [];

const resolveCategoryIcon = (name) => {
    const slug = name.toLowerCase();
    if (slug.includes('semen') || slug.includes('beton')) return 'architecture';
    if (slug.includes('bata') || slug.includes('batu')) return 'grid_view';
    if (slug.includes('besi') || slug.includes('baja')) return 'rebase_edit';
    if (slug.includes('atap') || slug.includes('genteng')) return 'roofing';
    if (slug.includes('pipa') || slug.includes('sanitasi')) return 'water_drop';
    if (slug.includes('keramik') || slug.includes('lantai')) return 'imagesmode';
    if (slug.includes('cat') || slug.includes('kuas')) return 'brush';
    if (slug.includes('listrik') || slug.includes('kabel')) return 'electric_bolt';
    return 'home_repair_service';
}
</script>

<template>
    <section class="bg-white py-16 relative overflow-hidden border-b border-outline-variant">
        <div class="max-w-[1440px] mx-auto px-margin-desktop relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12 gap-6">
                <div class="max-w-xl">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="h-1 w-6 bg-primary"></span>
                        <span class="text-xs font-bold text-primary uppercase tracking-wider">Material Pilihan</span>
                    </div>
                    <h2 class="pk-title text-2xl md:text-3xl lg:text-4xl">Kategori <span class="text-on-surface-variant">Konstruksi Utama</span></h2>
                </div>
                <Link :href="route('product.index')" class="group flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-primary">
                    <span>Lihat Semua Katalog</span>
                    <span class="material-symbols-outlined text-sm transition-transform group-hover:translate-x-1">arrow_forward</span>
                </Link>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-4">
                <Link v-for="category in category_global" 
                      :key="category.id" 
                      :href="route('product.index', {category_id: category.id})" 
                      class="flex flex-col items-center gap-4 p-6 bg-white border border-outline-variant rounded hover:border-primary transition-all group cursor-pointer text-center relative overflow-hidden shadow-none">
                    
                    <div class="w-14 h-14 bg-surface-container-low flex items-center justify-center rounded border border-outline-variant group-hover:bg-primary group-hover:text-white group-hover:border-primary transition-all relative z-10">
                        <span class="material-symbols-outlined text-on-surface-variant group-hover:text-white text-2xl transition-colors">
                            {{ resolveCategoryIcon(category.name) }}
                        </span>
                    </div>
                    
                    <span class="text-xs font-bold uppercase tracking-wider text-on-surface-variant group-hover:text-primary transition-colors leading-tight relative z-10">
                        {{ category.name }}
                    </span>
                </Link>
            </div>
        </div>
    </section>
</template>

<style>
/* Include Material Symbols stylesheet if not loaded */
@import url('https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0');
</style>