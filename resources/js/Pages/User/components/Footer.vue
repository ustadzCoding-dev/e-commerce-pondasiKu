<script setup>
</script>

<template>
    <footer class="bg-primary text-white border-t border-primary-600 relative overflow-hidden pt-16 pb-8">
        <!-- Background Elements -->
        <div class="absolute top-0 left-0 w-full h-[2px] bg-white opacity-20"></div>

        <div class="mx-auto max-w-[1440px] px-margin-desktop relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-lg mb-16">
                <!-- Branding and bio -->
                <div class="max-w-sm">
                    <div class="mb-6 flex items-center gap-3">
                        <span class="font-display font-bold text-2xl text-white tracking-tight">
                            Pondasi<span class="text-white/80">Ku</span>.
                        </span>
                    </div>
                    <p class="text-sm text-slate-200 leading-relaxed font-medium mb-6">
                        Pusat rantai pasok material bangunan Standar Nasional Indonesia (SNI). Menghubungkan kontraktor proyek dengan manufaktur material secara langsung, transparan, dan aman.
                    </p>
                    <div class="flex items-center gap-3 text-slate-100 bg-white/10 p-3 rounded border border-white/20 w-fit">
                        <span class="material-symbols-outlined text-white">verified_user</span>
                        <span class="text-xs font-bold uppercase tracking-[0.1em]">Bahan Konstruksi Terverifikasi</span>
                    </div>
                </div>

                <!-- Office Address info -->
                <div>
                    <h4 class="text-xs font-bold text-white uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-white rounded-full"></span>
                        Kantor Pusat
                    </h4>
                    <div class="text-sm text-slate-200 leading-relaxed space-y-4 font-medium">
                        <div class="flex gap-3">
                            <span class="material-symbols-outlined text-slate-300 text-lg">location_on</span>
                            <p>
                                <strong class="text-white block mb-1">Gedung PondasiKu Indonesia</strong>
                                Jl. Raya Bangunan Utama No. 123,<br/>
                                Kec. Gubeng, Kota Surabaya,<br/>
                                Jawa Timur, Indonesia
                            </p>
                        </div>
                        <div class="flex gap-3 items-center">
                            <span class="material-symbols-outlined text-slate-300 text-lg">phone_in_talk</span>
                            <p>+62 (31) 555-0123</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation menu -->
                <div>
                    <h4 class="text-xs font-bold text-white uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-white rounded-full"></span>
                        Navigasi Hub
                    </h4>
                    <nav aria-label="Footer Navigation">
                        <ul class="space-y-3 text-sm font-medium">
                            <li><a class="hover:text-white/80 transition-all flex items-center gap-2 group" href="/products">
                                <span class="w-1 h-1 bg-white/40 rounded-full group-hover:w-3 group-hover:bg-white transition-all"></span>
                                Katalog Produk
                            </a></li>
                            <li><a class="hover:text-white/80 transition-all flex items-center gap-2 group" href="/calculator">
                                <span class="w-1 h-1 bg-white/40 rounded-full group-hover:w-3 group-hover:bg-white transition-all"></span>
                                Kalkulator Estimasi
                            </a></li>
                            <li><a class="hover:text-white/80 transition-all flex items-center gap-2 group" href="/about">
                                <span class="w-1 h-1 bg-white/40 rounded-full group-hover:w-3 group-hover:bg-white transition-all"></span>
                                Profil Perusahaan
                            </a></li>
                            <li><a class="hover:text-white/80 transition-all flex items-center gap-2 group" href="/contact">
                                <span class="w-1 h-1 bg-white/40 rounded-full group-hover:w-3 group-hover:bg-white transition-all"></span>
                                Layanan Pengaduan
                            </a></li>
                        </ul>
                    </nav>
                </div>

                <!-- Social/Badges block -->
                <div>
                    <h4 class="text-xs font-bold text-white uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-white rounded-full"></span>
                        Metode Pembayaran
                    </h4>
                    <div class="flex flex-wrap gap-2 mb-6">
                        <span class="px-2.5 py-1.5 bg-white text-primary text-[10px] font-bold rounded uppercase tracking-wider">QRIS</span>
                        <span class="px-2.5 py-1.5 bg-white text-primary text-[10px] font-bold rounded uppercase tracking-wider">E-Wallet</span>
                        <span class="px-2.5 py-1.5 bg-white text-primary text-[10px] font-bold rounded uppercase tracking-wider">Virtual Account</span>
                        <span class="px-2.5 py-1.5 bg-white text-primary text-[10px] font-bold rounded uppercase tracking-wider">Gerai Retail</span>
                        <span class="px-2.5 py-1.5 bg-white text-primary text-[10px] font-bold rounded uppercase tracking-wider">Kartu Kredit</span>
                    </div>
                    <p class="text-xs font-medium text-slate-300 leading-relaxed uppercase tracking-wider">
                        Didukung oleh sistem pembayaran Midtrans yang aman dan terenkripsi.
                    </p>
                </div>
            </div>

            <!-- Footer copyright bar -->
            <div class="pt-8 border-t border-white/10 flex flex-col gap-6 text-center sm:flex-row sm:justify-between items-center text-xs font-bold uppercase tracking-[0.2em] text-slate-300">
                <div>© 2026 PondasiKu | TEKNOLOGI RANTAI PASOK KONSTRUKSI</div>
                <div class="flex items-center gap-6">
                    <a class="hover:text-white transition-colors" href="#">Kebijakan Privasi</a>
                    <a class="hover:text-white transition-colors" href="#">Syarat & Ketentuan</a>
                    <div class="flex gap-4 ml-4">
                        <a href="#" class="w-8 h-8 rounded bg-white/10 flex items-center justify-center hover:bg-primary hover:text-white transition-all" aria-label="Facebook">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-8 h-8 rounded bg-white/10 flex items-center justify-center hover:bg-primary hover:text-white transition-all" aria-label="Instagram">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                                <circle cx="12" cy="12" r="4"/>
                                <circle cx="17.5" cy="6.5" r="0.5" fill="currentColor"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0');
</style>