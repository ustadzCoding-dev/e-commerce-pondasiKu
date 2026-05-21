<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { ref, watch } from "vue";
import { Search, Location, User as UserIcon, Phone, MapLocation } from "@element-plus/icons-vue";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({
    addresses: Object,
    filters: Object,
});

const search = ref(props.filters.search || "");

watch(search, (value) => {
    router.get(
        route("admin.user.addresses"),
        { search: value },
        { preserveState: true, replace: true }
    );
});
</script>

<template>
    <AdminLayout>
        <Head title="Alamat Pelanggan" />
        <div class="p-4 lg:p-6 bg-surface">
            <!-- Header -->
            <div class="mb-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-xl lg:text-2xl font-bold text-on-surface">Alamat Pelanggan</h1>
                        <p class="text-xs text-on-surface-variant mt-1">Daftar alamat pengiriman lengkap seluruh pelanggan</p>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-white border border-outline-variant rounded p-4">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-surface border border-outline-variant rounded text-on-surface-variant">
                            <el-icon class="text-on-surface" :size="20"><Location /></el-icon>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Total Alamat</p>
                            <p class="text-base font-bold text-on-surface">{{ addresses.total }}</p>
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
                            placeholder="Cari nama pelanggan atau alamat...">
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-surface border-b border-outline-variant">
                            <tr>
                                <th class="px-4 py-3 text-left text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Pelanggan</th>
                                <th class="px-4 py-3 text-left text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Alamat Lengkap</th>
                                <th class="px-4 py-3 text-left text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Kota/Provinsi</th>
                                <th class="px-4 py-3 text-left text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Tipe</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant">
                            <tr v-for="addr in addresses.data" :key="addr.id" class="hover:bg-surface transition-colors">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded bg-primary/10 border border-primary/20 flex items-center justify-center text-primary font-bold text-xs uppercase">
                                            {{ addr.user?.name.charAt(0).toUpperCase() }}
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-xs font-bold text-on-surface">{{ addr.user?.name }}</span>
                                            <span class="text-[9px] text-on-surface-variant">{{ addr.user?.email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-col max-w-xs">
                                        <span class="text-xs text-on-surface line-clamp-2">{{ addr.address }}</span>
                                        <span class="text-[10px] text-on-surface-variant mt-1 flex items-center gap-1">
                                            <el-icon><Phone /></el-icon> {{ addr.phone || '-' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-col">
                                        <span class="text-xs text-on-surface font-semibold">{{ addr.city }}</span>
                                        <span class="text-[10px] text-on-surface-variant">{{ addr.state || addr.province }} {{ addr.zipcode }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span v-if="addr.isDefault"
                                        class="inline-flex items-center gap-1.5 px-2 py-0.5 bg-green-500/10 text-green-700 border border-green-500/20 text-[9px] font-bold rounded">
                                        Utama
                                    </span>
                                    <span v-else
                                        class="inline-flex items-center gap-1.5 px-2 py-0.5 bg-surface text-on-surface-variant border border-outline-variant text-[9px] font-bold rounded">
                                        Tambahan
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-4 border-t border-outline-variant">
                    <Pagination :data="addresses" />
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
