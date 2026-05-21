<script setup>
import {Head} from "@inertiajs/vue3"
import App from "@/Layouts/App.vue";
</script>

<template>
    <App>
        <Head title="Tentang Kami - Rantai Pasok Konstruksi" />
        
        <main class="bg-surface  min-h-screen pt-20 pb-20">
            <!-- Header Minimalis -->
            <div class="max-w-7xl mx-auto px-4 mb-4">
                <h1 class="font-display text-2xl font-bold text-on-surface mb-2">Tentang Pondasi<span class="text-primary">Ku</span></h1>
                <p class="text-sm text-on-surface-variant max-w-2xl">Membangun infrastruktur masa depan Indonesia dengan menghadirkan rantai pasok material konstruksi berstandar nasional (SNI) secara langsung dan transparan.</p>
            </div>

            <div class="max-w-7xl mx-auto px-4 mt-10 relative z-10">
                <!-- Visi Card details -->
                <div class="bg-white  border border-slate-200  rounded-xl p-6 md:p-10 mb-12 shadow-sm">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
                        <div>
                            <span class="section-kicker mb-2 block">Visi Kami</span>
                            <h2 class="font-display font-extrabold text-2xl text-on-surface mb-4 uppercase">Mitra Utama Pembangunan Nasional</h2>
                            <p class="text-on-surface-variant text-sm leading-relaxed font-medium italic border-l-4 border-primary pl-4 py-1">
                                "Menjadi platform terintegrasi, transparan, dan terpercaya dalam mendistribusikan solusi material bangunan premium demi mendukung kelancaran proyek perumahan dan infrastruktur nasional."
                            </p>
                        </div>
                        <div class="bg-slate-50  border border-slate-200  rounded-xl p-8 flex items-center justify-center">
                            <img src="/images/logo/og-image.png" alt="PondasiKu" class="max-h-40 object-contain rounded opacity-90" />
                        </div>
                    </div>
                </div>

                <!-- Misi Section grid -->
                <div class="mb-16">
                    <div class="mb-8">
                        <span class="section-kicker mb-1 block">Misi Perusahaan</span>
                        <h2 class="pk-title text-xl">Misi Strategis Logistik</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div v-for="(misi, index) in [
                            { title: 'Material Terverifikasi', desc: 'Seluruh rantai pasokan produk semen, besi, spandek wajib lolos pengujian standar SNI.', icon: 'verified_user' },
                            { title: 'Harga Manufaktur', desc: 'Memotong jalur perantara komersial untuk menghadirkan harga wholesale pabrik langsung.', icon: 'payments' },
                            { title: 'Kargo Instan', desc: 'Mengintegrasikan logistik kurir kargo berat untuk bongkar muat tepat waktu di lapangan.', icon: 'local_shipping' },
                            { title: 'Transparansi Penuh', desc: 'Memberikan pelacakan status pesanan, kalkulator volume, dan invoice digital Midtrans snap.', icon: 'receipt_long' }
                        ]" :key="index" class="bg-white border border-outline-variant rounded-xl p-6 flex flex-col justify-between group hover:border-primary transition-colors duration-300">
                            <div>
                                <div class="w-10 h-10 bg-surface border border-outline-variant rounded flex items-center justify-center text-on-surface-variant mb-5 group-hover:bg-primary group-hover:text-white transition-colors">
                                    <span class="material-symbols-outlined text-lg">{{ misi.icon }}</span>
                                </div>
                                <h3 class="font-display font-extrabold text-sm text-on-surface mb-2 uppercase">{{ misi.title }}</h3>
                                <p class="text-xs text-on-surface-variant leading-relaxed font-medium">{{ misi.desc }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kategori Unggulan showcase banner -->
                <div class="mb-16 bg-primary bg-gradient-to-br from-primary to-primary-600 border border-primary-600 rounded-xl p-8 lg:p-10 text-white">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-8">
                        <div>
                            <span class="inline-block px-2.5 py-0.5 bg-amber-500/20 text-amber-400 font-bold text-xs rounded uppercase tracking-widest mb-2 leading-none">
                                Manifes Kategori
                            </span>
                            <h2 class="font-display font-extrabold text-xl text-white uppercase tracking-wider block">Kategori Unggulan PondasiKu</h2>
                            <p class="text-xs text-white/70 mt-1">Solusi material konstruksi hulu ke hilir untuk kestabilan fondasi struktur bangunan Anda.</p>
                        </div>
                        <a href="/product" class="pk-btn-accent text-xs gap-2">
                            <span>Katalog Selengkapnya</span>
                            <span class="material-symbols-outlined text-sm font-black">arrow_forward</span>
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div v-for="cat in [
                            { name: 'Semen & Pasir', items: 'Semen Tiga Roda, Semen Gresik, Semen Padang, Pasir Cor' },
                            { name: 'Besi & Hollow', items: 'Besi Beton Ulir SNI, Besi Hollow Galvalum, Kawat Ikat' },
                            { name: 'Atap & Spandek', items: 'Genteng Keramik, Atap Spandek Zinkalium, Seng Gelombang' },
                            { name: 'Finishing & Cat', items: 'Cat Tembok Nippon Paint, Cat Eksterior Dulux, Pelapis Waterproofing' },
                            { name: 'Pipa & Sanitasi', items: 'Pipa PVC Wavin, Fitting Pipa, Kloset Duduk Toto, Wastafel Ceramic' },
                            { name: 'Bata & Beton', items: 'Batu Bata Merah, Batako Press, Hebel Celcon Ringan' }
                        ]" :key="cat.name" class="bg-white/10 backdrop-blur-sm p-5 rounded-xl border border-white/20 hover:bg-white/20 hover:border-white/40 transition-all duration-300">
                            <span class="text-xs font-black text-white uppercase tracking-widest block mb-2">{{ cat.name }}</span>
                            <p class="text-xs text-white/90 font-medium leading-normal">{{ cat.items }}</p>
                        </div>
                    </div>
                </div>

                <!-- Contact consultant cards -->
                <div class="mb-8">
                    <div class="text-center mb-8">
                        <span class="section-kicker mb-1 block">Konsultasi Gratis</span>
                        <h2 class="pk-title text-xl">Layanan Bantuan Proyek</h2>
                        <p class="text-xs text-on-surface-variant mt-1 max-w-sm mx-auto">Butuh bantuan perhitungan volume semen atau besi? Kontak tim logistik kami sekarang.</p>
                    </div>
                    
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                        <div v-for="contact in [
                            { label: 'Telepon Resmi', value: '+62 21 1234 5678', icon: 'phone' },
                            { label: 'WhatsApp Bisnis', value: '+62 812 3456 7890', icon: 'chat' },
                            { label: 'Layanan Surat Elektronik', value: 'sales@pondasiku.com', icon: 'mail' },
                            { label: 'Alamat Hub', value: 'Surabaya, Jawa Timur', icon: 'location_on' }
                        ]" :key="contact.label" class="bg-white border border-outline-variant p-5 rounded-xl text-center group hover:border-primary transition-all">
                            <span class="material-symbols-outlined text-on-surface-variant group-hover:text-primary transition-colors text-xl block mb-2.5">{{ contact.icon }}</span>
                            <span class="text-xs font-black text-on-surface-variant uppercase tracking-widest block mb-1">{{ contact.label }}</span>
                            <span class="text-xs font-black text-on-surface block break-words">{{ contact.value }}</span>
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
