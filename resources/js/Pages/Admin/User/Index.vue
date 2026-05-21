<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { ref, watch } from "vue";
import { Search, Edit, Delete, User as UserIcon, Lock, Check, Close } from "@element-plus/icons-vue";
import { ElNotification, ElMessageBox } from "element-plus";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({
    users: Object,
    filters: Object,
});

const search = ref(props.filters.search || "");

watch(search, (value) => {
    router.get(
        route("admin.user.index"),
        { search: value },
        { preserveState: true, replace: true }
    );
});

const updateRole = (user) => {
    ElMessageBox.confirm(
        `Yakin ingin mengubah role ${user.name} menjadi ${user.isAdmin ? 'User Biasa' : 'Admin'}?`,
        'Update Role',
        {
            confirmButtonText: 'Ya, Ubah',
            cancelButtonText: 'Batal',
            type: 'warning',
        }
    ).then(() => {
        router.patch(route('admin.user.role', user.id), {}, {
            onSuccess: () => {
                ElNotification({
                    title: 'Berhasil',
                    message: 'Role user berhasil diperbarui',
                    type: 'success',
                });
            }
        });
    });
};

const deleteUser = (user) => {
    ElMessageBox.confirm(
        `Tindakan ini tidak dapat dibatalkan. Yakin ingin menghapus user ${user.name}?`,
        'Hapus User',
        {
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            type: 'error',
        }
    ).then(() => {
        router.delete(route('admin.user.destroy', user.id), {
            onSuccess: () => {
                ElNotification({
                    title: 'Berhasil',
                    message: 'User berhasil dihapus',
                    type: 'success',
                });
            }
        });
    });
};
</script>

<template>
    <AdminLayout>
        <Head title="Manajemen User" />
        <div class="p-4 lg:p-6 bg-surface">
            <!-- Header -->
            <div class="mb-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-xl lg:text-2xl font-bold text-on-surface">Manajemen User</h1>
                        <p class="text-xs text-on-surface-variant mt-1">Kelola data pelanggan dan hak akses admin</p>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-white border border-outline-variant rounded p-4">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-surface border border-outline-variant rounded text-on-surface-variant">
                            <el-icon class="text-on-surface" :size="20"><UserIcon /></el-icon>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Total User</p>
                            <p class="text-base font-bold text-on-surface">{{ users.total }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white border border-outline-variant rounded p-4">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-surface border border-outline-variant rounded text-on-surface-variant">
                            <el-icon class="text-on-surface" :size="20"><Lock /></el-icon>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Admin</p>
                            <p class="text-base font-bold text-on-surface">{{ users.data.filter(u => u.isAdmin).length }}</p>
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
                            placeholder="Cari nama atau email...">
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-surface border-b border-outline-variant">
                            <tr>
                                <th class="px-4 py-3 text-left text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">User</th>
                                <th class="px-4 py-3 text-left text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Email</th>
                                <th class="px-4 py-3 text-left text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Status Admin</th>
                                <th class="px-4 py-3 text-left text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Terdaftar</th>
                                <th class="px-4 py-3 text-right text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant">
                            <tr v-for="user in users.data" :key="user.id" class="hover:bg-surface transition-colors">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded bg-primary/10 border border-primary/20 flex items-center justify-center text-primary font-bold text-xs uppercase">
                                            {{ user.name.charAt(0).toUpperCase() }}
                                        </div>
                                        <span class="text-xs font-bold text-on-surface">{{ user.name }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-xs text-on-surface-variant">{{ user.email }}</td>
                                <td class="px-4 py-3">
                                    <span v-if="user.isAdmin"
                                        class="inline-flex items-center gap-1.5 px-2 py-0.5 bg-primary/10 text-primary border border-primary/20 text-[9px] font-bold rounded">
                                        <el-icon :size="10"><Lock /></el-icon>
                                        Admin
                                    </span>
                                    <span v-else
                                        class="inline-flex items-center gap-1.5 px-2 py-0.5 bg-surface text-on-surface-variant border border-outline-variant text-[9px] font-bold rounded">
                                        User
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-xs text-on-surface-variant">
                                    {{ new Date(user.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-2">
                                        <button @click="updateRole(user)"
                                            class="p-1.5 text-on-surface-variant hover:text-primary hover:bg-surface border border-outline-variant rounded transition-colors"
                                            title="Ubah Role">
                                            <el-icon :size="14"><Lock /></el-icon>
                                        </button>
                                        <button @click="deleteUser(user)"
                                            class="p-1.5 text-on-surface-variant hover:text-red-650 hover:bg-red-50 border border-outline-variant rounded transition-colors"
                                            title="Hapus User">
                                            <el-icon :size="14"><Delete /></el-icon>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-4 border-t border-outline-variant">
                    <Pagination :data="users" />
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
