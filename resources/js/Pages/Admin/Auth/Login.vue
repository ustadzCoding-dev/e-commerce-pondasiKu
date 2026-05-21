<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('admin.login.post'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <div class="min-h-screen flex flex-col md:flex-row bg-surface">
        <!-- Left Side - Branding -->
        <div class="hidden md:flex md:w-1/2 bg-secondary items-center justify-center p-12">
            <div class="text-center text-white">
                <div class="mb-8">
                    <span class="text-5xl font-black">
                        Pondasi<span class="text-primary">Ku</span>.
                    </span>
                </div>
                <h1 class="text-2xl font-bold uppercase tracking-wider mb-4">Panel Admin</h1>
                <p class="text-white/80 text-xs uppercase tracking-widest max-w-md mx-auto leading-relaxed">
                    Sistem Manajemen & Logistik Distribusi PondasiKu
                </p>
                <div class="mt-12 flex justify-center gap-8">
                    <div class="text-center">
                        <div class="w-12 h-12 bg-white/10 border border-white/20 rounded flex items-center justify-center mx-auto mb-2">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <span class="text-[10px] font-bold uppercase tracking-wider">Produk</span>
                    </div>
                    <div class="text-center">
                        <div class="w-12 h-12 bg-white/10 border border-white/20 rounded flex items-center justify-center mx-auto mb-2">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <span class="text-[10px] font-bold uppercase tracking-wider">Pesanan</span>
                    </div>
                    <div class="text-center">
                        <div class="w-12 h-12 bg-white/10 border border-white/20 rounded flex items-center justify-center mx-auto mb-2">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <span class="text-[10px] font-bold uppercase tracking-wider">Statistik</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="flex-1 flex items-center justify-center p-8 bg-surface">
            <div class="w-full max-w-md">
                <!-- Mobile Logo -->
                <div class="md:hidden text-center mb-8">
                    <span class="text-3xl font-black text-on-surface">
                        Pondasi<span class="text-primary">Ku</span>.
                    </span>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant mt-2">Panel Admin</p>
                </div>

                <Head title="Masuk Admin" />

                <div class="bg-white border border-outline-variant rounded p-8">
                    <div class="text-center mb-8">
                        <h2 class="text-lg font-bold text-on-surface uppercase tracking-wider">Selamat Datang</h2>
                        <p class="text-xs text-on-surface-variant mt-1">Masuk ke akun admin Anda</p>
                    </div>

                    <div v-if="status" class="mb-6 p-4 bg-green-500/10 text-green-700 border border-green-500/20 rounded text-xs font-bold">
                        {{ status }}
                    </div>

                    <form @submit.prevent="submit" class="space-y-5">
                        <div>
                            <label for="email" class="block text-[10px] font-bold text-on-surface-variant uppercase tracking-wider mb-2">
                                Email
                            </label>
                            <input
                                id="email"
                                type="email"
                                v-model="form.email"
                                required
                                autofocus
                                autocomplete="username"
                                class="w-full px-4 py-2.5 rounded border border-outline-variant bg-white text-xs text-on-surface placeholder-on-surface-variant/40 focus:ring-1 focus:ring-primary focus:border-transparent transition-all"
                                placeholder="admin@example.com"
                            />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <div>
                            <label for="password" class="block text-[10px] font-bold text-on-surface-variant uppercase tracking-wider mb-2">
                                Password
                            </label>
                            <input
                                id="password"
                                type="password"
                                v-model="form.password"
                                required
                                autocomplete="current-password"
                                class="w-full px-4 py-2.5 rounded border border-outline-variant bg-white text-xs text-on-surface placeholder-on-surface-variant/40 focus:ring-1 focus:ring-primary focus:border-transparent transition-all"
                                placeholder="••••••••"
                            />
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="flex items-center">
                                <Checkbox name="remember" v-model:checked="form.remember" />
                                <span class="ms-2 text-xs text-on-surface-variant">Ingat saya</span>
                            </label>

                            <Link
                                v-if="canResetPassword"
                                :href="route('password.request')"
                                class="text-xs text-primary hover:text-opacity-95 font-bold uppercase tracking-wider"
                            >
                                Lupa password?
                            </Link>
                        </div>

                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="w-full py-2.5 px-4 bg-primary text-white font-bold text-xs uppercase tracking-wider rounded hover:bg-opacity-95 shadow transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                        >
                            <svg v-if="form.processing" class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Masuk</span>
                        </button>
                    </form>

                    <div class="mt-6 text-center">
                        <Link :href="route('home')" class="text-xs text-on-surface-variant hover:text-primary transition-colors">
                            ← Kembali ke Toko
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
