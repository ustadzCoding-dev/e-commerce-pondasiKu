<script setup>
import {Head, Link} from '@inertiajs/vue3';
import AdminLayout from "@/Layouts/AdminLayout.vue";

defineProps({
    brand: Number,
    category: Number,
    product: Number,
    order: Number,
    paidOrders: Number,
    unpaidOrders: Number,
    totalRevenue: Number,
    monthlyRevenue: Number,
    recentOrders: Array,
    lowStockProducts: Array,
})

function formatCurrency(amount) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
    }).format(amount);
}
</script>

<template>
    <AdminLayout>
        <Head title="Dashboard Admin" />
        
        <div class="p-4 lg:p-6 space-y-6">
            <!-- Page Header -->
            <div class="mb-2">
                <h1 class="text-2xl lg:text-3xl font-bold text-on-surface uppercase tracking-tight">
                    Dashboard Admin
                </h1>
                <p class="text-xs text-on-surface-variant mt-1">
                    Selamat datang kembali! Berikut ringkasan toko Anda hari ini.
                </p>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
                <!-- Total Revenue -->
                <div class="bg-white border border-outline-variant rounded p-4 lg:p-6 shadow-none">
                    <div class="flex items-center justify-between mb-3">
                        <div class="p-2 bg-surface border border-outline-variant rounded text-on-surface-variant">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span class="text-[9px] font-bold text-primary bg-primary/10 border border-primary/20 px-2 py-0.5 rounded uppercase tracking-wider">
                            Total
                        </span>
                    </div>
                    <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider mb-1">Pendapatan</p>
                    <p class="text-base lg:text-lg font-bold text-on-surface truncate">
                        {{ formatCurrency(totalRevenue) }}
                    </p>
                </div>

                <!-- Monthly Revenue -->
                <div class="bg-white border border-outline-variant rounded p-4 lg:p-6 shadow-none">
                    <div class="flex items-center justify-between mb-3">
                        <div class="p-2 bg-surface border border-outline-variant rounded text-on-surface-variant">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <span class="text-[9px] font-bold text-primary bg-primary/10 border border-primary/20 px-2 py-0.5 rounded uppercase tracking-wider">
                            Bulan Ini
                        </span>
                    </div>
                    <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider mb-1">Pendapatan</p>
                    <p class="text-base lg:text-lg font-bold text-on-surface truncate">
                        {{ formatCurrency(monthlyRevenue) }}
                    </p>
                </div>

                <!-- Total Orders -->
                <div class="bg-white border border-outline-variant rounded p-4 lg:p-6 shadow-none">
                    <div class="flex items-center justify-between mb-3">
                        <div class="p-2 bg-surface border border-outline-variant rounded text-on-surface-variant">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <span class="text-[9px] font-bold text-green-700 bg-green-500/10 border border-green-500/20 px-2 py-0.5 rounded uppercase tracking-wider">
                            {{ paidOrders }} Lunas
                        </span>
                    </div>
                    <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider mb-1">Total Pesanan</p>
                    <p class="text-lg font-bold text-on-surface">
                        {{ order }}
                    </p>
                </div>

                <!-- Unpaid Orders -->
                <div class="bg-white border border-outline-variant rounded p-4 lg:p-6 shadow-none">
                    <div class="flex items-center justify-between mb-3">
                        <div class="p-2 bg-surface border border-outline-variant rounded text-on-surface-variant">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span class="text-[9px] font-bold text-primary bg-primary/10 border border-primary/20 px-2 py-0.5 rounded uppercase tracking-wider">
                            Menunggu
                        </span>
                    </div>
                    <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider mb-1">Belum Bayar</p>
                    <p class="text-lg font-bold text-on-surface">
                        {{ unpaidOrders }}
                    </p>
                </div>
            </div>

            <!-- Inventory Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 lg:gap-6">
                <!-- Categories -->
                <div class="bg-white border border-outline-variant rounded p-4 lg:p-6 text-on-surface shadow-none flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Kategori</span>
                        <p class="text-3xl font-bold mt-1 text-on-surface">{{ category }}</p>
                    </div>
                    <div class="p-2.5 bg-surface border border-outline-variant rounded text-on-surface-variant">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                </div>

                <!-- Brands -->
                <div class="bg-white border border-outline-variant rounded p-4 lg:p-6 text-on-surface shadow-none flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Brand</span>
                        <p class="text-3xl font-bold mt-1 text-on-surface">{{ brand }}</p>
                    </div>
                    <div class="p-2.5 bg-surface border border-outline-variant rounded text-on-surface-variant">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                </div>

                <!-- Products -->
                <div class="bg-white border border-outline-variant rounded p-4 lg:p-6 text-on-surface shadow-none flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Produk</span>
                        <p class="text-3xl font-bold mt-1 text-on-surface">{{ product }}</p>
                    </div>
                    <div class="p-2.5 bg-surface border border-outline-variant rounded text-on-surface-variant">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white border border-outline-variant rounded p-4 lg:p-6 shadow-none">
                <h2 class="text-sm font-bold text-on-surface mb-4 uppercase tracking-wider">
                    Aksi Cepat
                </h2>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                    <Link :href="route('admin.product.index')" class="flex items-center gap-3 p-3 bg-white border border-outline-variant rounded hover:bg-surface hover:text-primary transition-all group">
                        <div class="p-2 bg-surface border border-outline-variant rounded group-hover:bg-white transition-colors text-on-surface-variant group-hover:text-primary">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <span class="text-xs font-bold text-on-surface-variant group-hover:text-primary">Tambah Produk</span>
                    </Link>
                    
                    <Link :href="route('admin.category.index')" class="flex items-center gap-3 p-3 bg-white border border-outline-variant rounded hover:bg-surface hover:text-primary transition-all group">
                        <div class="p-2 bg-surface border border-outline-variant rounded group-hover:bg-white transition-colors text-on-surface-variant group-hover:text-primary">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <span class="text-xs font-bold text-on-surface-variant group-hover:text-primary">Tambah Kategori</span>
                    </Link>
                    
                    <Link :href="route('admin.brand.index')" class="flex items-center gap-3 p-3 bg-white border border-outline-variant rounded hover:bg-surface hover:text-primary transition-all group">
                        <div class="p-2 bg-surface border border-outline-variant rounded group-hover:bg-white transition-colors text-on-surface-variant group-hover:text-primary">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <span class="text-xs font-bold text-on-surface-variant group-hover:text-primary">Tambah Brand</span>
                    </Link>
                    
                    <Link :href="route('admin.order.index')" class="flex items-center gap-3 p-3 bg-white border border-outline-variant rounded hover:bg-surface hover:text-primary transition-all group">
                        <div class="p-2 bg-surface border border-outline-variant rounded group-hover:bg-white transition-colors text-on-surface-variant group-hover:text-primary">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <span class="text-xs font-bold text-on-surface-variant group-hover:text-primary">Lihat Pesanan</span>
                    </Link>
                </div>
            </div>

            <!-- Two Column Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Orders -->
                <div class="bg-white border border-outline-variant rounded shadow-none overflow-hidden">
                    <div class="p-4 lg:p-6 border-b border-outline-variant flex justify-between items-center bg-white">
                        <h2 class="text-sm font-bold text-on-surface uppercase tracking-wider">
                            Pesanan Terbaru
                        </h2>
                        <Link :href="route('admin.order.index')" class="text-[10px] font-bold text-primary uppercase tracking-wider hover:underline">
                            Lihat Semua
                        </Link>
                    </div>
                    
                    <div class="divide-y divide-outline-variant">
                        <div v-if="recentOrders.length === 0" class="p-8 text-center bg-white">
                            <svg class="w-12 h-12 text-on-surface-variant/40 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <p class="text-xs text-on-surface-variant font-bold uppercase tracking-wider">Belum ada pesanan</p>
                        </div>
                        
                        <div v-else v-for="order in recentOrders" :key="order.id" class="p-4 hover:bg-surface bg-white transition-colors">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-bold text-on-surface text-sm">#{{ order.order_id }}</span>
                                <span :class="[
                                    'px-2 py-0.5 rounded text-[9px] font-bold uppercase tracking-wider border',
                                    order.status === 'Paid' 
                                        ? 'bg-green-500/10 text-green-700 border-green-500/20' 
                                        : 'bg-primary/10 text-primary border-primary/20'
                                ]">
                                    {{ order.status === 'Paid' ? 'Lunas' : 'Belum Bayar' }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="text-xs text-on-surface-variant font-medium">
                                    {{ order.items.length }} item
                                </div>
                                <div class="font-bold text-on-surface text-sm">
                                    {{ formatCurrency(order.gross_amount) }}
                                </div>
                            </div>
                            <div class="text-[9px] text-on-surface-variant uppercase tracking-wider mt-1.5">{{ order.created_at }}</div>
                        </div>
                    </div>
                </div>

                <!-- Low Stock Alert -->
                <div class="bg-white border border-outline-variant rounded shadow-none overflow-hidden">
                    <div class="p-4 lg:p-6 border-b border-outline-variant flex justify-between items-center bg-white">
                        <h2 class="text-sm font-bold text-on-surface uppercase tracking-wider">
                            Stok Menipis
                        </h2>
                        <span class="text-[9px] font-bold text-primary bg-primary/10 border border-primary/20 px-2 py-0.5 rounded uppercase tracking-wider">
                            Peringatan
                        </span>
                    </div>
                    
                    <div class="divide-y divide-outline-variant">
                        <div v-if="lowStockProducts.length === 0" class="p-8 text-center bg-white">
                            <svg class="w-12 h-12 text-green-700/50 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-xs text-on-surface-variant font-bold uppercase tracking-wider">Semua stok aman</p>
                        </div>
                        
                        <div v-else v-for="product in lowStockProducts" :key="product.id" class="p-4 hover:bg-surface bg-white transition-colors">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-bold text-on-surface text-sm">{{ product.title }}</p>
                                    <p class="text-xs text-on-surface-variant">ID: {{ product.id }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-primary text-lg leading-none">{{ product.quantity }}</p>
                                    <p class="text-[8px] text-on-surface-variant uppercase tracking-wider mt-1">unit tersisa</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
