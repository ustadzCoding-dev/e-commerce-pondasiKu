<script setup>
import InputError from '@/Components/InputError.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <section>
        <header>
            <h3 class="font-bold text-sm text-on-surface uppercase tracking-wider">Perbarui Kata Sandi</h3>
            <p class="text-[10px] text-on-surface-variant font-medium mt-1 leading-normal">
                Pastikan akun Anda tetap aman dengan menggunakan kata sandi yang kuat dan memiliki panjang minimal 8 karakter.
            </p>
        </header>

        <form @submit.prevent="updatePassword" class="mt-6 space-y-4">
            <div>
                <label class="block text-[9px] font-black text-on-surface-variant uppercase tracking-widest mb-1.5">Kata Sandi Saat Ini</label>
                <input
                    id="current_password"
                    ref="currentPasswordInput"
                    v-model="form.current_password"
                    type="password"
                    class="pk-input w-full"
                    autocomplete="current-password"
                    placeholder="••••••••"
                />
                <InputError :message="form.errors.current_password" class="mt-1 text-[11px]" />
            </div>

            <div>
                <label class="block text-[9px] font-black text-on-surface-variant uppercase tracking-widest mb-1.5">Kata Sandi Baru</label>
                <input
                    id="password"
                    ref="passwordInput"
                    v-model="form.password"
                    type="password"
                    class="pk-input w-full"
                    autocomplete="new-password"
                    placeholder="••••••••"
                />
                <InputError :message="form.errors.password" class="mt-1 text-[11px]" />
            </div>

            <div>
                <label class="block text-[9px] font-black text-on-surface-variant uppercase tracking-widest mb-1.5">Konfirmasi Kata Sandi Baru</label>
                <input
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="pk-input w-full"
                    autocomplete="new-password"
                    placeholder="••••••••"
                />
                <InputError :message="form.errors.password_confirmation" class="mt-1 text-[11px]" />
            </div>

            <div class="flex items-center gap-4 pt-2">
                <button :disabled="form.processing" class="pk-btn-accent px-6 py-3 text-xs font-bold uppercase tracking-wider">Perbarui Sandi</button>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-xs text-on-surface-variant font-bold uppercase tracking-wider">Berhasil Diperbarui.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
