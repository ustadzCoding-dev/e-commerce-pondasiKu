<script setup>
import InputError from '@/Components/InputError.vue';
import Modal from '@/Components/Modal.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;
    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;
    form.reset();
};
</script>

<template>
    <section class="space-y-4">
        <header>
            <h3 class="font-bold text-sm text-red-600 uppercase tracking-wider">Hapus Akun Pengguna</h3>
            <p class="text-[10px] text-red-500/80 font-medium mt-1 leading-normal">
                Tindakan ini bersifat permanen. Seluruh data log kalkulasi material, pesanan kargo, dan riwayat transaksi SNAP Midtrans Anda akan terhapus selamanya.
            </p>
        </header>

        <button @click="confirmUserDeletion" class="pk-btn-danger px-6 py-3 text-xs font-bold uppercase tracking-wider">Hapus Akun Proyek</button>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6 md:p-8 bg-white border border-outline-variant rounded overflow-hidden shadow-none">
                <h3 class="font-bold text-base text-on-surface uppercase tracking-wider mb-3 flex items-center gap-2">
                    <span class="material-symbols-outlined text-red-600 text-xl">warning</span>
                    Apakah Anda Yakin Ingin Menghapus Akun?
                </h3>

                <p class="text-xs text-on-surface-variant font-medium leading-relaxed mb-5">
                    Tindakan ini tidak dapat dibatalkan. Silakan masukkan kata sandi akun Anda untuk memverifikasi penghapusan akun permanen.
                </p>

                <div class="space-y-4">
                    <label class="block text-[9px] font-black text-on-surface-variant uppercase tracking-widest mb-1.5">Kata Sandi Akun</label>
                    <input
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="pk-input w-full"
                        placeholder="••••••••"
                        @keyup.enter="deleteUser"
                    />
                    <InputError :message="form.errors.password" class="mt-1 text-[11px]" />
                </div>

                <div class="mt-6 flex justify-end gap-3 pt-4 border-t border-outline-variant">
                    <button type="button" @click="closeModal" class="pk-btn-secondary px-5 py-2.5 text-xs font-bold uppercase tracking-wider">Batal</button>
                    <button
                        type="button"
                        class="pk-btn-danger px-5 py-2.5 text-xs font-bold uppercase tracking-wider"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        Hapus Permanen
                    </button>
                </div>
            </div>
        </Modal>
    </section>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0');
</style>
