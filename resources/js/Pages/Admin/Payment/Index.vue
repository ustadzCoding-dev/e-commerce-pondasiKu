<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { ref, watch } from "vue";
import { Search, CreditCard, Ticket, Calendar, Money, Check, Close, Warning } from "@element-plus/icons-vue";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({
    payments: Object,
    filters: Object,
});

const search = ref(props.filters.search || "");

watch(search, (value) => {
    router.get(
        route("admin.payment.index"),
        { search: value },
        { preserveState: true, replace: true }
    );
});

const getStatusType = (status) => {
    switch (status?.toLowerCase()) {
        case 'settlement':
        case 'capture':
        case 'paid':
            return 'success';
        case 'pending':
            return 'warning';
        case 'expire':
        case 'cancel':
        case 'deny':
        case 'unpaid':
            return 'danger';
        default:
            return 'info';
    }
};

const getStatusLabel = (status) => {
    switch (status?.toLowerCase()) {
        case 'settlement':
        case 'capture':
        case 'paid':
            return 'Lunas';
        case 'pending':
            return 'Menunggu';
        case 'expire':
            return 'Kedaluwarsa';
        case 'cancel':
            return 'Dibatalkan';
        case 'deny':
            return 'Ditolak';
        default:
            return status || 'Unknown';
    }
};
</script>

<template>
    <AdminLayout>
        <Head title="Transaksi Pembayaran" />
        <div class="p-4 lg:p-6 bg-surface">
            <!-- Header -->
            <div class="mb-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-xl lg:text-2xl font-bold text-on-surface">Transaksi Pembayaran</h1>
                        <p class="text-xs text-on-surface-variant mt-1">Pantau status transaksi pembayaran Midtrans pelanggan</p>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-white border border-outline-variant rounded p-4">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-surface border border-outline-variant rounded text-on-surface-variant">
                            <el-icon class="text-on-surface" :size="20"><CreditCard /></el-icon>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Total Transaksi</p>
                            <p class="text-base font-bold text-on-surface">{{ payments.total }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white border border-outline-variant rounded p-4">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-surface border border-outline-variant rounded text-on-surface-variant">
                            <el-icon class="text-on-surface" :size="20"><Check /></el-icon>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Berhasil</p>
                            <p class="text-base font-bold text-on-surface">
                                {{ payments.data.filter(p => ['settlement', 'capture', 'paid'].includes(p.status?.toLowerCase())).length }}
                            </p>
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
                            placeholder="Cari ID Order atau ID Transaksi...">
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-surface border-b border-outline-variant">
                            <tr>
                                <th class="px-4 py-3 text-left text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">ID Order</th>
                                <th class="px-4 py-3 text-left text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Metode</th>
                                <th class="px-4 py-3 text-left text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Total Bayar</th>
                                <th class="px-4 py-3 text-left text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-left text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Waktu</th>
                                <th class="px-4 py-3 text-right text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Detail</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant">
                            <tr v-for="payment in payments.data" :key="payment.id" class="hover:bg-surface transition-colors">
                                <td class="px-4 py-3">
                                    <div class="flex flex-col">
                                        <span class="text-xs font-bold text-on-surface">#{{ payment.order_id }}</span>
                                        <span class="text-[9px] text-on-surface-variant truncate max-w-[150px]">{{ payment.transaction_id }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-[9px] font-bold text-on-surface-variant uppercase bg-surface border border-outline-variant px-2 py-0.5 rounded">
                                        {{ payment.type?.replace('_', ' ') }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-xs font-bold text-on-surface">
                                        Rp {{ Number(payment.amount).toLocaleString() }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span 
                                        class="inline-flex items-center gap-1.5 px-2 py-0.5 text-[9px] font-bold rounded border"
                                        :class="{
                                            'bg-green-500/10 text-green-700 border-green-500/20': getStatusType(payment.status) === 'success',
                                            'bg-yellow-500/10 text-yellow-700 border-yellow-500/20': getStatusType(payment.status) === 'warning',
                                            'bg-red-500/10 text-red-700 border-red-500/20': getStatusType(payment.status) === 'danger',
                                            'bg-surface text-on-surface-variant border-outline-variant': getStatusType(payment.status) === 'info'
                                        }"
                                    >
                                        <span class="w-1 h-1 rounded-full" 
                                            :class="{
                                                'bg-green-500': getStatusType(payment.status) === 'success',
                                                'bg-yellow-500': getStatusType(payment.status) === 'warning',
                                                'bg-red-500': getStatusType(payment.status) === 'danger',
                                                'bg-on-surface-variant/40': getStatusType(payment.status) === 'info'
                                            }">
                                        </span>
                                        {{ getStatusLabel(payment.status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-xs text-on-surface-variant">
                                    {{ new Date(payment.created_at).toLocaleString('id-ID', { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' }) }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <Link :href="route('admin.order.index', { search: payment.order_id })"
                                        class="p-1.5 text-on-surface-variant hover:text-primary hover:bg-surface border border-outline-variant rounded transition-colors inline-flex"
                                        title="Lihat Pesanan">
                                        <el-icon :size="14"><Ticket /></el-icon>
                                    </Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-4 border-t border-outline-variant">
                    <Pagination :data="payments" />
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
