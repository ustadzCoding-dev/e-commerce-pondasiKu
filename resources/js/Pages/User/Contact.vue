<script setup>
import {Head} from "@inertiajs/vue3"
import App from "@/Layouts/App.vue";
</script>

<template>
    <App>
        <Head title="Hubungi Tim Logistik Kami" />
        
        <main class="bg-surface  min-h-screen pt-20 pb-20">
            <!-- Header Minimalis -->
            <div class="max-w-7xl mx-auto px-4 mb-8">
                <h1 class="text-2xl font-bold text-on-surface mb-2">Hubungi Tim Kami</h1>
                <p class="text-sm text-on-surface-variant max-w-2xl">Ada pertanyaan mengenai ketersediaan stok semen, pengiriman besi beton kargo, atau ingin berkonsultasi? Kami siap membantu kelancaran proyek Anda.</p>
            </div>

            <div class="max-w-7xl mx-auto px-4 mt-10 relative z-10 pb-12">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    <!-- Left: Info Cards Sidebar -->
                    <div class="lg:col-span-4 space-y-4">
                        <div v-for="info in [
                            { 
                                label: 'Telepon Resmi', 
                                value: '+62 21 1234 5678', 
                                sub: 'Senin - Jumat: 08:00 - 17:00 WIB',
                                icon: 'phone',
                                color: 'text-on-surface-variant',
                                bg: 'bg-surface border border-outline-variant'
                            },
                            { 
                                label: 'WhatsApp Bisnis', 
                                value: '+62 812 3456 7890', 
                                sub: 'Respon cepat bongkar muat 24 jam',
                                icon: 'chat',
                                color: 'text-primary',
                                bg: 'bg-primary/10 border border-primary/20'
                            },
                            { 
                                label: 'Surat Elektronik', 
                                value: 'sales@pondasiku.com', 
                                sub: 'Korespondensi resmi B2B & Kontraktor',
                                icon: 'mail',
                                color: 'text-on-surface-variant',
                                bg: 'bg-surface border border-outline-variant'
                            },
                            { 
                                label: 'Lokasi Hub Gudang', 
                                value: 'Surabaya, Jawa Timur', 
                                sub: 'Buka Setiap Hari: 08:00 - 20:00 WIB',
                                icon: 'location_on',
                                color: 'text-on-surface-variant',
                                bg: 'bg-surface border border-outline-variant'
                            }
                        ]" :key="info.label" class="bg-white border border-outline-variant p-5 rounded-xl flex items-start gap-4 hover:border-primary transition-colors group">
                            <div :class="[info.bg, info.color, 'w-10 h-10 rounded flex items-center justify-center flex-shrink-0']">
                                <span class="material-symbols-outlined text-lg">{{ info.icon }}</span>
                            </div>
                            <div>
                                <p class="text-xs font-black text-on-surface-variant uppercase tracking-widest mb-1">{{ info.label }}</p>
                                <p class="text-xs font-black text-on-surface mb-1.5 leading-none">{{ info.value }}</p>
                                <p class="text-xs text-on-surface-variant font-medium leading-none">{{ info.sub }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Contact Form -->
                    <div class="lg:col-span-8">
                        <div class="bg-white border border-outline-variant rounded-xl p-6 md:p-10 shadow-sm">
                            <div class="mb-8">
                                <span class="section-kicker mb-1.5 block">Kirim Formulir</span>
                                <h2 class="font-display font-extrabold text-xl text-on-surface uppercase tracking-wider mb-2">Hubungi Layanan Pengaduan</h2>
                                <p class="text-xs text-on-surface-variant">Silakan isi detail pertanyaan Anda, tim konsultan logistik kami akan merespons dalam waktu 30 menit.</p>
                            </div>
                            
                            <form @submit.prevent class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div class="md:col-span-1">
                                    <label class="block text-xs font-black text-on-surface-variant uppercase tracking-widest mb-1.5">Nama Lengkap Penanggung Jawab</label>
                                    <input type="text" class="pk-input w-full" placeholder="Nama lengkap Anda" required />
                                </div>
                                <div class="md:col-span-1">
                                    <label class="block text-xs font-black text-on-surface-variant uppercase tracking-widest mb-1.5">Alamat Surat Elektronik</label>
                                    <input type="email" class="pk-input w-full" placeholder="email@proyek.com" required />
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-black text-on-surface-variant uppercase tracking-widest mb-1.5">Perihal Kebutuhan Konstruksi</label>
                                    <select class="pk-input w-full font-bold">
                                        <option>Konsultasi Bahan Proyek</option>
                                        <option>Pengiriman Kargo Semen & Besi</option>
                                        <option>Pertanyaan Ketersediaan Stok</option>
                                        <option>Lainnya</option>
                                    </select>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-black text-on-surface-variant uppercase tracking-widest mb-1.5">Pesan Detail Penawaran</label>
                                    <textarea rows="4" class="pk-input w-full" placeholder="Tuliskan perincian material konstruksi yang ingin ditanyakan di sini..." required></textarea>
                                </div>
                                <div class="md:col-span-2 pt-2">
                                    <button type="submit" class="w-full pk-btn-accent flex items-center justify-center gap-2">
                                        <span>Kirim Formulir Sekarang</span>
                                        <span class="material-symbols-outlined text-sm font-black">send</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </App>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0');
</style>
