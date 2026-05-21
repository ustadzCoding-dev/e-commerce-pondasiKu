<script setup>
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <GuestLayout>
        <Head title="Verifikasi Email Akun" />

        <div class="text-center mb-6">
            <span class="inline-block px-2.5 py-0.5 bg-primary/10 text-primary border border-primary/20 font-bold text-xs rounded-full uppercase tracking-wider mb-2 leading-none">
                Verifikasi Akun
            </span>
            <h2 class="font-display font-extrabold text-2xl text-on-surface uppercase tracking-wider">
                Verifikasi Email Anda
            </h2>
            <p class="text-xs text-on-surface-variant font-medium mt-2 leading-relaxed">
                Terima kasih telah mendaftar! Sebelum memulai kalkulasi material, silakan verifikasi alamat email Anda melalui tautan yang baru saja kami kirimkan.
            </p>
        </div>

        <div class="mb-4 font-bold text-xs text-green-600  p-3 bg-green-500/10 rounded border border-green-500/20" v-if="verificationLinkSent">
            Tautan verifikasi baru telah dikirimkan ke email terdaftar Anda.
        </div>

        <form @submit.prevent="submit" class="space-y-4">
            <div class="flex flex-col gap-3">
                <button 
                    type="submit" 
                    class="w-full pk-btn-accent py-3 text-xs font-black uppercase tracking-widest justify-center gap-2"
                    :class="{ 'opacity-25': form.processing }" 
                    :disabled="form.processing"
                >
                    Kirim Ulang Email Verifikasi
                </button>

                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="w-full py-2.5 border border-outline-variant text-on-surface-variant font-bold text-xs uppercase tracking-wider rounded-lg hover:border-primary hover:text-primary transition-all"
                >
                    Keluar Akun
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>
