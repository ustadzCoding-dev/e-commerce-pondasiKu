<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    password: '',
});

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Konfirmasi Sandi Keamanan" />

        <div class="text-center mb-6">
            <span class="inline-block px-2.5 py-0.5 bg-primary/10 text-primary border border-primary/20 font-bold text-xs rounded-full uppercase tracking-wider mb-2 leading-none">
                Konfirmasi Keamanan
            </span>
            <h2 class="font-display font-extrabold text-2xl text-on-surface uppercase tracking-wider">
                Konfirmasi Kata Sandi
            </h2>
            <p class="text-xs text-on-surface-variant font-medium mt-2 leading-relaxed">
                Ini adalah area aman aplikasi. Silakan konfirmasi kata sandi Anda terlebih dahulu sebelum melanjutkan akses.
            </p>
        </div>

        <form @submit.prevent="submit" class="space-y-4">
            <div>
                <label class="block text-xs font-black text-on-surface-variant uppercase tracking-widest mb-1.5">Kata Sandi Akun Anda</label>
                <input
                    id="password"
                    type="password"
                    class="pk-input w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    autofocus
                    placeholder="••••••••"
                />
                <InputError class="mt-1 text-[11px]" :message="form.errors.password" />
            </div>

            <div class="pt-2">
                <button 
                    type="submit" 
                    class="w-full pk-btn-accent py-3 text-xs font-black uppercase tracking-widest justify-center gap-2"
                    :class="{ 'opacity-25': form.processing }" 
                    :disabled="form.processing"
                >
                    Konfirmasi Akses
                </button>
            </div>
        </form>
    </GuestLayout>
</template>
