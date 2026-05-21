<script setup>
import {computed, onMounted, ref, onUnmounted} from 'vue'
import { initFlowbite } from 'flowbite'
import { Link, usePage } from '@inertiajs/vue3';

// initialize components based on data attribute selectors
onMounted(() => {
    initFlowbite();
})

const canLogin = usePage().props.canLogin;
const canRegister = usePage().props.canRegister;
const auth = usePage().props.auth;
const carts_global_count = computed(() => usePage().props.carts_global_count || 0);



// Mobile menu state
const isMobileMenuOpen = ref(false);

// User dropdown state
const isUserDropdownOpen = ref(false);
const userDropdownRef = ref(null);
const userButtonRef = ref(null);
const focusedMenuItemIndex = ref(-1);

// Menu items for keyboard navigation
const menuItems = computed(() => {
    if (!auth.user) return [];
    
    if (auth.user.isAdmin) {
        return [
            { label: 'Kembali ke Admin', route: 'admin.dashboard' }
        ];
    }
    
    return [
        { label: 'Dashboard Saya', route: 'dashboard' },
        { label: 'Profil Saya', route: 'profile.edit' },
        { label: 'Alamat Saya', route: 'address' },
        { label: 'Keluar', route: 'logout', method: 'post' }
    ];
});

// Toggle dropdown
const toggleUserDropdown = () => {
    isUserDropdownOpen.value = !isUserDropdownOpen.value;
    if (isUserDropdownOpen.value) {
        focusedMenuItemIndex.value = -1;
    }
};

// Toggle mobile menu
const toggleMobileMenu = () => {
    isMobileMenuOpen.value = !isMobileMenuOpen.value;
};

// Close mobile menu
const closeMobileMenu = () => {
    isMobileMenuOpen.value = false;
};

// Close dropdown
const closeUserDropdown = () => {
    isUserDropdownOpen.value = false;
    focusedMenuItemIndex.value = -1;
};

// Handle click outside
const handleClickOutside = (event) => {
    if (userDropdownRef.value && !userDropdownRef.value.contains(event.target) &&
        userButtonRef.value && !userButtonRef.value.contains(event.target)) {
        closeUserDropdown();
    }
};

// Handle keyboard navigation
const handleKeyDown = (event) => {
    if (!isUserDropdownOpen.value) return;
    
    switch (event.key) {
        case 'Escape':
            event.preventDefault();
            closeUserDropdown();
            userButtonRef.value?.focus();
            break;
        case 'ArrowDown':
            event.preventDefault();
            focusedMenuItemIndex.value = (focusedMenuItemIndex.value + 1) % menuItems.value.length;
            break;
        case 'ArrowUp':
            event.preventDefault();
            focusedMenuItemIndex.value = focusedMenuItemIndex.value <= 0 
                ? menuItems.value.length - 1 
                : focusedMenuItemIndex.value - 1;
            break;
        case 'Enter':
            event.preventDefault();
            if (focusedMenuItemIndex.value >= 0) {
                // Trigger click on focused menu item
                const menuItemElements = userDropdownRef.value?.querySelectorAll('[data-menu-item]');
                menuItemElements?.[focusedMenuItemIndex.value]?.click();
            }
            break;
        case 'Home':
            event.preventDefault();
            focusedMenuItemIndex.value = 0;
            break;
        case 'End':
            event.preventDefault();
            focusedMenuItemIndex.value = menuItems.value.length - 1;
            break;
    }
};

// Setup event listeners
onMounted(() => {
    document.addEventListener('click', handleClickOutside);
    document.addEventListener('keydown', handleKeyDown);
});

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside);
    document.removeEventListener('keydown', handleKeyDown);
});

</script>

<template>
    <nav class="bg-white/95 backdrop-blur-md border-b border-outline-variant fixed w-full z-40 top-0 start-0 transition-all duration-300 shadow-[0_4px_20px_rgba(0,0,0,0.05)]">
        <div class="max-w-[1440px] flex flex-wrap items-center justify-between mx-auto px-margin-desktop py-4">
            <Link :href="route('home')" class="flex items-center space-x-3 rtl:space-x-reverse group">
                <span class="self-center font-display text-2xl font-bold tracking-tight text-on-surface transition-colors">
                    Pondasi<span class="text-primary">Ku</span>.
                </span>
            </Link>
            
            <div v-if="canLogin" class="flex md:order-2 items-center gap-3">

                <!-- Universal Cart Icon -->
                <div class="flex items-center">
                    <Link :href="route('cart.show')"
                          class="relative inline-flex items-center p-2 text-sm font-medium text-center text-on-surface-variant rounded bg-surface-container-low border border-outline-variant hover:bg-surface-container hover:text-primary transition-all focus:outline-none focus:ring-1 focus:ring-primary"
                          aria-label="Keranjang Belanja">
                        <span class="material-symbols-outlined text-on-surface-variant">shopping_cart</span>
                        <span class="sr-only">Keranjang Belanja - {{ carts_global_count }} item</span>
                        <Transition
                            enter-active-class="transition-all duration-300 ease-out"
                            enter-from-class="scale-0 opacity-0"
                            enter-to-class="scale-100 opacity-100"
                            leave-active-class="transition-all duration-200 ease-in"
                            leave-from-class="scale-100 opacity-100"
                            leave-to-class="scale-0 opacity-0"
                            mode="out-in">
                            <div v-if="carts_global_count > 0"
                                :key="carts_global_count"
                                class="absolute inline-flex items-center text-center justify-center w-5 h-5 text-xs font-bold text-white bg-primary border-2 border-white rounded-full -top-1.5 -right-1.5 animate-pulse">
                                <span class="mt-0.5">{{ carts_global_count }}</span>
                            </div>
                        </Transition>
                    </Link>
                </div>
                
                <!-- Auth Section -->
                <div v-if="!auth.user" class="hidden md:flex items-center gap-3 ml-2">
                    <Link :href="route('login')"
                          class="px-4 py-2 text-sm font-bold text-secondary-800 hover:text-primary transition-colors">
                        Masuk</Link>
                    <Link :href="route('register')" v-if="canRegister"
                          class="bg-primary text-white px-5 py-2.5 rounded text-xs font-bold uppercase tracking-wider hover:bg-opacity-95 transition-all shadow-[0_4px_14px_0_rgba(249,115,22,0.39)] hover:shadow-[0_6px_20px_rgba(249,115,22,0.23)] hover:-translate-y-0.5">
                        Daftar</Link>
                </div>

                <!-- Logged In User Dropdown -->
                <div v-if="auth.user" class="relative">
                    <button @click="toggleUserDropdown" ref="userButtonRef" type="button"
                            class="flex items-center gap-2 pl-2 pr-3 py-1.5 bg-surface-container-low rounded border border-outline-variant hover:bg-surface-container-high transition-all shadow-none">
                        <div class="w-8 h-8 rounded bg-primary/10 flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary text-xl">account_circle</span>
                        </div>
                        <span class="capitalize hidden md:block font-bold text-sm text-on-surface">{{auth.user.name}}</span>
                        <svg class="w-4 h-4 text-on-surface-variant transition-transform" :class="{ 'rotate-180': isUserDropdownOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <Transition
                        enter-active-class="transition duration-100 ease-out"
                        enter-from-class="transform scale-95 opacity-0"
                        enter-to-class="transform scale-100 opacity-100"
                        leave-active-class="transition duration-75 ease-in"
                        leave-from-class="transform scale-100 opacity-100"
                        leave-to-class="transform scale-95 opacity-0">
                        <div v-if="isUserDropdownOpen" ref="userDropdownRef" 
                             class="absolute right-0 mt-2 w-56 origin-top-right divide-y divide-outline-variant rounded bg-white shadow-none border border-outline-variant focus:outline-none z-50 overflow-hidden">
                            <div class="px-4 py-3 bg-surface-container-low">
                                <p class="text-xs font-bold text-on-surface-variant uppercase tracking-widest mb-1">Signed in as</p>
                                <p class="text-sm font-bold text-on-surface truncate">{{ auth.user.email }}</p>
                            </div>
                            <div class="py-1">
                                <Link v-for="(item, index) in menuItems" :key="index"
                                      :href="item.route.includes('.') ? route(item.route) : route(item.route)"
                                      :method="item.method || 'get'"
                                      as="button"
                                      class="flex w-full items-center px-4 py-2.5 text-sm font-bold transition-colors"
                                      :class="[
                                          focusedMenuItemIndex === index 
                                          ? 'bg-surface-container-low text-primary' 
                                          : 'text-on-surface-variant hover:bg-surface-container-low hover:text-primary'
                                      ]"
                                      @click="closeUserDropdown">
                                    {{ item.label }}
                                </Link>
                            </div>
                        </div>
                    </Transition>
                </div>

                <!-- Mobile Menu Button -->
                <button @click="toggleMobileMenu" type="button" class="inline-flex items-center p-2.5 w-11 h-11 justify-center text-on-surface-variant rounded md:hidden bg-surface-container-low border border-outline-variant hover:bg-surface-container transition-all">
                    <span class="sr-only">Menu</span>
                    <svg class="w-6 h-6 transition-transform duration-300" :class="{ 'rotate-90': isMobileMenuOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path v-if="!isMobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        <path v-else stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Main Navigation -->
            <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
                <ul class="flex flex-col p-4 md:p-0 mt-4 font-bold border border-outline-variant rounded bg-surface-container-low md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-transparent">
                    <li>
                        <Link :href="route('home')" class="block py-1 text-sm font-bold transition-colors" :class="route().current('home') ? 'text-primary border-b-2 border-primary font-bold' : 'text-on-surface-variant hover:text-primary'">Beranda</Link>
                    </li>
                    <li>
                        <Link :href="route('product.index')" class="block py-1 text-sm font-bold transition-colors" :class="route().current('product.*') ? 'text-primary border-b-2 border-primary font-bold' : 'text-on-surface-variant hover:text-primary'">Katalog</Link>
                    </li>
                    <li>
                        <Link :href="route('calculator.index')" class="block py-1 text-sm font-bold transition-colors" :class="route().current('calculator.*') ? 'text-primary border-b-2 border-primary font-bold' : 'text-on-surface-variant hover:text-primary'">Kalkulator</Link>
                    </li>
                    <li>
                        <Link :href="route('about')" class="block py-1 text-sm font-bold transition-colors" :class="route().current('about') ? 'text-primary border-b-2 border-primary font-bold' : 'text-on-surface-variant hover:text-primary'">Tentang Kami</Link>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Mobile Menu -->
        <Transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="transform -translate-y-4 opacity-0"
            enter-to-class="transform translate-y-0 opacity-100"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="transform translate-y-0 opacity-100"
            leave-to-class="transform -translate-y-4 opacity-0">
            <div v-if="isMobileMenuOpen" class="md:hidden border-t border-outline-variant bg-white px-margin-desktop py-6 space-y-4 shadow-none">
                <div class="grid grid-cols-1 gap-2">
                    <Link :href="route('home')" @click="closeMobileMenu" class="flex items-center gap-3 p-3 rounded hover:bg-surface-container-low font-bold" :class="route().current('home') ? 'text-primary bg-primary/5' : 'text-on-surface-variant'">
                        Beranda
                    </Link>
                    <Link :href="route('product.index')" @click="closeMobileMenu" class="flex items-center gap-3 p-3 rounded hover:bg-surface-container-low font-bold" :class="route().current('product.*') ? 'text-primary bg-primary/5' : 'text-on-surface-variant'">
                        Katalog
                    </Link>
                    <Link :href="route('calculator.index')" @click="closeMobileMenu" class="flex items-center gap-3 p-3 rounded hover:bg-surface-container-low font-bold" :class="route().current('calculator.*') ? 'text-primary bg-primary/5' : 'text-on-surface-variant'">
                        Kalkulator
                    </Link>
                    <Link :href="route('about')" @click="closeMobileMenu" class="flex items-center gap-3 p-3 rounded hover:bg-surface-container-low font-bold" :class="route().current('about') ? 'text-primary bg-primary/5' : 'text-on-surface-variant'">
                        Tentang Kami
                    </Link>
                </div>
                
                <!-- Mobile: User menu when logged in -->
                <div v-if="auth.user" class="pt-4 border-t border-outline-variant">
                    <div class="px-3 py-2 mb-2">
                        <p class="text-xs font-bold text-on-surface-variant uppercase tracking-widest">Akun</p>
                        <p class="text-sm font-bold text-on-surface truncate mt-0.5">{{ auth.user.email }}</p>
                    </div>
                    <div class="grid grid-cols-1 gap-1">
                        <template v-if="auth.user.isAdmin">
                            <Link :href="route('admin.dashboard')" @click="closeMobileMenu" class="flex items-center gap-3 p-3 rounded hover:bg-surface-container-low font-bold text-on-surface-variant">
                                Panel Admin
                            </Link>
                        </template>
                        <template v-else>
                            <Link :href="route('dashboard')" @click="closeMobileMenu" class="flex items-center gap-3 p-3 rounded hover:bg-surface-container-low font-bold text-on-surface-variant">
                                Dashboard Saya
                            </Link>
                            <Link :href="route('profile.edit')" @click="closeMobileMenu" class="flex items-center gap-3 p-3 rounded hover:bg-surface-container-low font-bold text-on-surface-variant">
                                Profil Saya
                            </Link>
                            <Link :href="route('address')" @click="closeMobileMenu" class="flex items-center gap-3 p-3 rounded hover:bg-surface-container-low font-bold text-on-surface-variant">
                                Alamat Saya
                            </Link>
                            <Link :href="route('logout')" method="post" as="button" @click="closeMobileMenu" class="flex w-full items-center gap-3 p-3 rounded hover:bg-red-50 font-bold text-red-600">
                                Keluar
                            </Link>
                        </template>
                    </div>
                </div>

                <!-- Mobile: Login/Register if not logged in -->
                <div v-if="!auth.user" class="pt-4 border-t border-outline-variant grid grid-cols-2 gap-3">
                    <Link :href="route('login')" class="flex items-center justify-center p-3 rounded border border-outline-variant font-bold text-on-surface-variant">Masuk</Link>
                    <Link :href="route('register')" class="flex items-center justify-center p-3 rounded bg-primary text-white font-bold uppercase text-xs tracking-wider shadow-none">Daftar</Link>
                </div>
            </div>
        </Transition>
    </nav>
</template>