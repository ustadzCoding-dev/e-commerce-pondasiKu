<script setup>
import InputError from '@/Components/InputError.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
});
</script>

<template>
    <section>
        <header>
            <div class="flex justify-between items-center gap-4">
                <div>
                    <h3 class="font-bold text-sm text-on-surface uppercase tracking-wider">Detail Informasi Profil</h3>
                    <p class="text-[10px] text-on-surface-variant font-medium mt-1 leading-normal">
                        Perbarui informasi nama lengkap penanggung jawab dan alamat email resmi proyek Anda.
                    </p>
                </div>
                <Link :href="route('dashboard')" class="pk-btn-secondary py-2 px-4 text-[10px] font-bold uppercase tracking-wider flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-xs">arrow_back</span>
                    Kembali
                </Link>
            </div>
        </header>

        <form @submit.prevent="form.patch(route('profile.update'))" class="mt-6 space-y-4">
            <div>
                <label class="block text-[9px] font-black text-on-surface-variant uppercase tracking-widest mb-1.5">Nama Lengkap Penanggung Jawab</label>
                <input
                    id="name"
                    type="text"
                    class="pk-input w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />
                <InputError class="mt-1 text-[11px]" :message="form.errors.name" />
            </div>

            <div>
                <label class="block text-[9px] font-black text-on-surface-variant uppercase tracking-widest mb-1.5">Alamat Email Resmi</label>
                <input
                    id="email"
                    type="email"
                    class="pk-input w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />
                <InputError class="mt-1 text-[11px]" :message="form.errors.email" />
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="text-xs mt-2 text-on-surface font-medium">
                    Alamat email Anda belum diverifikasi.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="underline text-primary hover:text-primary-600 font-black ml-1 uppercase text-[10px] tracking-wider"
                    >
                        Kirim Ulang Verifikasi.
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 font-bold text-xs text-green-600"
                >
                    Link verifikasi baru telah dikirim ke alamat email Anda.
                </div>
            </div>

            <div class="flex items-center gap-4 pt-2">
                <button :disabled="form.processing" class="pk-btn-accent px-6 py-3 text-xs font-bold uppercase tracking-wider">Simpan Perubahan</button>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-xs text-on-surface-variant font-bold uppercase tracking-wider">Perubahan Disimpan.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0');
</style>
