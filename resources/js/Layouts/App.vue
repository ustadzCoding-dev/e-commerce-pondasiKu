<script setup>
import {onMounted, onUnmounted, ref} from 'vue'
import { initFlowbite } from 'flowbite'
import Navbar from "@/Pages/User/components/Navbar.vue";
import Footer from "@/Pages/User/components/Footer.vue";
import AOS from "aos";

// initialize components based on data attribute selectors
const isHidden = ref(true)

const handleScroll = () => {
    if (window.pageYOffset > 500) {
        isHidden.value = false;
    } else {
        isHidden.value = true;
    }
}

const scrollToTop = () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
};

onMounted(() => {
    initFlowbite();
    AOS.init({
        duration: 800,
        once: true,
        easing: 'ease-out-cubic'
    });
    window.addEventListener('scroll', handleScroll);
    handleScroll();
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
});
</script>

<template>
    <div class="antialiased bg-white  overflow-x-hidden min-h-screen flex flex-col selection:bg-construction/20 selection:text-construction">
        <Navbar/>
        
        <div class="flex-grow pt-16 md:pt-20">
            <main>
                <slot />
            </main>
        </div>

        <Footer/>

        <!-- Refined Scroll to Top Button -->
        <div class="fixed bottom-8 right-8 z-50">
            <button @click="scrollToTop" 
                :class="[
                    'bg-slate-900  text-white  w-12 h-12 rounded-2xl shadow-2xl transition-all duration-500 transform hover:-translate-y-2 focus:outline-none flex items-center justify-center group',
                    { 'opacity-0 translate-y-10 pointer-events-none': isHidden, 'opacity-100 translate-y-0': !isHidden }
                ]"
            >
                <svg class="w-5 h-5 transition-transform group-hover:-translate-y-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                </svg>
                
                <!-- Hover Tooltip -->
                <span class="absolute right-full mr-4 px-3 py-1 bg-slate-900 text-white text-xs font-black uppercase tracking-widest rounded-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">
                    Kembali ke Atas
                </span>
            </button>
        </div>

        <!-- Global Progress Bar (Visual Only) -->
        <div class="fixed top-0 left-0 w-full h-1 z-[60] pointer-events-none">
            <div class="h-full bg-construction shadow-[0_0_10px_rgba(217,119,6,0.5)] transition-all duration-300" style="width: 0%" id="scroll-progress"></div>
        </div>
    </div>
</template>
