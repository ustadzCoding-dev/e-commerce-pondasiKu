<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Pembaruan Sandi Akun" />

        <div class="text-center mb-6">
            <span class="inline-block px-2.5 py-0.5 bg-primary/10 text-primary border border-primary/20 font-bold text-xs rounded-full uppercase tracking-wider mb-2 leading-none">
                Pembaruan Akses
            </span>
            <h2 class="font-display font-extrabold text-2xl text-on-surface uppercase tracking-wider">
                Reset Kata Sandi
            </h2>
            <p class="text-xs text-on-surface-variant font-medium mt-1">
                Silakan buat kata sandi baru untuk mengamankan akses proyek Anda.
            </p>
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
                <label class="block text-xs font-black text-on-surface-variant uppercase tracking-widest mb-1.5">Kata Sandi Baru</label>
                <input
                    id="password"
                    type="password"
                    class="pk-input w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                    placeholder="••••••••"
                />
                <InputError class="mt-1 text-[11px]" :message="form.errors.password" />
            </div>

            <div>
                <label class="block text-xs font-black text-on-surface-variant uppercase tracking-widest mb-1.5">Konfirmasi Ulang Kata Sandi</label>
                <input
                    id="password_confirmation"
                    type="password"
                    class="pk-input w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="••••••••"
                />
                <InputError class="mt-1 text-[11px]" :message="form.errors.password_confirmation" />
            </div>

            <div class="flex flex-col space-y-4 pt-2">
                <button 
                    type="submit"
                    class="w-full pk-btn-accent py-3 text-xs font-black uppercase tracking-widest justify-center gap-2" 
                    :class="{ 'opacity-25': form.processing }" 
                    :disabled="form.processing"
                >
                    Reset Kata Sandi
                </button>
            </div>
        </form>
    </GuestLayout>
</template>
