<script setup>
import {Splide, SplideSlide} from "@splidejs/vue-splide";
</script>

<template>
    <section class="bg-white  py-24 relative overflow-hidden">
        <!-- Decorative Background -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full bg-construction/5 blur-[120px] rounded-full pointer-events-none"></div>

        <div class="max-w-screen-xl mx-auto px-4 relative z-10">
            <div class="text-center mb-16">
                <div class="flex items-center justify-center gap-2 mb-4">
                    <span class="h-1 w-8 bg-construction rounded-full"></span>
                    <span class="section-kicker">Testimoni</span>
                    <span class="h-1 w-8 bg-construction rounded-full"></span>
                </div>
                <h2 class="pk-title text-2xl md:text-3xl lg:text-4xl">Apa Kata <span class="text-on-surface-variant">Mitra Kami?</span></h2>
            </div>

            <div class="max-w-4xl mx-auto">
                <Splide :options="{ type : 'loop', gap: '2rem', autoplay: true, arrows: true, pagination: true, interval: 5000, speed: 1000, padding: { left: 0, right: 0 } }" aria-label="Testimoni Pelanggan" class="custom-splide">
                    <!-- Slide 1 -->
                    <SplideSlide>
                        <div class="bg-slate-50 py-10 px-8 md:py-12 md:px-16 rounded-[2.5rem] border border-slate-100 relative">
                            <!-- Quote Icon -->
                            <div class="absolute -top-6 left-12 w-12 h-12 bg-construction text-white rounded-2xl flex items-center justify-center shadow-lg shadow-orange-600/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H16.017C14.9124 8 14.017 7.10457 14.017 6V5C14.017 3.89543 14.9124 3 16.017 3H19.017C21.2261 3 23.017 4.79086 23.017 7V15C23.017 18.3137 20.3307 21 17.017 21H14.017ZM1.017 21L1.017 18C1.017 16.8954 1.91243 16 3.017 16H6.017C6.56928 16 7.017 15.5523 7.017 15V9C7.017 8.44772 6.56928 8 6.017 8H3.017C1.91243 8 1.017 7.10457 1.017 6V5C1.017 3.89543 1.91243 3 3.017 3H6.017C8.22614 3 10.017 4.79086 10.017 7V15C10.017 18.3137 7.33071 21 4.017 21H1.017Z" />
                                </svg>
                            </div>
                            
                            <blockquote class="mb-10">
                                <p class="font-display font-bold text-xl md:text-2xl text-slate-800  leading-relaxed italic">
                                    "Pelayanan pengantaran material sangat presisi! Semen Tiga Roda dan besi beton SNI sampai di lokasi proyek tepat waktu. Sangat menolong efisiensi pengerjaan fondasi hunian."
                                </p>
                            </blockquote>
                            
                            <div class="flex items-center gap-4">
                                <img class="w-14 h-14 rounded-2xl border-2 border-white  shadow-md object-cover" src="https://ui-avatars.com/api/?name=Budi+Santoso&background=F97316&color=fff" alt="Budi Santoso">
                                <div>
                                    <span class="text-slate-900  font-black text-lg block tracking-tight">Budi Santoso</span>
                                    <span class="text-construction font-bold text-xs uppercase tracking-widest mt-0.5 block">Kontraktor Proyek, Jakarta</span>
                                </div>
                            </div>
                        </div>
                    </SplideSlide>

                    <!-- Slide 2 -->
                    <SplideSlide>
                        <div class="bg-slate-50 py-10 px-8 md:py-12 md:px-16 rounded-[2.5rem] border border-slate-100 relative">
                            <div class="absolute -top-6 left-12 w-12 h-12 bg-construction text-white rounded-2xl flex items-center justify-center shadow-lg shadow-amber-600/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H16.017C14.9124 8 14.017 7.10457 14.017 6V5C14.017 3.89543 14.9124 3 16.017 3H19.017C21.2261 3 23.017 4.79086 23.017 7V15C23.017 18.3137 20.3307 21 17.017 21H14.017ZM1.017 21L1.017 18C1.017 16.8954 1.91243 16 3.017 16H6.017C6.56928 16 7.017 15.5523 7.017 15V9C7.017 8.44772 6.56928 8 6.017 8H3.017C1.91243 8 1.017 7.10457 1.017 6V5C1.017 3.89543 1.91243 3 3.017 3H6.017C8.22614 3 10.017 4.79086 10.017 7V15C10.017 18.3137 7.33071 21 4.017 21H1.017Z" />
                                </svg>
                            </div>
                            
                            <blockquote class="mb-10">
                                <p class="font-display font-bold text-xl md:text-2xl text-slate-800  leading-relaxed italic">
                                    "Harga grosir yang bersaing langsung dari pabrikan semen tanpa perantara komersial. Kami telah bermitra dari proyek infrastruktur pertama hingga sekarang."
                                </p>
                            </blockquote>
                            
                            <div class="flex items-center gap-4">
                                <img class="w-14 h-14 rounded-2xl border-2 border-white  shadow-md object-cover" src="https://ui-avatars.com/api/?name=Siti+Rahayu&background=F97316&color=fff" alt="Siti Rahayu">
                                <div>
                                    <span class="text-slate-900  font-black text-lg block tracking-tight">Siti Rahayu</span>
                                    <span class="text-construction font-bold text-xs uppercase tracking-widest mt-0.5 block">Arsitek Perencana, Bandung</span>
                                </div>
                            </div>
                        </div>
                    </SplideSlide>

                    <!-- Slide 3 -->
                    <SplideSlide>
                        <div class="bg-slate-50 py-10 px-8 md:py-12 md:px-16 rounded-[2.5rem] border border-slate-100 relative">
                            <div class="absolute -top-6 left-12 w-12 h-12 bg-construction text-white rounded-2xl flex items-center justify-center shadow-lg shadow-orange-600/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H16.017C14.9124 8 14.017 7.10457 14.017 6V5C14.017 3.89543 14.9124 3 16.017 3H19.017C21.2261 3 23.017 4.79086 23.017 7V15C23.017 18.3137 20.3307 21 17.017 21H14.017ZM1.017 21L1.017 18C1.017 16.8954 1.91243 16 3.017 16H6.017C6.56928 16 7.017 15.5523 7.017 15V9C7.017 8.44772 6.56928 8 6.017 8H3.017C1.91243 8 1.017 7.10457 1.017 6V5C1.017 3.89543 1.91243 3 3.017 3H6.017C8.22614 3 10.017 4.79086 10.017 7V15C10.017 18.3137 7.33071 21 4.017 21H1.017Z" />
                                </svg>
                            </div>
                            
                            <blockquote class="mb-10">
                                <p class="font-display font-bold text-xl md:text-2xl text-slate-800  leading-relaxed italic">
                                    "Fitur kalkulator semen plesteran dan besi beton sangat menolong estimasi volume logistik proyek kami sebelum memesan invoice Snap Midtrans. Top!"
                                </p>
                            </blockquote>
                            
                            <div class="flex items-center gap-4">
                                <img class="w-14 h-14 rounded-2xl border-2 border-white  shadow-md object-cover" src="https://ui-avatars.com/api/?name=Ahmad+Wijaya&background=F97316&color=fff" alt="Ahmad Wijaya">
                                <div>
                                    <span class="text-slate-900  font-black text-lg block tracking-tight">Ahmad Wijaya</span>
                                    <span class="text-construction font-bold text-xs uppercase tracking-widest mt-0.5 block">Developer Kawasan, Surabaya</span>
                                </div>
                            </div>
                        </div>
                    </SplideSlide>
                </Splide>
            </div>
        </div>
    </section>
</template>

<style scoped>
.custom-splide :deep(.splide__track) {
    padding-top: 2rem !important;
    margin-top: -2rem !important;
}

.custom-splide :deep(.splide__pagination) {
    bottom: -3rem;
}

.custom-splide :deep(.splide__pagination__page) {
    width: 12px;
    height: 12px;
    background: #CBD5E1;
    opacity: 1;
    transition: all 0.3s ease;
}

.custom-splide :deep(.splide__pagination__page.is-active) {
    background: #F97316 !important;
    width: 32px;
    border-radius: 6px;
}

.custom-splide :deep(.splide__arrow) {
    background: white;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    width: 3rem;
    height: 3rem;
    opacity: 1;
    border: 1px solid #E2E8F0;
}

.custom-splide :deep(.splide__arrow:hover) {
    background: #ea580c;
}

.custom-splide :deep(.splide__arrow svg) {
    fill: #0F172A;
}

.custom-splide :deep(.splide__arrow:hover svg) {
    fill: #ffffff;
}

/* Position arrows outside the slide content */
.custom-splide :deep(.splide__arrows) {
    position: absolute;
    width: calc(100% + 5rem);
    left: -2.5rem;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
}

.custom-splide :deep(.splide__arrow) {
    pointer-events: all;
    position: absolute;
    top: 0;
}

.custom-splide :deep(.splide__arrow--prev) {
    left: 0;
}

.custom-splide :deep(.splide__arrow--next) {
    right: 0;
}
</style>