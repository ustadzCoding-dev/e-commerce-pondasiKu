<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    user: {
        type: Object,
        default: () => ({}),
    },
});

const profileForm = useForm({
    name: props.user?.name || '',
    email: props.user?.email || '',
});

const passwordForm = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updateProfile = () => {
    profileForm.patch(route('admin.profile.update'), {
        preserveScroll: true,
        onSuccess: () => {
            profileForm.reset();
        },
    });
};

const updatePassword = () => {
    passwordForm.put(route('admin.profile.password'), {
        preserveScroll: true,
        onSuccess: () => {
            passwordForm.reset();
        },
    });
};
</script>

<template>
    <AdminLayout>
        <Head title="Profil Admin" />
        
        <div class="py-6">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
                <!-- Page Header -->
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-primary-100  rounded-2xl text-primary-600 ">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900  uppercase tracking-tight">Profil Admin</h1>
                        <p class="text-sm text-gray-500  font-medium">Kelola informasi akun dan keamanan Anda.</p>
                    </div>
                </div>

                <!-- Profile Information -->
                <div class="bg-white  rounded-2xl shadow-sm border border-gray-100  overflow-hidden">
                    <div class="p-6 border-b border-gray-100  bg-gray-50/50 ">
                        <h2 class="text-lg font-bold text-gray-900  flex items-center gap-3">
                            <span class="p-2 bg-primary-100  rounded-lg text-primary-600 ">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </span>
                            Informasi Akun
                        </h2>
                    </div>
                    <form @submit.prevent="updateProfile" class="p-6 space-y-5">
                        <div>
                            <label class="block text-sm font-bold text-gray-700  uppercase tracking-wide mb-2">Nama Lengkap</label>
                            <input 
                                type="text" 
                                v-model="profileForm.name" 
                                class="w-full bg-gray-50  border-gray-200  rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all "
                                placeholder="Nama lengkap"
                            />
                            <p v-if="profileForm.errors.name" class="mt-2 text-sm text-red-600 ">{{ profileForm.errors.name }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700  uppercase tracking-wide mb-2">Alamat Email</label>
                            <input 
                                type="email" 
                                v-model="profileForm.email" 
                                class="w-full bg-gray-50  border-gray-200  rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all "
                                placeholder="email@example.com"
                            />
                            <p v-if="profileForm.errors.email" class="mt-2 text-sm text-red-600 ">{{ profileForm.errors.email }}</p>
                        </div>

                        <div v-if="props.status === 'profile-updated'" class="p-4 bg-green-50  border border-green-200  rounded-xl">
                            <p class="text-sm text-green-700  font-medium">Profil berhasil diperbarui!</p>
                        </div>

                        <div class="flex justify-end pt-4">
                            <button 
                                type="submit" 
                                :disabled="profileForm.processing"
                                class="px-6 py-3 bg-primary-500 hover:bg-primary-600 text-white font-bold rounded-xl transition-all duration-300 shadow-lg shadow-primary-500/25 disabled:opacity-50"
                            >
                                <span v-if="profileForm.processing">Menyimpan...</span>
                                <span v-else>Simpan Perubahan</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Update Password -->
                <div class="bg-white  rounded-2xl shadow-sm border border-gray-100  overflow-hidden">
                    <div class="p-6 border-b border-gray-100  bg-gray-50/50 ">
                        <h2 class="text-lg font-bold text-gray-900  flex items-center gap-3">
                            <span class="p-2 bg-primary-100  rounded-lg text-primary-600 ">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </span>
                            Keamanan
                        </h2>
                    </div>
                    <form @submit.prevent="updatePassword" class="p-6 space-y-5">
                        <div>
                            <label class="block text-sm font-bold text-gray-700  uppercase tracking-wide mb-2">Password Saat Ini</label>
                            <input 
                                type="password" 
                                v-model="passwordForm.current_password" 
                                class="w-full bg-gray-50  border-gray-200  rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all "
                                placeholder="Masukkan password saat ini"
                            />
                            <p v-if="passwordForm.errors.current_password" class="mt-2 text-sm text-red-600 ">{{ passwordForm.errors.current_password }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700  uppercase tracking-wide mb-2">Password Baru</label>
                            <input 
                                type="password" 
                                v-model="passwordForm.password" 
                                class="w-full bg-gray-50  border-gray-200  rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all "
                                placeholder="Masukkan password baru"
                            />
                            <p v-if="passwordForm.errors.password" class="mt-2 text-sm text-red-600 ">{{ passwordForm.errors.password }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700  uppercase tracking-wide mb-2">Konfirmasi Password Baru</label>
                            <input 
                                type="password" 
                                v-model="passwordForm.password_confirmation" 
                                class="w-full bg-gray-50  border-gray-200  rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all "
                                placeholder="Konfirmasi password baru"
                            />
                        </div>

                        <div v-if="props.status === 'password-updated'" class="p-4 bg-green-50  border border-green-200  rounded-xl">
                            <p class="text-sm text-green-700  font-medium">Password berhasil diperbarui!</p>
                        </div>

                        <div class="flex justify-end pt-4">
                            <button 
                                type="submit" 
                                :disabled="passwordForm.processing"
                                class="px-6 py-3 bg-primary-500 hover:bg-primary-600 text-white font-bold rounded-xl transition-all duration-300 shadow-lg shadow-primary-500/25 disabled:opacity-50"
                            >
                                <span v-if="passwordForm.processing">Menyimpan...</span>
                                <span v-else>Update Password</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
