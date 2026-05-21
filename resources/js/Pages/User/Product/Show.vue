<script setup>
import {Head, Link, router, usePage} from "@inertiajs/vue3";
import App from "@/Layouts/App.vue";
import {ElNotification} from "element-plus";
import {Splide, SplideSlide} from "@splidejs/vue-splide";
import {ref, computed} from "vue";
import ProductList from "@/Pages/User/Product/ProductList.vue";

const props = defineProps({
    product: Object,
    related_products: Array,
})

const auth = usePage().props.auth;
const quantity = ref(1);

const increment = () => {
    if (quantity.value < props.product.quantity) {
        quantity.value++;
    }
}

const decrement = () => {
    if (quantity.value > 1) {
        quantity.value--;
    }
}

const subtotal = computed(() => {
    return quantity.value * Number(props.product.price);
})

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

    router.post(route('cart.store', product), {
        quantity: quantity.value
    }, {
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
    <App>
        <Head :title="product.title" />
        
        <div class="bg-surface min-h-screen pt-24 pb-16">
            <div class="max-w-[1440px] mx-auto px-margin-desktop">
                
                <!-- Back Link -->
                <Link :href="route('product.index')" class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-on-surface-variant hover:text-primary mb-6 transition-colors">
                    <span class="material-symbols-outlined text-xs">arrow_back</span> Kembali ke Katalog
                </Link>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 bg-white border border-outline-variant rounded p-6 md:p-8 shadow-none relative z-10">
                    <!-- Left: Splide Gallery Column -->
                    <div class="lg:col-span-6 w-full">
                        <div class="border border-outline-variant rounded overflow-hidden shadow-none bg-surface">
                            <Splide v-if="product.product_images.length" :options="{ type : 'loop', gap: '0', autoplay: true, arrows: true, pagination: true}" aria-label="Images Gallery" class="h-[300px] md:h-[450px]">
                                <SplideSlide v-for="(item, idx) in product.product_images" :key="idx" class="w-full h-full">
                                    <img class="w-full h-full object-cover" :src="resolveImageSrc(item.image)">
                                </SplideSlide>
                            </Splide>
                            <div v-else class="h-[300px] md:h-[450px] flex items-center justify-center text-on-surface-variant bg-surface">
                                <svg class="w-16 h-16 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5M3.75 21V6.75L12 3l8.25 3.75V21M8.25 21v-4.5h2.25V21m3 0v-9h2.25v9m-9-6h.008v.008H6.75V15zm0 3h.008v.008H6.75V18zm3-3h.008v.008H9.75V15zm0 3h.008v.008H9.75V18z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right: Product Information details -->
                    <div class="lg:col-span-6 flex flex-col justify-between">
                        <div>
                            <span class="text-xs font-bold text-primary uppercase tracking-wider block mb-1">
                                {{ product.brand ? product.brand.name : 'SNI PRODUCT' }}
                            </span>
                            <h1 class="text-xl md:text-2xl font-bold text-on-surface leading-tight mb-4">
                                {{ product.title }}
                            </h1>
                            
                            <!-- Star Rating -->
                            <div class="flex items-center gap-1.5 mb-6">
                                <div class="flex text-primary">
                                    <span v-for="i in 5" :key="i" class="material-symbols-outlined text-sm">star</span>
                                </div>
                                <span class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">5.0 (Review Verified)</span>
                            </div>

                            <!-- Description -->
                            <p class="text-on-surface-variant text-sm leading-relaxed mb-6 font-medium">
                                {{ product.description || 'Deskripsi produk material belum dicantumkan oleh admin toko. Silakan hubungi kontak toko untuk info selengkapnya.' }}
                            </p>

                            <!-- Specifications Manifest Grid -->
                            <div class="bg-surface border border-outline-variant rounded p-5 mb-6">
                                <span class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-4 block">Manifes Informasi Material</span>
                                <div class="grid grid-cols-2 gap-4 text-xs font-bold text-on-surface-variant">
                                    <div>
                                        <p class="text-xs font-bold text-on-surface-variant uppercase">Satuan Retail</p>
                                        <p class="text-on-surface font-bold uppercase text-sm mt-0.5">{{ product.unit_display || product.unit || 'pcs' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-on-surface-variant uppercase">Berat Kirim</p>
                                        <p class="text-on-surface font-bold uppercase text-sm mt-0.5">{{ product.weight ? `${product.weight} kg` : 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-on-surface-variant uppercase">Status Logistik</p>
                                        <span v-if="product.inStock == 1" class="mt-1 inline-block px-2 py-0.5 bg-emerald-600 text-white text-xs font-bold uppercase tracking-wider rounded-sm">Stok Ready</span>
                                        <span v-else class="mt-1 inline-block px-2 py-0.5 bg-red-600 text-white text-xs font-bold uppercase tracking-wider rounded-sm">Stok Habis</span>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-on-surface-variant uppercase">Jumlah Tersedia</p>
                                        <p class="text-on-surface font-bold uppercase text-sm mt-0.5">{{ product.quantity }} {{ product.unit_display || product.unit || 'pcs' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quantity stepper, Subtotal & CTA actions -->
                        <div class="space-y-6 pt-5 border-t border-outline-variant">
                            <!-- Stepper & Subtotal -->
                            <div v-if="product.inStock == 1" class="flex flex-wrap items-center justify-between gap-4 bg-surface p-4 rounded border border-outline-variant">
                                <div>
                                    <span class="text-xs font-bold text-on-surface-variant uppercase tracking-wider block mb-1">Jumlah Pembelian</span>
                                    <div class="flex items-center gap-1">
                                        <button @click="decrement" :disabled="quantity <= 1" class="w-8 h-8 flex items-center justify-center bg-white border border-outline-variant text-on-surface rounded hover:bg-surface disabled:opacity-50 disabled:cursor-not-allowed transition-all">
                                            &minus;
                                        </button>
                                        <input type="number" v-model.number="quantity" :min="1" :max="product.quantity" class="w-12 h-8 text-center text-xs font-bold bg-white border border-outline-variant rounded focus:ring-primary focus:border-primary p-0 outline-none" />
                                        <button @click="increment" :disabled="quantity >= product.quantity" class="w-8 h-8 flex items-center justify-center bg-white border border-outline-variant text-on-surface rounded hover:bg-surface disabled:opacity-50 disabled:cursor-not-allowed transition-all">
                                            &plus;
                                        </button>
                                        <span class="text-xs text-on-surface-variant font-bold ml-2">/ {{ product.unit_display || product.unit || 'pcs' }}</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs font-bold text-on-surface-variant uppercase tracking-wider block mb-0.5">Estimasi Subtotal</span>
                                    <span class="font-bold text-lg text-on-surface">Rp {{ subtotal.toLocaleString() }}</span>
                                </div>
                            </div>

                            <div class="flex flex-wrap items-center justify-between gap-6">
                                <div>
                                    <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-1">Harga Terbaik</p>
                                    <div class="flex items-baseline gap-1">
                                        <span class="font-bold text-2xl text-primary">Rp {{ Number(product.price).toLocaleString() }}</span>
                                        <span class="text-xs font-bold text-on-surface-variant">/ {{ product.unit_display || product.unit || 'pcs' }}</span>
                                    </div>
                                </div>

                                <div class="flex gap-3">
                                    <button v-if="product.inStock == 1" @click="addToCart(product)" class="pk-btn-accent flex items-center gap-2">
                                        <span class="material-symbols-outlined text-sm">shopping_bag</span>
                                        Tambah Ke Keranjang
                                    </button>
                                    <span v-else class="text-xs font-bold uppercase text-red-600 bg-red-50 border border-red-200 py-3 px-6 rounded leading-none">
                                        Stok Habis
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Algoritma Rekomendasi Cross Selling -->
                <div v-if="related_products && related_products.length > 0" class="mt-16 pt-10 border-t border-outline-variant">
                    <div class="mb-4">
                        <span class="text-xs font-bold text-primary uppercase tracking-wider mb-1 block">Sering Dibeli Bersama</span>
                        <h2 class="pk-title text-2xl md:text-3xl">Rekomendasi Material Serupa</h2>
                    </div>
                    <ProductList :products="{ data: related_products }" />
                </div>
                
            </div>
        </div>
    </App>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0');
</style>
