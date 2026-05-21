<script setup>
import App from "@/Layouts/App.vue";
import {Head, router, usePage} from "@inertiajs/vue3";
import Feature from "@/Pages/User/components/Feature.vue";
import Review from "@/Pages/User/components/Review.vue";
import Contact from "@/Pages/User/components/Contact.vue";
import {ElNotification} from "element-plus";
import CategoryList from "@/Pages/User/components/CategoryList.vue";
import BrandList from "@/Pages/User/components/BrandList.vue";
import Header from "@/Pages/User/components/Header.vue";
import Panel from "@/Pages/User/components/Panel.vue";
import Link from "@/Components/Link.vue"

defineProps({
    products: Object,
});

const resolveImageSrc = (path) => {
    if (!path) {
        return '/images/logo/logo-square.webp';
    }
    if (path.startsWith('http://') || path.startsWith('https://') || path.startsWith('/')) {
        return path;
    }
    return `/${path}`;
}

const firstProductImage = (product) => resolveImageSrc(product.product_images?.[0]?.image);

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
        quantity: 1
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
        <Head>
            <title>Beranda - PondasiKu Material Bangunan</title>
            <meta name="description" content="Pusat material bangunan terpopuler dan berkualitas tinggi. Temukan berbagai macam bahan bangunan dengan harga terbaik dan layanan pesan antar." />
        </Head>
        <Header/>
        <Panel/>
        
        <!-- Category Section -->
        <CategoryList/>
        
        <div class="bg-white py-16 border-b border-outline-variant">
            <div class="max-w-[1440px] mx-auto px-margin-desktop">
                <!-- Header with improved typography -->
                <div class="mb-12 flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
                    <div class="max-w-2xl">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="h-1 w-6 bg-primary"></span>
                            <span class="text-xs font-bold text-primary uppercase tracking-wider">Pilihan Terbaik</span>
                        </div>
                        <h2 class="pk-title text-2xl md:text-3xl lg:text-4xl">Material Bangunan <br/> <span class="text-on-surface-variant">Terpopuler & Berkualitas</span></h2>
                    </div>
                    <div class="md:w-1/3">
                        <p class="text-on-surface-variant text-sm leading-relaxed font-medium italic">
                            "Kualitas material menentukan kekuatan bangunan Anda. Kami menyediakan suplai bahan konstruksi bersertifikasi SNI."
                        </p>
                    </div>
                </div>

                <!-- Products Grid with BuildBase pk-card -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div v-for="product in products.data" :key="product.id" class="bg-white border border-outline-variant rounded flex flex-col justify-between overflow-hidden group shadow-sm hover:shadow-md transition-shadow duration-300">
                        <div class="relative">
                            <!-- Product Image -->
                            <Link :href="route('product.view', product.slug)" class="block aspect-square overflow-hidden bg-surface relative border-b border-outline-variant">
                                <img :src="firstProductImage(product)" :alt="product.title" class="block h-full w-full object-cover object-center transition duration-500 group-hover:scale-105" />
                            </Link>

                            <!-- Stock Badge -->
                            <div class="absolute top-3 left-3 z-10">
                                <span v-if="product.inStock == 1" class="px-2 py-0.5 bg-emerald-600 text-white text-xs font-bold uppercase tracking-wider rounded-sm shadow-none">Ready</span>
                                <span v-else class="px-2 py-0.5 bg-red-600 text-white text-xs font-bold uppercase tracking-wider rounded-sm shadow-none">Habis</span>
                            </div>
                        </div>

                        <!-- Product Info -->
                        <div class="p-5 flex-grow flex flex-col justify-between">
                            <div class="mb-4">
                                <p class="text-xs font-bold uppercase tracking-wider text-primary mb-1">
                                    {{ product.brand ? product.brand.name : 'SNI PRODUCT' }}
                                </p>
                                <Link :href="route('product.view', product.slug)" class="line-clamp-2 text-sm font-bold text-on-surface hover:text-primary transition-colors leading-tight">
                                    {{ product.title }}
                                </Link>
                            </div>
                            
                            <!-- Price Section -->
                            <div class="pt-4 border-t border-outline-variant flex items-center justify-between gap-4">
                                <div>
                                    <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-0.5">Mulai dari</p>
                                    <div class="flex items-baseline gap-1">
                                        <span class="text-base font-bold text-on-surface">Rp {{ Number(product.price).toLocaleString() }}</span>
                                        <span class="text-xs font-bold text-on-surface-variant uppercase">/ {{ product.unit_display || product.unit || 'pcs' }}</span>
                                    </div>
                                </div>
                                
                                <button v-if="product.inStock == 1" 
                                        @click="addToCart(product)" 
                                        class="h-9 w-9 bg-primary hover:bg-opacity-95 text-white rounded flex items-center justify-center transition-all focus:outline-none focus:ring-1 focus:ring-primary"
                                        aria-label="Tambah ke keranjang">
                                    <span class="material-symbols-outlined text-lg">add</span>
                                </button>
                                <div v-else class="h-9 flex items-center">
                                    <span class="text-xs font-bold uppercase text-red-600">Habis</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer View All CTA -->
                <div class="mt-12 flex flex-col items-center">
                    <p class="text-on-surface-variant text-xs font-bold mb-4">Mencari material lainnya?</p>
                    <Link :href="route('product.index')" class="pk-btn-accent px-8 py-3.5 group text-white">
                        <span class="text-white">Lihat Semua Katalog</span>
                        <span class="material-symbols-outlined text-sm ml-1 transition-transform group-hover:translate-x-1 text-white">arrow_forward</span>
                    </Link>
                </div>
            </div>
        </div>

        <!-- Sections with refined backgrounds -->
        <div class="bg-slate-50 ">
            <BrandList/>
        </div>
        <Review/>
        <Feature/>
        <Contact/>
    </App>
</template>