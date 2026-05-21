<script setup>
import {Head, usePage, Link, router} from '@inertiajs/vue3';
import App from "@/Layouts/App.vue";
import {computed} from "vue";

const orders = computed(() => usePage().props.orders)
const stats = computed(() => usePage().props.stats)

function payOrder(order) {
    router.visit(route('pay.show', order.id))
}
</script>

<template>
    <App>
        <Head title="Dashboard Saya" />
        
        <div class="bg-surface min-h-screen pt-20 pb-20">
            <!-- Header Minimalis -->
            <div class="max-w-[1440px] mx-auto px-margin-desktop mb-8">
                <h1 class="text-2xl font-bold text-on-surface mb-2">Dashboard Saya</h1>
                <p class="text-sm text-on-surface-variant max-w-2xl">Kelola status logistik pengiriman material, konfirmasi pembayaran invoice, dan lihat riwayat transaksi konstruksi Anda.</p>
            </div>

            <div class="max-w-[1440px] mx-auto px-margin-desktop mt-8 relative z-10">
                <!-- Statistics Overview Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- Total Orders -->
                    <div class="bg-white border border-outline-variant p-5 rounded shadow-none flex items-center gap-4">
                        <div class="w-12 h-12 bg-surface border border-outline-variant rounded flex items-center justify-center text-on-surface">
                            <span class="material-symbols-outlined text-xl">shopping_bag</span>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-on-surface-variant uppercase tracking-wider block mb-1">Total Pesanan</span>
                            <p class="font-bold text-2xl text-on-surface leading-none">{{ stats.total }}</p>
                        </div>
                    </div>

                    <!-- Unpaid orders -->
                    <div class="bg-white border border-outline-variant p-5 rounded shadow-none flex items-center gap-4">
                        <div class="w-12 h-12 bg-primary/10 border border-primary/20 rounded flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-xl">pending_actions</span>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-on-surface-variant uppercase tracking-wider block mb-1">Belum Terbayar</span>
                            <p class="font-bold text-2xl text-on-surface leading-none">{{ stats.unpaid }}</p>
                        </div>
                    </div>

                    <!-- Paid orders -->
                    <div class="bg-white border border-outline-variant p-5 rounded shadow-none flex items-center gap-4">
                        <div class="w-12 h-12 bg-green-500/10 border border-green-500/20 rounded flex items-center justify-center text-green-700">
                            <span class="material-symbols-outlined text-xl">check_circle</span>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-on-surface-variant uppercase tracking-wider block mb-1">Sudah Terbayar</span>
                            <p class="font-bold text-2xl text-on-surface leading-none">{{ stats.paid }}</p>
                        </div>
                    </div>
                </div>

                <!-- Riwayat Pesanan Table details -->
                <div class="bg-white border border-outline-variant rounded overflow-hidden shadow-none">
                    <div class="p-6 border-b border-outline-variant flex flex-col sm:flex-row justify-between items-center gap-4 bg-white">
                        <div>
                            <span class="text-xs font-bold text-primary uppercase tracking-wider mb-1 block">Arsip Transaksi</span>
                            <h2 class="text-sm font-bold text-on-surface uppercase tracking-wider">Riwayat Pesanan Proyek</h2>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-surface text-on-surface-variant text-xs font-bold uppercase tracking-wider border-b border-outline-variant">
                                <tr>
                                    <th class="px-6 py-4">ID & Tanggal Pesanan</th>
                                    <th class="px-6 py-4">Item Material</th>
                                    <th class="px-6 py-4">Total Bayar</th>
                                    <th class="px-6 py-4">Status Invoice</th>
                                    <th class="px-6 py-4 text-right">Tindakan Logistik</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-outline-variant">
                                <tr v-if="orders.data.length" v-for="(order, key) in orders.data" :key="key" class="hover:bg-surface bg-white transition-colors">
                                    <!-- ID and Date -->
                                    <td class="px-6 py-5">
                                        <span class="font-bold text-on-surface block">#{{ order.order_id }}</span>
                                        <span class="text-xs font-bold text-on-surface-variant uppercase tracking-wider block mt-1">
                                            {{ new Date(order.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) }}
                                        </span>
                                    </td>
                                    
                                    <!-- Items -->
                                    <td class="px-6 py-5">
                                        <div class="space-y-1.5">
                                            <div v-for="(item, i) in order.items" :key="i" class="text-xs text-on-surface font-bold flex items-center gap-2">
                                                <span class="w-1.5 h-1.5 bg-primary rounded-full"></span>
                                                <span>{{ item.product ? item.product.title : '-' }}</span>
                                                <span class="text-xs text-on-surface-variant font-bold">(x{{ item.quantity }})</span>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <!-- Gross Amount -->
                                    <td class="px-6 py-5 font-bold text-on-surface text-sm">
                                        Rp {{ Number(order.gross_amount).toLocaleString() }}
                                    </td>
                                    
                                    <!-- Status Badge -->
                                    <td class="px-6 py-5">
                                        <span v-if="order.status === 'Unpaid'" class="inline-block px-2 py-0.5 text-xs font-bold bg-primary/10 text-primary border border-primary/20 rounded uppercase tracking-wider">Belum Bayar</span>
                                        <span v-else class="inline-block px-2 py-0.5 text-xs font-bold bg-green-500/10 text-green-700 border border-green-500/20 rounded uppercase tracking-wider">Lunas</span>
                                    </td>
                                    
                                    <!-- CTA actions -->
                                    <td class="px-6 py-5 text-right">
                                        <button @click="payOrder(order)" v-if="order.status === 'Unpaid'" class="pk-btn-accent px-4 py-2 text-xs font-bold uppercase tracking-wider inline-flex items-center gap-1.5 shadow-none">
                                            <span class="material-symbols-outlined text-sm">payments</span>
                                            Bayar
                                        </button>
                                        <Link :href="route('invoice', order.id)" v-else class="inline-flex items-center gap-1.5 px-4 py-2 border border-outline-variant text-on-surface hover:text-primary hover:border-primary text-xs font-bold rounded uppercase tracking-wider transition-colors bg-white">
                                            <span class="material-symbols-outlined text-sm">receipt_long</span>
                                            Invoice
                                        </Link>
                                    </td>
                                </tr>
                                
                                <!-- Empty state -->
                                <tr v-else>
                                    <td colspan="5" class="py-16 text-center">
                                        <div class="w-12 h-12 bg-surface border border-outline-variant rounded flex items-center justify-center mx-auto mb-4 text-on-surface-variant">
                                            <span class="material-symbols-outlined text-2xl">receipt_long</span>
                                        </div>
                                        <p class="text-xs text-on-surface-variant font-bold uppercase tracking-wider">Belum ada manifest pesanan proyek</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination rows -->
                    <div v-if="orders.data.length" class="p-5 border-t border-outline-variant bg-surface">
                        <div class="flex justify-center">
                            <ul class="flex gap-2">
                                <li v-for="(link, index) in orders.links" :key="index">
                                    <Link v-if="link.url" :href="link.url" 
                                        :class="[
                                            'w-9 h-9 flex items-center justify-center rounded font-bold text-xs transition-all border',
                                            link.active 
                                                ? 'bg-primary border-primary text-white' 
                                                : 'bg-white border-outline-variant text-on-surface-variant hover:border-primary'
                                        ]"
                                        v-html="link.label.includes('Previous') ? '&larr;' : (link.label.includes('Next') ? '&rarr;' : link.label)"
                                    />
                                    <span v-else 
                                        class="w-9 h-9 flex items-center justify-center rounded border border-outline-variant/50 text-on-surface-variant/40 cursor-not-allowed"
                                        v-html="link.label.includes('Previous') ? '&larr;' : (link.label.includes('Next') ? '&rarr;' : link.label)"
                                    />
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </App>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0');
</style>
