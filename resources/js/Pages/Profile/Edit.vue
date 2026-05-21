<script setup>
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';
import App from "@/Layouts/App.vue";

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <App>
        <Head title="Pengaturan Profil Akun" />
        
        <div class="bg-surface  min-h-screen pt-20 pb-20">
            <!-- Header Minimalis -->
            <div class="max-w-[1440px] mx-auto px-margin-desktop mb-8">
                <h1 class="text-2xl font-bold text-on-surface mb-2">Pengaturan Profil</h1>
                <p class="text-sm text-on-surface-variant max-w-2xl">Kelola informasi kontak penanggung jawab proyek, perbarui sandi keamanan akun, atau hapus keanggotaan Anda.</p>
            </div>

            <div class="max-w-3xl mx-auto px-margin-desktop mt-8 relative z-10 space-y-6">
                <!-- 1. Informasi Profil -->
                <div class="bg-white p-6 md:p-8 rounded border border-outline-variant shadow-none">
                    <div class="flex items-center gap-3.5 mb-6 border-b border-outline-variant pb-4 bg-white">
                        <div class="w-10 h-10 bg-surface border border-outline-variant rounded flex items-center justify-center text-on-surface">
                            <span class="material-symbols-outlined text-lg">person</span>
                        </div>
                        <div>
                            <h2 class="font-bold text-sm text-on-surface uppercase tracking-wider">Informasi Akun</h2>
                            <p class="text-[10px] text-on-surface-variant font-medium">Perbarui nama lengkap dan email resmi proyek Anda.</p>
                        </div>
                    </div>
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class="w-full"
                    />
                </div>

                <!-- 2. Update Password -->
                <div class="bg-white p-6 md:p-8 rounded border border-outline-variant shadow-none">
                    <div class="flex items-center gap-3.5 mb-6 border-b border-outline-variant pb-4 bg-white">
                        <div class="w-10 h-10 bg-surface border border-outline-variant rounded flex items-center justify-center text-on-surface">
                            <span class="material-symbols-outlined text-lg">lock</span>
                        </div>
                        <div>
                            <h2 class="font-bold text-sm text-on-surface uppercase tracking-wider">Keamanan Akun</h2>
                            <p class="text-[10px] text-on-surface-variant font-medium">Pastikan akun menggunakan kombinasi kata sandi yang aman.</p>
                        </div>
                    </div>
                    <UpdatePasswordForm class="w-full" />
                </div>

                <!-- 3. Delete Account -->
                <div class="bg-red-500/5 p-6 md:p-8 rounded border border-red-200">
                    <div class="flex items-center gap-3.5 mb-6 border-b border-red-100 pb-4">
                        <div class="w-10 h-10 bg-red-100 border border-red-200/20 rounded flex items-center justify-center text-red-600">
                            <span class="material-symbols-outlined text-lg">delete_forever</span>
                        </div>
                        <div>
                            <h2 class="font-bold text-sm text-red-600 uppercase tracking-wider">Hapus Akun Proyek</h2>
                            <p class="text-[10px] text-red-500/60 font-medium">Seluruh log estimasi dan pesanan Anda akan dihapus permanen.</p>
                        </div>
                    </div>
                    <DeleteUserForm class="w-full" />
                </div>
            </div>
        </div>
    </App>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0');
</style>
