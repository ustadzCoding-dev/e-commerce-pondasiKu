<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { ElNotification } from "element-plus";
import { Setting, Picture, Message, Phone, Location, Share, InfoFilled } from "@element-plus/icons-vue";

const props = defineProps({
    settings: Object,
});

const form = useForm({
    store_name: props.settings.store_name || "PondasiKu",
    store_description: props.settings.store_description || "",
    contact_email: props.settings.contact_email || "",
    contact_phone: props.settings.contact_phone || "",
    contact_whatsapp: props.settings.contact_whatsapp || "",
    address: props.settings.address || "",
    facebook_url: props.settings.facebook_url || "",
    instagram_url: props.settings.instagram_url || "",
    twitter_url: props.settings.twitter_url || "",
    store_logo: null,
});

const submit = () => {
    form.post(route('admin.setting.update'), {
        onSuccess: () => {
            ElNotification({
                title: 'Berhasil',
                message: 'Pengaturan toko telah diperbarui',
                type: 'success',
            });
        },
    });
};
</script>

<template>
    <AdminLayout>
        <Head title="Pengaturan Toko" />
        <div class="p-4 lg:p-6 bg-surface">
            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-xl lg:text-2xl font-bold text-on-surface">Pengaturan Toko</h1>
                <p class="text-xs text-on-surface-variant mt-1">Sesuaikan identitas dan informasi kontak toko Anda</p>
            </div>

            <form @submit.prevent="submit" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column: Identity & Logo -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- General Settings -->
                    <div class="bg-white border border-outline-variant rounded p-6">
                        <div class="flex items-center gap-2 mb-6 border-b border-outline-variant pb-4">
                            <el-icon class="text-primary" :size="20"><InfoFilled /></el-icon>
                            <h2 class="text-sm font-bold text-on-surface uppercase tracking-wider">Informasi Umum</h2>
                        </div>
                        
                        <div class="space-y-5">
                            <div>
                                <label class="block text-[10px] font-bold text-on-surface-variant uppercase tracking-wider mb-2">Nama Toko</label>
                                <input type="text" v-model="form.store_name" 
                                    class="w-full px-4 py-2.5 bg-white border border-outline-variant rounded text-xs text-on-surface placeholder-on-surface-variant/40 focus:ring-1 focus:ring-primary focus:border-transparent transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-on-surface-variant uppercase tracking-wider mb-2">Deskripsi Singkat</label>
                                <textarea v-model="form.store_description" rows="3"
                                    class="w-full px-4 py-2.5 bg-white border border-outline-variant rounded text-xs text-on-surface placeholder-on-surface-variant/40 focus:ring-1 focus:ring-primary focus:border-transparent transition-all resize-none"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="bg-white border border-outline-variant rounded p-6">
                        <div class="flex items-center gap-2 mb-6 border-b border-outline-variant pb-4">
                            <el-icon class="text-primary" :size="20"><Phone /></el-icon>
                            <h2 class="text-sm font-bold text-on-surface uppercase tracking-wider">Kontak & Alamat</h2>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-[10px] font-bold text-on-surface-variant uppercase tracking-wider mb-2">Email Publik</label>
                                <input type="email" v-model="form.contact_email"
                                    class="w-full px-4 py-2.5 bg-white border border-outline-variant rounded text-xs text-on-surface placeholder-on-surface-variant/40 focus:ring-1 focus:ring-primary focus:border-transparent transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-on-surface-variant uppercase tracking-wider mb-2">Telepon</label>
                                <input type="text" v-model="form.contact_phone"
                                    class="w-full px-4 py-2.5 bg-white border border-outline-variant rounded text-xs text-on-surface placeholder-on-surface-variant/40 focus:ring-1 focus:ring-primary focus:border-transparent transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-on-surface-variant uppercase tracking-wider mb-2">WhatsApp</label>
                                <input type="text" v-model="form.contact_whatsapp"
                                    class="w-full px-4 py-2.5 bg-white border border-outline-variant rounded text-xs text-on-surface placeholder-on-surface-variant/40 focus:ring-1 focus:ring-primary focus:border-transparent transition-all">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-[10px] font-bold text-on-surface-variant uppercase tracking-wider mb-2">Alamat Toko</label>
                                <textarea v-model="form.address" rows="2"
                                    class="w-full px-4 py-2.5 bg-white border border-outline-variant rounded text-xs text-on-surface placeholder-on-surface-variant/40 focus:ring-1 focus:ring-primary focus:border-transparent transition-all resize-none"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="bg-white border border-outline-variant rounded p-6">
                        <div class="flex items-center gap-2 mb-6 border-b border-outline-variant pb-4">
                            <el-icon class="text-primary" :size="20"><Share /></el-icon>
                            <h2 class="text-sm font-bold text-on-surface uppercase tracking-wider">Media Sosial</h2>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-[10px] font-bold text-on-surface-variant uppercase tracking-wider mb-2">Facebook URL</label>
                                <input type="url" v-model="form.facebook_url"
                                    class="w-full px-4 py-2.5 bg-white border border-outline-variant rounded text-xs text-on-surface placeholder-on-surface-variant/40 focus:ring-1 focus:ring-primary focus:border-transparent transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-on-surface-variant uppercase tracking-wider mb-2">Instagram URL</label>
                                <input type="url" v-model="form.instagram_url"
                                    class="w-full px-4 py-2.5 bg-white border border-outline-variant rounded text-xs text-on-surface placeholder-on-surface-variant/40 focus:ring-1 focus:ring-primary focus:border-transparent transition-all">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Logo & Action -->
                <div class="space-y-6">
                    <!-- Logo Upload -->
                    <div class="bg-white border border-outline-variant rounded p-6">
                        <div class="flex items-center gap-2 mb-6 border-b border-outline-variant pb-4">
                            <el-icon class="text-primary" :size="20"><Picture /></el-icon>
                            <h2 class="text-sm font-bold text-on-surface uppercase tracking-wider">Logo Toko</h2>
                        </div>
                        
                        <div class="flex flex-col items-center">
                            <div v-if="settings.store_logo" class="mb-4">
                                <img :src="'/storage/' + settings.store_logo" class="w-32 h-32 object-contain rounded border border-outline-variant p-2">
                            </div>
                            <div v-else class="mb-4 w-32 h-32 bg-surface rounded border border-dashed border-outline-variant flex items-center justify-center">
                                <el-icon class="text-on-surface-variant/40" :size="32"><Picture /></el-icon>
                            </div>
                            
                            <input type="file" @input="form.store_logo = $event.target.files[0]"
                                class="w-full text-xs text-on-surface-variant file:mr-4 file:py-1.5 file:px-3 file:rounded file:border file:border-outline-variant file:text-xs file:font-bold file:bg-surface file:text-on-surface hover:file:bg-surface-variant transition-all">
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div class="bg-white border border-outline-variant rounded p-6">
                        <h3 class="font-bold text-on-surface text-sm uppercase tracking-wider mb-2">Simpan Perubahan?</h3>
                        <p class="text-xs text-on-surface-variant mb-6">Pastikan semua data yang Anda masukkan sudah benar sebelum menekan tombol simpan.</p>
                        <button type="submit" :disabled="form.processing"
                            class="w-full py-2.5 bg-primary text-white font-bold text-xs uppercase tracking-wider rounded hover:bg-opacity-95 shadow transition-all disabled:opacity-50">
                            {{ form.processing ? 'Menyimpan...' : 'Simpan Pengaturan' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
