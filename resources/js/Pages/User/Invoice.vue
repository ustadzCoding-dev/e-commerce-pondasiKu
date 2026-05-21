<script setup>
import App from "@/Layouts/App.vue";
import moment from 'moment';
import {Head, Link, usePage} from "@inertiajs/vue3";

defineProps({
    user: Object,
    total_price: Number,
    sub_total: Number,
})

const order = usePage().props.order;
const data = usePage().props.data;
</script>

<template>
    <App>
        <Head title="Invoice Logistik Resmi" />
        
        <div class="bg-surface min-h-screen pt-24 pb-20 px-4">
            <div class="bg-white border border-outline-variant rounded shadow-none p-6 md:p-10 max-w-2xl mx-auto relative z-10">
                
                <!-- Invoice Header section -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 border-b border-outline-variant pb-8 mb-8">
                    <div class="flex items-center gap-3">
                        <div class="bg-primary text-white rounded p-2 flex items-center justify-center">
                            <span class="font-display font-bold text-sm">PK</span>
                        </div>
                        <div>
                            <span class="text-base font-bold text-on-surface uppercase tracking-wider block">PondasiKu</span>
                            <span class="text-xs font-bold text-primary uppercase tracking-wider block leading-none">Material & Logistics Hub</span>
                        </div>
                    </div>
                    <div class="text-left sm:text-right">
                        <span class="inline-block px-2.5 py-0.5 bg-green-500/20 text-green-700 border border-green-500/30 font-bold text-xs rounded uppercase tracking-wider mb-2 leading-none">
                            Invoice Resmi Lunas
                        </span>
                        <p class="text-lg font-bold text-on-surface uppercase tracking-wider mb-1">INVOICE</p>
                        <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-0.5">Tanggal: {{ moment(String(order.paid_at)).format('DD/MM/YYYY HH:mm') }}</p>
                        <p class="text-xs font-bold text-on-surface uppercase tracking-wider">No Order: #{{ order.order_id }}</p>
                    </div>
                </div>

                <!-- Billing To manifest -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 border-b border-outline-variant pb-8 mb-8">
                    <div>
                        <span class="text-xs font-bold text-on-surface-variant uppercase tracking-wider block mb-2">Tujuan Pengiriman / Bill To:</span>
                        <h2 class="text-sm font-bold text-on-surface uppercase tracking-wider mb-1">{{ user.user.name }}</h2>
                        <p class="text-xs text-on-surface-variant font-medium leading-relaxed">{{ user.address1 }}</p>
                        <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mt-1">{{ user.city }}, {{ user.country_code }} {{ user.postcode }}</p>
                        <p class="text-xs text-on-surface-variant font-semibold mt-1">{{ user.user.email }}</p>
                    </div>
                    <div class="sm:text-right">
                        <span class="text-xs font-bold text-on-surface-variant uppercase tracking-wider block mb-2">Penyedia Layanan:</span>
                        <h2 class="text-sm font-bold text-on-surface uppercase tracking-wider mb-1">PondasiKu Official</h2>
                        <p class="text-xs text-on-surface-variant font-medium leading-relaxed">Hub Logistik & Penjualan SNI</p>
                        <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mt-1">Surabaya, Indonesia</p>
                    </div>
                </div>

                <!-- Items breakdown table -->
                <div class="border border-outline-variant rounded overflow-hidden mb-6 bg-surface">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-surface text-on-surface-variant text-xs font-bold uppercase tracking-wider border-b border-outline-variant">
                            <tr>
                                <th class="px-4 py-3">Nama Material</th>
                                <th class="px-4 py-3 text-center">Jumlah</th>
                                <th class="px-4 py-3 text-right">Harga Satuan</th>
                                <th class="px-4 py-3 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant text-xs">
                            <tr v-for="(item, i) in data" :key="i" class="hover:bg-white transition-colors bg-white">
                                <td class="px-4 py-3 font-bold text-on-surface leading-normal">{{ item.title }}</td>
                                <td class="px-4 py-3 text-center font-bold text-on-surface-variant">{{ item.quantity }}</td>
                                <td class="px-4 py-3 text-right font-medium text-on-surface-variant">Rp {{ Number(item.unit_price).toLocaleString() }}</td>
                                <td class="px-4 py-3 text-right font-bold text-on-surface">Rp {{ Number(item.quantity * item.unit_price).toLocaleString() }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Financial totals list -->
                <div class="space-y-2.5 border-b border-dashed border-outline-variant pb-4 mb-4 text-xs font-bold text-on-surface-variant">
                    <div class="flex justify-between items-center">
                        <span class="uppercase">Subtotal Material</span>
                        <span class="text-on-surface font-bold">Rp {{ Number(sub_total).toLocaleString() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="uppercase">Tarif Kargo RajaOngkir</span>
                        <span class="text-on-surface font-bold">Rp {{ Number(order.courir_price).toLocaleString() }}</span>
                    </div>
                </div>

                <!-- Grand Total -->
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider leading-none mb-1">Total Pembayaran Lunas</p>
                        <p class="text-xs font-medium text-on-surface-variant leading-none">Melalui Midtrans Snap Gateway</p>
                    </div>
                    <div class="text-right">
                        <span class="font-bold text-2xl text-primary">Rp {{ Number(total_price).toLocaleString() }}</span>
                    </div>
                </div>

                <!-- Invoice notes -->
                <div class="border-t border-outline-variant pt-6 mb-8 text-xs text-on-surface-variant font-medium leading-relaxed space-y-1 border-dashed">
                    <p class="font-bold uppercase text-on-surface tracking-wider">Catatan Resmi Logistik:</p>
                    <p>• Transaksi ini sah secara hukum dan diterbitkan otomatis oleh sistem logistik PondasiKu.</p>
                    <p>• Proses bongkar muat material disesuaikan dengan instruksi pada alamat bongkar proyek yang tertera.</p>
                </div>

                <!-- Back button CTA -->
                <div class="flex justify-center">
                    <Link :href="route('dashboard')" class="pk-btn-accent py-3 px-8 text-xs font-bold uppercase tracking-wider gap-2">
                        <span class="material-symbols-outlined text-sm">arrow_back</span>
                        Kembali ke Dashboard
                    </Link>
                </div>
            </div>
        </div>
    </App>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0');
</style>
