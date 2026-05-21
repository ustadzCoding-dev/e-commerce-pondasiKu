<script setup>
import {Head, router, usePage} from "@inertiajs/vue3";
import Paginate from "@/Components/Paginate.vue";
import {ElNotification} from "element-plus";
import Link from "@/Components/Link.vue";

defineProps({
    products: Object,
})

const auth = usePage().props.auth;

const resolveImageSrc = (path) => {
    if (!path) {
        return '/images/logo/logo-square.webp';
    }
    if (path.startsWith('http://') || path.startsWith('https://') || path.startsWith('/')) {
        return path;
    }
    return `/${path}`;
}

const addToCart = (product) => {
    if (!auth.user) {
        ElNotification({
            title: 'Harap Login',
            message: 'Silakan login atau daftar terlebih dahulu untuk menggunakan keranjang.',
            type: 'warning',
        });
        router.visit(route('login'));
        return;
    }

    router.post(route('cart.store', product), {}, {
        preserveScroll: true,
        onSuccess: (page) => {
            if (page.props.flash.success) {
                ElNotification({
                    title: 'Berhasil',
                    message: page.props.flash.success,
                    type: 'success',
                })
            }
        },
    })
}
</script>

<template>
    <div class="bg-white">
        <div class="mx-auto flex flex-col w-full">
            <div v-if="products.data && products.data.length > 0" class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <div v-for="product in products.data" :key="product.id" class="bg-white border border-outline-variant rounded flex flex-col justify-between overflow-hidden group shadow-none">
                    <div>
                        <!-- Image Container -->
                        <Link :href="route('product.view', product.slug)" class="block aspect-square overflow-hidden bg-surface relative group/img border-b border-outline-variant">
                            <el-carousel v-if="product.product_images.length" :interval="5000" trigger="click" class="h-full w-full custom-carousel" indicator-position="none" arrow="never">
                                <el-carousel-item v-for="(pimg, index) in product.product_images" :key="index" class="h-full w-full">
                                    <img :src="resolveImageSrc(pimg.image)" :alt="product.title" class="w-full h-full object-cover transition duration-500 group-hover:scale-105" />
                                </el-carousel-item>
                            </el-carousel>
                            <div v-else class="w-full h-full flex items-center justify-center bg-surface text-on-surface-variant">
                                <svg class="w-10 h-10 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5M3.75 21V6.75L12 3l8.25 3.75V21M8.25 21v-4.5h2.25V21m3 0v-9h2.25v9m-9-6h.008v.008H6.75V15zm0 3h.008v.008H6.75V18zm3-3h.008v.008H9.75V15zm0 3h.008v.008H9.75V18z" />
                                </svg>
                            </div>
                            
                            <!-- Status Badges -->
                            <div class="absolute top-3 left-3 z-10 flex flex-col gap-1.5">
                                <span v-if="product.is_low_stock" class="px-2 py-0.5 bg-amber-600 text-white text-xs font-bold uppercase tracking-wider rounded-sm">Stok Terbatas</span>
                                <span v-else-if="product.inStock == 1" class="px-2 py-0.5 bg-emerald-600 text-white text-xs font-bold uppercase tracking-wider rounded-sm">Tersedia</span>
                                <span v-else class="px-2 py-0.5 bg-red-600 text-white text-xs font-bold uppercase tracking-wider rounded-sm">Habis</span>
                            </div>
                        </Link>

                        <!-- Product Content -->
                        <div class="p-5">
                            <div class="mb-2">
                                <p class="text-xs font-bold uppercase tracking-wider text-primary mb-1">
                                    {{ product.brand ? product.brand.name : 'SNI PRODUCT' }}
                                </p>
                                <Link :href="route('product.view', product.slug)" class="line-clamp-2 text-sm font-bold text-on-surface hover:text-primary transition-colors leading-tight">
                                    {{ product.title }}
                                </Link>
                            </div>
                        </div>
                    </div>

                    <!-- Price & Action Section -->
                    <div class="flex items-center justify-between gap-4 p-5 border-t border-outline-variant bg-white">
                        <div>
                            <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-0.5">Mulai dari</p>
                            <div class="flex items-baseline gap-1">
                                <span class="text-base font-bold text-on-surface">Rp {{ Number(product.price).toLocaleString() }}</span>
                                <span class="text-xs font-bold text-on-surface-variant uppercase">/ {{ product.unit_display || product.unit || 'pcs' }}</span>
                            </div>
                        </div>
                        
                        <div class="flex shrink-0">
                            <button v-if="product.inStock == 1" 
                                    @click="addToCart(product)" 
                                    class="h-9 w-9 bg-primary hover:bg-opacity-95 text-white rounded flex items-center justify-center transition-all focus:outline-none focus:ring-1 focus:ring-primary"
                                    aria-label="Tambah ke keranjang">
                                <span class="material-symbols-outlined text-lg">add</span>
                            </button>
                            <span v-else class="text-xs font-bold uppercase text-red-600 border border-red-200 px-2 py-1 rounded bg-red-50">
                                Habis
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty state refined -->
            <div v-else class="text-center py-20 bg-surface border border-outline-variant rounded mt-8">
                <div class="w-16 h-16 bg-white rounded flex items-center justify-center mx-auto mb-4 border border-outline-variant">
                    <span class="material-symbols-outlined text-3xl text-on-surface-variant">inventory_2</span>
                </div>
                <h3 class="text-base font-bold text-on-surface mb-2 uppercase tracking-wider">Material Tidak Ditemukan</h3>
                <p class="text-xs text-on-surface-variant max-w-sm mx-auto mb-6 leading-relaxed font-medium">Kami tidak dapat menemukan material konstruksi yang cocok dengan penyaringan aktif Anda.</p>
                <Link :href="route('product.index')" class="pk-btn-accent px-6 py-3">Reset Semua Filter</Link>
            </div>

            <!-- Pagination refined -->
            <div v-if="products.data && products.data.length > 0" class="mt-12 flex justify-center md:justify-end">
                <Paginate :products="products" class="custom-pagination"/>
            </div>
        </div>
    </div>
</template>

<style scoped>
.custom-carousel :deep(.el-carousel__container) {
    height: 100% !important;
}

.custom-pagination :deep(.el-pagination.is-background .el-pager li:not(.is-disabled).is-active) {
    background-color: #9d4300 !important;
}
</style>