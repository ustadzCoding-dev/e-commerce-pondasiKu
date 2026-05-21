<script setup>
import {Head, Link, router} from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Paginate from "@/Components/Paginate.vue";
import {DArrowLeft, DArrowRight, Document, Search} from "@element-plus/icons-vue";
import {ref, watch} from 'vue';

const props = defineProps({
    orders: Object,
    filters: Object,
    stats: Object,
})

const search = ref(props.filters?.search || '');
watch(search, (value) => {
    router.get(
        route('admin.order.index'),
        { search: value },
        { preserveState: true, replace: true }
    );
});
</script>

<template>
    <AdminLayout>
        <Head title="Pesanan" />
        <div class="p-4 lg:p-6 bg-surface">
            <!-- Header -->
            <div class="mb-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-xl lg:text-2xl font-bold text-on-surface">Pesanan</h1>
                        <p class="text-xs text-on-surface-variant mt-1">Kelola pesanan pelanggan untuk toko Anda</p>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-white border border-outline-variant rounded p-4">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-surface border border-outline-variant rounded text-on-surface-variant">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Total Pesanan</p>
                            <p class="text-base font-bold text-on-surface">{{ stats?.total ?? orders.total }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white border border-outline-variant rounded p-4">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-surface border border-outline-variant rounded text-on-surface-variant">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Lunas</p>
                            <p class="text-base font-bold text-on-surface">{{ stats?.paid ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white border border-outline-variant rounded p-4">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-surface border border-outline-variant rounded text-on-surface-variant">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Belum Bayar</p>
                            <p class="text-base font-bold text-on-surface">{{ stats?.unpaid ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white border border-outline-variant rounded p-4">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-surface border border-outline-variant rounded text-on-surface-variant">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Total Pendapatan</p>
                            <p class="text-base font-bold text-on-surface">Rp {{ Number(stats?.revenue ?? 0).toLocaleString('id-ID') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Card -->
            <div class="bg-white border border-outline-variant rounded shadow-none overflow-hidden">
                <!-- Search Bar -->
                <div class="p-4 border-b border-outline-variant">
                    <div class="relative max-w-md">
                        <el-icon class="absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant/40" :size="18"><Search /></el-icon>
                        <input type="text" v-model="search"
                            class="w-full pl-10 pr-4 py-2.5 bg-white border border-outline-variant rounded text-xs text-on-surface placeholder-on-surface-variant/40 focus:ring-1 focus:ring-primary focus:border-transparent transition-all"
                            placeholder="Cari ID pesanan, status, atau kurir...">
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-surface border-b border-outline-variant">
                            <tr>
                                <th class="px-4 py-3 text-left text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">#</th>
                                <th class="px-4 py-3 text-left text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Produk</th>
                                <th class="px-4 py-3 text-left text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Kategori</th>
                                <th class="px-4 py-3 text-left text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Brand</th>
                                <th class="px-4 py-3 text-left text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Harga Satuan</th>
                                <th class="px-4 py-3 text-left text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Total</th>
                                <th class="px-4 py-3 text-left text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-right text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant">
                            <tr v-for="(order, i) in orders.data" :key="order.id" class="hover:bg-surface transition-colors">
                                <td class="px-4 py-3 text-xs text-on-surface-variant">{{ i + 1 }}</td>
                                <td class="px-4 py-3">
                                    <div v-for="item in order.items" :key="item.id">
                                        <span v-if="item.product" class="text-xs font-bold text-on-surface">{{ item.product.title }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-xs text-on-surface-variant">
                                    <div v-for="item in order.order_items || order.items" :key="item.id">
                                        <span v-if="item.product && item.product.category">
                                            {{ item.product.category.name }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-xs text-on-surface-variant">
                                    <div v-for="item in order.order_items || order.items" :key="item.id">
                                        <span v-if="item.product && item.product.brand">
                                            {{ item.product.brand.name }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-xs text-on-surface">
                                    <div v-for="item in order.items" :key="item.id">
                                        Rp {{ Number(item.unit_price).toLocaleString() }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-xs font-bold text-on-surface">
                                    Rp {{ Number(order.gross_amount).toLocaleString() }}
                                </td>
                                <td class="px-4 py-3">
                                    <span v-if="order.status == 'Paid'" 
                                        class="inline-flex items-center gap-1.5 px-2 py-0.5 bg-green-500/10 text-green-700 border border-green-500/20 text-[9px] font-bold rounded">
                                        <span class="w-1 h-1 bg-green-500 rounded-full"></span>
                                        Lunas
                                    </span>
                                    <span v-else 
                                        class="inline-flex items-center gap-1.5 px-2 py-0.5 bg-yellow-500/10 text-yellow-700 border border-yellow-500/20 text-[9px] font-bold rounded">
                                        <span class="w-1 h-1 bg-yellow-500 rounded-full"></span>
                                        Belum Bayar
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-2">
                                        <Link v-if="order.status == 'Paid'" :href="route('admin.order.invoice', order.id)"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-primary text-white text-[10px] font-bold uppercase tracking-wider rounded hover:bg-opacity-95 shadow transition-all">
                                            <el-icon :size="12"><Document /></el-icon>
                                            Invoice
                                        </Link>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div v-if="orders.data.length" class="p-4 border-t border-outline-variant">
                    <ul class="flex items-center justify-end gap-1">
                        <li v-for="(link, index) in orders.links" :key="index">
                            <Link v-if="link.url" :href="link.url"
                                class="flex items-center justify-center w-8 h-8 text-xs font-bold border rounded transition-colors"
                                :class="link.active 
                                    ? 'bg-primary text-white border-primary' 
                                    : 'bg-surface text-on-surface-variant border-outline-variant hover:bg-surface-variant'">
                                <el-icon v-if="link.label.includes('Previous')" :size="12"><DArrowLeft /></el-icon>
                                <el-icon v-else-if="link.label.includes('Next')" :size="12"><DArrowRight /></el-icon>
                                <span v-else>{{ link.label }}</span>
                            </Link>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
