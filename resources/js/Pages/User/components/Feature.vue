<script setup>
</script>

<template>
    <section class="bg-surface py-24 relative overflow-hidden">
        <!-- Abstract Shapes -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-construction/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-orange-500/5 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>

        <div class="px-4 mx-auto max-w-screen-xl lg:px-6 relative z-10">
            <!-- Section Header -->
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-8">
                <div class="max-w-2xl">
                    <div class="flex items-center gap-2 mb-4" data-aos="fade-right">
                        <span class="h-1 w-8 bg-construction rounded-full"></span>
                        <span class="section-kicker">Standar Logistik</span>
                    </div>
                    <h2 data-aos="fade-right" class="pk-title text-2xl md:text-3xl lg:text-4xl">Keunggulan <span class="text-construction">PondasiKu</span> <br/><span class="text-on-surface-variant">Untuk Proyek Anda</span></h2>
                </div>
                <p data-aos="fade-left" class="text-on-surface-variant text-lg leading-relaxed font-medium max-w-md md:text-right">
                    Kami berkomitmen memberikan ekosistem rantai pasok material konstruksi terbaik untuk mendukung kelancaran pembangunan Anda.
                </p>
            </div>

            <!-- Bento Features grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- 1. Kualitas Terjamin -->
                <div data-aos="fade-up" class="pk-card p-8 group hover:border-construction  transition-all duration-500 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-construction/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-surface-container rounded-2xl flex items-center justify-center text-on-surface-variant mb-6 group-hover:bg-construction group-hover:text-white transition-all duration-500 shadow-inner group-hover:shadow-lg group-hover:shadow-orange-600/30 group-hover:-rotate-6">
                            <span class="material-symbols-outlined text-3xl">verified</span>
                        </div>
                        <h3 class="font-display font-black text-lg text-on-surface mb-3 uppercase tracking-tight">Kualitas Terjamin (SNI)</h3>
                        <p class="text-sm text-on-surface-variant leading-relaxed font-medium">Semua pasokan semen, besi, dan beton diproduksi oleh brand terkemuka dengan sertifikasi Standar Nasional Indonesia.</p>
                    </div>
                </div>

                <!-- 2. Harga Bersaing -->
                <div data-aos="fade-up" data-aos-delay="100" class="pk-card p-8 group hover:border-construction  transition-all duration-500 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-construction/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-orange-500/10 rounded-2xl flex items-center justify-center text-construction mb-6 group-hover:bg-construction group-hover:text-white transition-all duration-500 shadow-inner group-hover:shadow-lg group-hover:shadow-orange-600/30 group-hover:-rotate-6">
                            <span class="material-symbols-outlined text-3xl">payments</span>
                        </div>
                        <h3 class="font-display font-black text-lg text-on-surface mb-3 uppercase tracking-tight">Harga Langsung Pabrik</h3>
                        <p class="text-sm text-on-surface-variant leading-relaxed font-medium">Melalui jalur pipa rantai pasok digital terintegrasi, kami mampu meniadakan komisi perantara untuk harga terbaik.</p>
                    </div>
                </div>

                <!-- 3. Pengiriman Luas -->
                <div data-aos="fade-up" data-aos-delay="200" class="pk-card p-8 group hover:border-construction  transition-all duration-500 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-construction/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-surface-container rounded-2xl flex items-center justify-center text-on-surface-variant mb-6 group-hover:bg-construction group-hover:text-white transition-all duration-500 shadow-inner group-hover:shadow-lg group-hover:shadow-orange-600/30 group-hover:-rotate-6">
                            <span class="material-symbols-outlined text-3xl">local_shipping</span>
                        </div>
                        <h3 class="font-display font-black text-lg text-on-surface mb-3 uppercase tracking-tight">Kargo Berat Terintegrasi</h3>
                        <p class="text-sm text-on-surface-variant leading-relaxed font-medium">Bekerjasama dengan armada truk dan kurir kargo berat RajaOngkir untuk menjamin material sampai di lokasi.</p>
                    </div>
                </div>

                <!-- 4. Konsultasi Gratis -->
                <div data-aos="fade-up" class="pk-card p-8 group hover:border-construction  transition-all duration-500 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-construction/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-surface-container rounded-2xl flex items-center justify-center text-on-surface-variant mb-6 group-hover:bg-construction group-hover:text-white transition-all duration-500 shadow-inner group-hover:shadow-lg group-hover:shadow-orange-600/30 group-hover:-rotate-6">
                            <span class="material-symbols-outlined text-3xl">support_agent</span>
                        </div>
                        <h3 class="font-display font-black text-lg text-on-surface mb-3 uppercase tracking-tight">Konsultasi Ahli Proyek</h3>
                        <p class="text-sm text-on-surface-variant leading-relaxed font-medium">Dapatkan dukungan gratis dari tim teknik kami untuk rekomendasi campuran beton atau estimasi besi rangka.</p>
                    </div>
                </div>

                <!-- 5. Kalkulator Material -->
                <div data-aos="fade-up" data-aos-delay="100" class="pk-card p-8 group hover:border-construction  transition-all duration-500 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-construction/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-surface-container rounded-2xl flex items-center justify-center text-on-surface-variant mb-6 group-hover:bg-construction group-hover:text-white transition-all duration-500 shadow-inner group-hover:shadow-lg group-hover:shadow-orange-600/30 group-hover:-rotate-6">
                            <span class="material-symbols-outlined text-3xl">calculate</span>
                        </div>
                        <h3 class="font-display font-black text-lg text-on-surface mb-3 uppercase tracking-tight">Kalkulator Akurasi Tinggi</h3>
                        <p class="text-sm text-on-surface-variant leading-relaxed font-medium">Gunakan kalkulator estimasi plester semen, batu bata, dan cat tembok langsung di dashboard kami.</p>
                    </div>
                </div>

                <!-- 6. Pemesanan Mudah -->
                <div data-aos="fade-up" data-aos-delay="200" class="pk-card p-8 group hover:border-construction  transition-all duration-500 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-construction/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-surface-container rounded-2xl flex items-center justify-center text-on-surface-variant mb-6 group-hover:bg-construction group-hover:text-white transition-all duration-500 shadow-inner group-hover:shadow-lg group-hover:shadow-orange-600/30 group-hover:-rotate-6">
                            <span class="material-symbols-outlined text-3xl">add_shopping_cart</span>
                        </div>
                        <h3 class="font-display font-black text-lg text-on-surface mb-3 uppercase tracking-tight">Alur Pemesanan Cepat</h3>
                        <p class="text-sm text-on-surface-variant leading-relaxed font-medium">Tambahkan produk, hitung tarif pengiriman, dan bayar seketika melalui Snap Sandbox Midtrans terverifikasi.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0');
</style>