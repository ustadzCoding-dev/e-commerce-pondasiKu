<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
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
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Masuk Akun Logistik" />

        <div class="text-center mb-6">
            <span class="inline-block px-2.5 py-0.5 bg-primary/10 text-primary border border-primary/20 font-bold text-xs rounded-full uppercase tracking-wider mb-2 leading-none">
                Akses Portal Proyek
            </span>
            <h2 class="font-display font-extrabold text-2xl text-on-surface uppercase tracking-wider">
                Selamat Datang Kembali
            </h2>
            <p class="text-xs text-on-surface-variant font-medium mt-1">
                Silakan masuk untuk melanjutkan pemesanan & kalkulasi material.
            </p>
        </div>

        <div v-if="status" class="mb-4 font-bold text-xs text-green-600  p-3 bg-green-500/10 rounded border border-green-500/20">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="space-y-4">
            <div>
                <label class="block text-xs font-black text-on-surface-variant uppercase tracking-widest mb-1.5">Alamat Email Terdaftar</label>
                <input
                    id="email"
                    type="email"
                    class="pk-input w-full"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="email@proyek.com"
                />
                <InputError class="mt-1 text-[11px]" :message="form.errors.email" />
            </div>

            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label class="block text-xs font-black text-on-surface-variant uppercase tracking-widest">Kata Sandi Akun</label>
                    <Link
                        v-if="canResetPassword"
                        :href="route('password.request')"
                        class="text-[10px] font-black text-primary hover:text-primary-600 uppercase tracking-wider"
                    >
                        Lupa Sandi?
                    </Link>
                </div>
                <input
                    id="password"
                    type="password"
                    class="pk-input w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    placeholder="••••••••"
                />
                <InputError class="mt-1 text-[11px]" :message="form.errors.password" />
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" class="rounded border-outline-variant text-primary focus:ring-primary" />
                    <span class="ms-2 text-xs font-bold text-on-surface-variant">Ingat Akun Saya</span>
                </label>
            </div>

            <div class="flex flex-col space-y-4 pt-2">
                <button 
                    type="submit"
                    class="w-full pk-btn-accent py-3 text-xs font-black uppercase tracking-widest justify-center gap-2" 
                    :class="{ 'opacity-25': form.processing }" 
                    :disabled="form.processing"
                >
                    Masuk Sekarang
                </button>

                <p class="text-center text-[11px] font-bold text-on-surface-variant">
                    Belum memiliki akun proyek?
                    <Link
                        :href="route('register')"
                        class="font-black text-primary hover:text-primary-600 uppercase tracking-wider ml-1"
                    >
                        Daftar Akun Baru
                    </Link>
                </p>
            </div>
        </form>
    </GuestLayout>
</template>
