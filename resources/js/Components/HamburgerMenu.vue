<script setup>
/**
 * HamburgerMenu - Mobile Navigation Menu Component
 *
 * Displays a full-screen mobile menu that slides from the top with:
 * - Slide-from-top animation (300ms ease-out)
 * - Semi-transparent backdrop overlay (rgba(0,0,0,0.5))
 * - Close button in top-right corner
 * - Full-width menu items (48px height each)
 * - Keyboard navigation support (Escape to close)
 * - Accessibility features (aria-labels, focus management)
 *
 * Requirements: 1.4, 9.2
 */

import { ref, computed, onMounted, onUnmounted, watch } from 'vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    /**
     * Whether the menu is open
     */
    isOpen: {
        type: Boolean,
        default: false,
    },
    /**
     * Menu items to display
     * Each item should have: label, route (or href), and optional method
     */
    items: {
        type: Array,
        default: () => [
            { label: 'Beranda', route: 'home' },
            { label: 'Katalog Produk', route: 'product.index' },
            { label: 'Kalkulator Material', route: 'calculator.index' },
            { label: 'Tentang', route: 'about' },
            { label: 'Kontak', route: 'contact' },
        ],
    },
})

const emit = defineEmits(['close', 'open'])

const menuRef = ref(null)
const focusedItemIndex = ref(-1)

// Handle close button click
const handleClose = () => {
    emit('close')
}

// Handle backdrop click
const handleBackdropClick = (event) => {
    if (event.target === event.currentTarget) {
        handleClose()
    }
}

// Handle keyboard navigation
const handleKeyDown = (event) => {
    if (!props.isOpen) return

    switch (event.key) {
        case 'Escape':
            event.preventDefault()
            handleClose()
            break
        case 'ArrowDown':
            event.preventDefault()
            focusedItemIndex.value = (focusedItemIndex.value + 1) % props.items.length
            focusMenuItem(focusedItemIndex.value)
            break
        case 'ArrowUp':
            event.preventDefault()
            focusedItemIndex.value = focusedItemIndex.value <= 0
                ? props.items.length - 1
                : focusedItemIndex.value - 1
            focusMenuItem(focusedItemIndex.value)
            break
        case 'Home':
            event.preventDefault()
            focusedItemIndex.value = 0
            focusMenuItem(0)
            break
        case 'End':
            event.preventDefault()
            focusedItemIndex.value = props.items.length - 1
            focusMenuItem(focusedItemIndex.value)
            break
    }
}

// Focus a menu item
const focusMenuItem = (index) => {
    const items = menuRef.value?.querySelectorAll('[data-menu-item]')
    if (items && items[index]) {
        items[index].focus()
    }
}

// Setup event listeners
onMounted(() => {
    document.addEventListener('keydown', handleKeyDown)
})

onUnmounted(() => {
    document.removeEventListener('keydown', handleKeyDown)
})

// Watch for menu open/close to manage body scroll
watch(() => props.isOpen, (newVal) => {
    if (newVal) {
        document.body.style.overflow = 'hidden'
        focusedItemIndex.value = -1
    } else {
        document.body.style.overflow = ''
    }
})
</script>

<template>
    <!-- Backdrop overlay with semi-transparent background -->
    <Transition
        enter-active-class="transition-opacity duration-300 ease-out"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition-opacity duration-200 ease-in"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div
            v-if="isOpen"
            class="fixed inset-0 bg-black/50 z-38"
            @click="handleBackdropClick"
            aria-hidden="true"
        />
    </Transition>

    <!-- Mobile Menu Container with slide-from-top animation -->
    <Transition
        enter-active-class="transition-transform duration-300 ease-out"
        enter-from-class="-translate-y-full"
        enter-to-class="translate-y-0"
        leave-active-class="transition-transform duration-200 ease-in"
        leave-from-class="translate-y-0"
        leave-to-class="-translate-y-full"
    >
        <div
            v-if="isOpen"
            ref="menuRef"
            class="fixed top-14 left-0 right-0 bg-white  z-39 shadow-lg border-b border-slate-200 "
            :style="{ height: 'calc(100vh - 56px)' }"
            role="navigation"
            aria-label="Mobile Navigation Menu"
        >
            <!-- Close Button -->
            <button
                @click="handleClose"
                class="absolute top-4 right-4 p-2 text-slate-500 hover:text-slate-700   hover:bg-slate-100  rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-amber-600 focus:ring-offset-2 "
                aria-label="Close menu"
                type="button"
            >
                <svg
                    class="w-6 h-6"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"
                    />
                </svg>
            </button>

            <!-- Menu Items Container -->
            <div class="overflow-y-auto h-full pt-4 pb-6">
                <ul class="space-y-0" role="menubar">
                    <li
                        v-for="(item, index) in items"
                        :key="index"
                        role="none"
                    >
                        <Link
                            v-if="item.route"
                            :href="route(item.route)"
                            :method="item.method || 'get'"
                            :data-menu-item="true"
                            class="flex items-center px-4 py-3 h-12 text-slate-700  hover:bg-slate-50  hover:text-amber-600  transition-colors duration-200 font-semibold text-base focus:outline-none focus:ring-2 focus:ring-amber-600 focus:ring-inset"
                            role="menuitem"
                            @click="handleClose"
                        >
                            {{ item.label }}
                        </Link>
                        <a
                            v-else
                            :href="item.href"
                            :data-menu-item="true"
                            class="flex items-center px-4 py-3 h-12 text-slate-700  hover:bg-slate-50  hover:text-amber-600  transition-colors duration-200 font-semibold text-base focus:outline-none focus:ring-2 focus:ring-amber-600 focus:ring-inset"
                            role="menuitem"
                            @click="handleClose"
                        >
                            {{ item.label }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </Transition>
</template>

<style scoped>
/* Ensure smooth transitions */
:deep(.transition-transform) {
    will-change: transform;
}

:deep(.transition-opacity) {
    will-change: opacity;
}
</style>
