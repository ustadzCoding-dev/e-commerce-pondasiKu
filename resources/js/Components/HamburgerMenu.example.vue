<script setup>
/**
 * Example: HamburgerMenu Integration with Navbar
 *
 * This example shows how to integrate the HamburgerMenu component
 * with the existing Navbar component for a complete mobile navigation experience.
 *
 * Requirements: 1.4, 9.2
 */

import { ref, computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import HamburgerMenu from './HamburgerMenu.vue'

// State
const isMenuOpen = ref(false)

// Get auth data from Inertia props
const auth = computed(() => usePage().props.auth)

// Define menu items based on auth status
const menuItems = computed(() => {
    const items = [
        { label: 'Beranda', route: 'home' },
        { label: 'Katalog Produk', route: 'product.index' },
        { label: 'Kalkulator Material', route: 'calculator.index' },
        { label: 'Tentang', route: 'about' },
        { label: 'Kontak', route: 'contact' },
    ]

    // Add user-specific items if logged in
    if (auth.value.user) {
        items.push(
            { label: 'Dashboard', route: 'dashboard' },
            { label: 'Profil', route: 'profile.edit' },
            { label: 'Alamat', route: 'address' },
            { label: 'Logout', route: 'logout', method: 'post' }
        )
    } else {
        items.push(
            { label: 'Masuk', route: 'login' },
            { label: 'Daftar', route: 'register' }
        )
    }

    return items
})

// Handle menu close
const handleMenuClose = () => {
    isMenuOpen.value = false
}

// Handle menu open (for analytics or logging)
const handleMenuOpen = () => {
    isMenuOpen.value = true
}
</script>

<template>
    <div>
        <!-- Navbar with hamburger button trigger -->
        <nav class="bg-white  border-b border-slate-200  fixed w-full z-40 top-0 start-0 shadow-sm">
            <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
                <!-- Logo -->
                <a href="/" class="flex items-center space-x-2.5">
                    <img src="/images/logo/logo-square.webp" alt="PondasiKu" class="h-9 w-9 rounded-lg" />
                    <span class="font-display text-xl font-extrabold text-slate-900 ">
                        Pondasi<span class="text-amber-600">Ku</span>.
                    </span>
                </a>

                <!-- Right side icons -->
                <div class="flex items-center gap-2 md:order-2">
                    <!-- Dark mode toggle -->
                    <button class="p-2 text-slate-500 hover:bg-slate-100  rounded-lg">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                        </svg>
                    </button>

                    <!-- Cart icon -->
                    <a href="/cart" class="relative p-2 text-slate-700  hover:bg-slate-100  rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="absolute top-1 right-1 w-5 h-5 bg-amber-600 text-white text-xs font-bold rounded-full flex items-center justify-center">3</span>
                    </a>

                    <!-- Hamburger menu button (mobile only) -->
                    <button
                        @click="handleMenuOpen"
                        class="md:hidden p-2 text-slate-500 hover:bg-slate-100  rounded-lg"
                        aria-label="Open menu"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                <!-- Desktop navigation (hidden on mobile) -->
                <div class="hidden md:flex md:order-1 md:gap-8">
                    <a href="/" class="text-slate-700  hover:text-amber-600 font-semibold">Beranda</a>
                    <a href="/products" class="text-slate-700  hover:text-amber-600 font-semibold">Katalog</a>
                    <a href="/calculator" class="text-slate-700  hover:text-amber-600 font-semibold">Kalkulator</a>
                    <a href="/about" class="text-slate-700  hover:text-amber-600 font-semibold">Tentang</a>
                    <a href="/contact" class="text-slate-700  hover:text-amber-600 font-semibold">Kontak</a>
                </div>
            </div>
        </nav>

        <!-- HamburgerMenu component -->
        <HamburgerMenu
            :isOpen="isMenuOpen"
            :items="menuItems"
            @close="handleMenuClose"
        />

        <!-- Page content -->
        <main class="pt-20">
            <!-- Your page content here -->
        </main>
    </div>
</template>

<style scoped>
/* Optional: Add custom styles if needed */
</style>
