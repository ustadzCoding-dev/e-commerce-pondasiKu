<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <GuestLayout>
        <Head title="Pemulihan Akses Akun" />

        <div class="text-center mb-6">
            <span class="inline-block px-2.5 py-0.5 bg-primary/10 text-primary border border-primary/20 font-bold text-xs rounded-full uppercase tracking-wider mb-2 leading-none">
                Pemulihan Sandi
            </span>
            <h2 class="font-display font-extrabold text-2xl text-on-surface uppercase tracking-wider">
                Lupa Kata Sandi?
            </h2>
            <p class="text-xs text-on-surface-variant font-medium mt-1">
                Masukkan alamat email Anda dan kami akan mengirimkan tautan pemulihan sandi.
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

            <div class="flex flex-col space-y-4 pt-2">
                <button 
                    type="submit"
                    class="w-full pk-btn-accent py-3 text-xs font-black uppercase tracking-widest justify-center gap-2" 
                    :class="{ 'opacity-25': form.processing }" 
                    :disabled="form.processing"
                >
                    Kirim Link Pemulihan
                </button>

                <p class="text-center text-[11px] font-bold text-on-surface-variant">
                    Ingat kata sandi Anda?
                    <Link
                        :href="route('login')"
                        class="font-black text-primary hover:text-primary-600 uppercase tracking-wider ml-1"
                    >
                        Kembali Ke Login
                    </Link>
                </p>
            </div>
        </form>
    </GuestLayout>
</template>
