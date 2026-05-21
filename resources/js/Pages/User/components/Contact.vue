<script setup>
</script>

<template>
    <section class="bg-white  py-24 relative overflow-hidden">
        <div class="px-4 mx-auto max-w-screen-xl lg:px-6 relative z-10">
            <div class="bg-primary bg-gradient-to-br from-primary to-primary-700 rounded-[3rem] p-8 md:p-16 lg:p-20 relative overflow-hidden group">
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-construction/10 to-transparent pointer-events-none"></div>
                <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-construction/20 rounded-full blur-[80px] pointer-events-none group-hover:scale-110 transition-transform duration-700"></div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center relative z-10">
                    <div>
                        <div class="flex items-center gap-2 mb-6">
                            <span class="h-1 w-8 bg-construction rounded-full"></span>
                            <span class="text-xs font-black uppercase tracking-[0.3em] text-construction">Promo Eksklusif</span>
                        </div>
                        <h2 class="font-display font-black text-4xl md:text-5xl text-white leading-tight mb-6">
                            Dapatkan Diskon <span class="text-transparent bg-clip-text bg-gradient-to-r from-construction to-orange-400">20%</span> <br/>Untuk Proyek Perdana
                        </h2>
                        <p class="text-white/70 text-lg leading-relaxed font-medium mb-0">
                            Berlangganan newsletter logistik kami untuk mendapatkan estimasi harga wholesale bahan dasar konstruksi dan diskon langsung semen sak/curah resmi.
                        </p>
                    </div>

                    <div class="bg-white/5 backdrop-blur-sm p-2 rounded-[2rem] border border-white/10">
                        <form @submit.prevent class="bg-white rounded-[1.8rem] p-6 md:p-8 flex flex-col gap-4 shadow-2xl">
                            <div>
                                <label class="block text-xs font-black uppercase tracking-widest text-white/70 mb-2 ml-1">Alamat Email Proyek</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-on-surface-variant">
                                        <span class="material-symbols-outlined">mail</span>
                                    </span>
                                    <input class="w-full bg-surface border-none focus:ring-2 focus:ring-primary rounded-2xl pl-12 pr-4 py-4 text-sm font-bold text-on-surface placeholder:text-on-surface-variant" placeholder="nama@perusahaan.com" type="email" required>
                                </div>
                            </div>
                            <button type="submit" class="pk-btn-accent py-4 rounded-2xl shadow-xl shadow-orange-600/20 hover:shadow-orange-600/40 transition-all duration-300">
                                <span class="uppercase tracking-[0.2em] text-xs">Langganan Sekarang</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                            <p class="text-xs text-on-surface-variant text-center font-bold uppercase tracking-tighter">Kami menghargai privasi Anda. Data aman bersama tim logistik kami.</p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0');
</style>