<script setup>
import App from "@/Layouts/App.vue";
import {Head, router, usePage} from "@inertiajs/vue3";
import {ElNotification} from "element-plus";

const auth = usePage().props.auth;
defineProps({
    order: Object,
    token: String,
    total_product: Number,
    total_price: Number,
})

const handlePayment = (token) => {
    window.snap.pay(token, {
        onSuccess: function (result) {
            console.log(result);
            ElNotification({
                title: 'Pembayaran Sukses',
                message: 'Pesanan Anda telah berhasil diproses!',
                type: 'success',
            })
            router.visit(route('dashboard'));
        },
        onPending: function (result) {
            ElNotification({
                title: 'Menunggu Pembayaran',
                message: 'Silakan selesaikan transaksi Anda di Snap Midtrans!',
                type: 'warning',
            })
            console.log(result);
        },
        onError: function (result) {
            ElNotification({
                title: 'Pembayaran Gagal',
                message: 'Maaf, transaksi Anda gagal diproses.',
                type: 'error',
            })
            console.log(result);
        },
        onClose: function () {
            ElNotification({
                title: 'Informasi',
                message: 'Anda menutup popup pembayaran Snap Midtrans.',
                type: 'info',
            })
        },
    });
};
</script>

<template>
    <App>
        <Head title="Pembayaran Aman Midtrans" />
        
        <div class="min-w-screen min-h-screen bg-surface flex items-center justify-center px-4 pb-12 pt-24">
            <div class="w-full mx-auto bg-white border border-outline-variant rounded shadow-none p-6 md:p-8 text-on-surface relative z-10" style="max-width: 540px">
                
                <!-- Logo Header decoration -->
                <div class="w-full pt-1 pb-6 flex flex-col items-center">
                    <div class="bg-primary/10 border border-primary/20 rounded w-12 h-12 flex justify-center items-center mb-3">
                        <span class="font-display font-bold text-xl text-primary">PK</span>
                    </div>
                    <span class="inline-block px-2.5 py-0.5 bg-primary/20 text-primary border border-primary/30 font-bold text-xs rounded uppercase tracking-wider mb-1">
                        Secure Sandbox Gateway
                    </span>
                    <h1 class="text-lg font-bold text-on-surface uppercase tracking-wider text-center">
                        Konfirmasi Pembayaran
                    </h1>
                </div>

                <!-- Product Manifest receipt table -->
                <div class="border border-outline-variant rounded overflow-hidden mb-6 bg-surface">
                    <table class="w-full text-xs text-left text-on-surface-variant">
                        <thead class="text-xs font-bold text-on-surface-variant uppercase bg-surface border-b border-outline-variant">
                            <tr>
                                <th scope="col" class="px-4 py-2.5">Deskripsi Material</th>
                                <th scope="col" class="px-4 py-2.5 text-center">Qty</th>
                                <th scope="col" class="px-4 py-2.5 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant">
                            <tr v-for="(item, i) in order.items" :key="i" class="hover:bg-white transition-colors bg-white">
                                <th scope="row" class="px-4 py-3 font-bold text-on-surface leading-normal">
                                    <div class="line-clamp-1">{{ item.product ? item.product.title : '-' }}</div>
                                </th>
                                <td class="px-4 py-3 text-center font-bold text-on-surface-variant">
                                    {{ item.quantity }}
                                </td>
                                <td class="px-4 py-3 text-right font-bold text-on-surface">
                                    Rp {{ Number(item.unit_price * item.quantity).toLocaleString() }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Financial breakdown receipt -->
                <div class="space-y-2 border-b border-dashed border-outline-variant pb-4 mb-4 text-xs font-bold text-on-surface-variant">
                    <div class="flex justify-between items-center">
                        <span class="uppercase">Subtotal Material</span>
                        <span class="text-on-surface font-bold">Rp {{ Number(order.gross_amount).toLocaleString() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="uppercase">Tarif Kargo RajaOngkir</span>
                        <span class="text-on-surface font-bold">Rp {{ Number(order.courir_price).toLocaleString() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="uppercase">Jumlah Item Unik</span>
                        <span class="text-on-surface font-bold">{{ total_product }} unit</span>
                    </div>
                </div>

                <!-- Grand Total -->
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider leading-none mb-1">Total Tagihan Invoice</p>
                        <p class="text-xs font-medium text-on-surface-variant leading-none">Termasuk Kargo & PPN</p>
                    </div>
                    <div class="text-right">
                        <span class="font-bold text-2xl text-primary">Rp {{ Number(total_price).toLocaleString() }}</span>
                    </div>
                </div>

                <!-- Pay Now Action buttons -->
                <div class="flex flex-col gap-3 items-center">
                    <button @click="handlePayment(token)" class="w-full pk-btn-accent flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-sm">security</span>
                        Bayar Sekarang via Snap
                    </button>
                    <Link :href="route('dashboard')" class="text-xs font-bold text-on-surface-variant hover:text-primary uppercase tracking-wider mt-1">
                        Kembali Ke Dashboard
                    </Link>
                </div>
            </div>
        </div>
    </App>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0');
</style>
