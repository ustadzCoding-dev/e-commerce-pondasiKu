<script setup>
import App from "@/Layouts/App.vue";
import moment from 'moment';
import Link from "@/Components/Link.vue";
import {Head, usePage} from "@inertiajs/vue3";

defineProps({
    user:Object,
    total_price:Number,
    sub_total:Number,
})

const order = usePage().props.order;
const data = usePage().props.data;
</script>

<template>
    <App>
        <Head title="Invoice Logistik Admin" />
        <div class="py-12 bg-surface min-h-screen pt-24">
            <div class="bg-white rounded border border-outline-variant px-8 py-10 max-w-xl mx-auto relative z-10">
                <div class="flex items-center justify-between mb-8 border-b border-outline-variant pb-6">
                    <div class="flex items-center gap-3">
                        <div class="bg-surface border border-outline-variant rounded p-1.5 flex items-center justify-center">
                            <img class="h-8 w-8 object-contain" :src="`/images/logo/logo-square.webp`" alt="Logo" />
                        </div>
                        <div>
                            <span class="font-bold text-lg text-on-surface uppercase tracking-wider block">PondasiKu</span>
                            <span class="text-[8px] font-bold text-primary uppercase tracking-widest block leading-none">Material & Logistics Hub</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="font-bold text-xl mb-1 tracking-wider text-on-surface">INVOICE</div>
                        <div class="text-[10px] text-on-surface-variant font-bold uppercase tracking-wider">Tanggal: {{ moment(String(order.paid_at)).format('DD/MM/YYYY HH:mm') }}</div>
                        <div class="text-[10px] font-bold text-on-surface uppercase tracking-wider">No Order: #{{ order.order_id }}</div>
                    </div>
                </div>

                <div class="border-b border-outline-variant pb-6 mb-6">
                    <span class="text-[9px] font-bold text-on-surface-variant uppercase tracking-widest mb-3 block">Informasi Penerima / Proyek</span>
                    <div class="text-xs font-bold text-on-surface">
                        <p class="font-bold text-sm text-on-surface mb-1 uppercase">{{ user.user.name }}</p>
                        <p class="mb-1 text-on-surface-variant">{{ user.address1 }}</p>
                        <p class="mb-1 text-on-surface-variant">{{ user.city }}, {{ user.country_code }} {{ user.postcode }}</p>
                        <p class="text-on-surface-variant font-medium">{{ user.user.email }}</p>
                    </div>
                </div>

                <table class="w-full text-left mb-6 text-xs">
                    <thead>
                        <tr class="border-b border-outline-variant text-[9px] font-bold text-on-surface-variant uppercase">
                            <th class="py-2">Deskripsi Material</th>
                            <th class="py-2 text-center">Qty</th>
                            <th class="py-2 text-right">Harga Satuan</th>
                            <th class="py-2 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant font-bold text-on-surface">
                        <tr v-for="(item, i) in data" :key="i">
                            <td class="py-3 uppercase font-bold text-[11px] text-on-surface">
                                {{ item.title }}
                            </td>
                            <td class="py-3 text-center text-on-surface-variant">{{item.quantity}}</td>
                            <td class="py-3 text-right text-on-surface-variant">Rp {{ Number(item.unit_price).toLocaleString() }}</td>
                            <td class="py-3 text-right text-on-surface">Rp {{ Number(item.quantity * item.unit_price).toLocaleString() }}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="space-y-2 border-t border-outline-variant pt-4 text-xs font-bold text-on-surface-variant">
                    <div class="flex justify-between">
                        <span>Subtotal Material:</span>
                        <span class="text-on-surface">Rp {{ Number(sub_total).toLocaleString() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Tarif Kargo RajaOngkir:</span>
                        <span class="text-on-surface">Rp {{ Number(order.courir_price).toLocaleString() }}</span>
                    </div>
                    <div class="flex justify-between border-t border-outline-variant pt-2 text-sm">
                        <span class="font-bold text-on-surface">Total Bayar:</span>
                        <span class="font-bold text-primary">Rp {{ Number(total_price).toLocaleString() }}</span>
                    </div>
                </div>

                <div class="border-t border-outline-variant pt-6 mt-6 mb-8 text-[10px] text-on-surface-variant leading-relaxed font-medium">
                    <p class="mb-1">Pembayaran ini diproses secara otomatis oleh sistem SNAP Midtrans Sandbox.</p>
                    <p class="text-green-600 font-bold">Status: LUNAS & TERVERIFIKASI LOGISTIK.</p>
                </div>

                <div class="flex justify-center border-t border-outline-variant pt-6">
                    <Link :href="route('admin.order.index')" class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-primary text-white font-bold text-xs uppercase tracking-wider rounded hover:bg-opacity-95 shadow transition-all">
                        Kembali Ke Order
                    </Link>
                </div>
            </div>
        </div>
    </App>
</template>
