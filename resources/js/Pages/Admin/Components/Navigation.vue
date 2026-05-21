<script setup>
import { Link } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';



const route = (name) => usePage().props.routes?.[name] || window.route(name);
</script>

<template>
    <nav class="bg-primary border-b border-primary-600 px-4 py-3 fixed left-0 right-0 top-0 z-50">
        <div class="flex flex-wrap justify-between items-center">
            <!-- Left Section -->
            <div class="flex justify-start items-center">
                <!-- Mobile Menu Toggle -->
                <button
                    data-drawer-target="drawer-navigation"
                    data-drawer-toggle="drawer-navigation"
                    aria-controls="drawer-navigation"
                    class="p-2 mr-3 text-white/80 rounded cursor-pointer md:hidden hover:text-white hover:bg-primary-600 focus:bg-primary-600 focus:ring-1 focus:ring-white/50"
                >
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </button>

                <!-- Logo & Brand -->
                <Link :href="route('admin.dashboard')" class="flex items-center mr-6">
                    <span class="self-center text-xl font-bold whitespace-nowrap text-white">
                        Pondasi<span class="text-white/80">Ku</span>.
                        <span class="text-xs font-bold text-white/60 uppercase tracking-wider ml-1.5">Admin</span>
                    </span>
                </Link>
            </div>

            <!-- Right Section -->
            <div class="flex items-center gap-2">
                <!-- User Menu -->
                <button
                    type="button"
                    class="flex items-center gap-2 p-2 text-sm rounded hover:bg-primary-600 transition-colors"
                    id="user-menu-button"
                    aria-expanded="false"
                    data-dropdown-toggle="user-dropdown"
                >
                    <div class="w-8 h-8 rounded bg-white flex items-center justify-center text-primary">
                        <span class="text-sm font-bold">
                            {{ $page.props.auth.user.name.charAt(0).toUpperCase() }}
                        </span>
                    </div>
                    <span class="hidden md:block font-medium text-white">
                        {{ $page.props.auth.user.name }}
                    </span>
                    <svg class="w-4 h-4 text-white/80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- User Dropdown -->
                <div
                    class="hidden z-50 my-4 w-56 text-base list-none bg-white rounded border border-outline-variant divide-y divide-outline-variant shadow-none"
                    id="user-dropdown"
                >
                    <div class="py-3 px-4">
                        <span class="block text-sm font-bold text-on-surface">
                            {{ $page.props.auth.user.name }}
                        </span>
                        <span class="block text-xs text-on-surface-variant truncate">
                            {{ $page.props.auth.user.email }}
                        </span>
                    </div>
                    <ul class="py-1">
                        <li>
                            <Link :href="route('admin.dashboard')"
                                class="block py-2 px-4 text-sm text-on-surface hover:bg-surface">
                                Dashboard
                            </Link>
                        </li>
                        <li>
                            <Link :href="route('home')" target="_blank"
                                class="flex items-center py-2 px-4 text-sm text-on-surface hover:bg-surface">
                                Lihat Toko
                                <svg class="w-4 h-4 ml-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </Link>
                        </li>
                    </ul>
                    <div class="py-1">
                        <Link :href="route('logout')" method="post" as="button"
                            class="flex items-center w-full py-2 px-4 text-sm text-red-650 hover:bg-red-50">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Keluar
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>


