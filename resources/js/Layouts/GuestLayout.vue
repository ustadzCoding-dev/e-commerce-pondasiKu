<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen flex items-center justify-center bg-surface px-4 py-12 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Blueprint Grid lines effect -->
        <div class="absolute inset-0 opacity-[0.03] pointer-events-none">
            <svg class="w-full h-full" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0 100 L100 0 L100 100 Z" />
            </svg>
        </div>

        <div class="max-w-md w-full space-y-6 bg-white p-8 rounded border border-outline-variant relative z-10">
            <div class="text-center mb-2">
                <Link href="/" class="inline-flex items-center gap-2 group">
                    <span class="font-display font-bold text-xl text-on-surface uppercase tracking-wider">
                        Pondasi<span class="text-primary">Ku</span>.
                    </span>
                </Link>
            </div>

            <slot />
        </div>
    </div>
</template>
