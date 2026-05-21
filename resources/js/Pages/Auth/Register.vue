<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Pendaftaran Akun Baru" />

        <div class="text-center mb-6">
            <span class="inline-block px-2.5 py-0.5 bg-primary/10 text-primary border border-primary/20 font-bold text-xs rounded-full uppercase tracking-wider mb-2 leading-none">
                Pendaftaran Pelanggan
            </span>
            <h2 class="font-display font-extrabold text-2xl text-on-surface uppercase tracking-wider">
                Registrasi Akun Baru
            </h2>
            <p class="text-xs text-on-surface-variant font-medium mt-1">
                Lengkapi formulir di bawah ini untuk mulai berbelanja material Anda.
            </p>
        </div>

        <form @submit.prevent="submit" class="space-y-4">
            <div>
                <label class="block text-xs font-black text-on-surface-variant uppercase tracking-widest mb-1.5">Nama Lengkap</label>
                <input
                    id="name"
                    type="text"
                    class="pk-input w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Nama lengkap Anda"
                />
                <InputError class="mt-1 text-[11px]" :message="form.errors.name" />
            </div>

            <div>
                <label class="block text-xs font-black text-on-surface-variant uppercase tracking-widest mb-1.5">Alamat Email</label>
                <input
                    id="email"
                    type="email"
                    class="pk-input w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                    placeholder="email@contoh.com"
                />
                <InputError class="mt-1 text-[11px]" :message="form.errors.email" />
            </div>

            <div>
                <label class="block text-xs font-black text-on-surface-variant uppercase tracking-widest mb-1.5">Kata Sandi Akun Baru</label>
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
                    Daftar Sekarang
                </button>

                <p class="text-center text-[11px] font-bold text-on-surface-variant">
                    Sudah memiliki akun terdaftar?
                    <Link
                        :href="route('login')"
                        class="font-black text-primary hover:text-primary-600 uppercase tracking-wider ml-1"
                    >
                        Masuk Di Sini
                    </Link>
                </p>
            </div>
        </form>
    </GuestLayout>
</template>
