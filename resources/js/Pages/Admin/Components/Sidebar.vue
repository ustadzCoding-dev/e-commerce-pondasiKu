<script setup>
import { Link } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';

const route = (name) => usePage().props.routes?.[name] || window.route(name);
</script>

<template>
    <aside
        class="fixed top-0 left-0 z-40 w-64 h-screen pt-16 transition-transform -translate-x-full bg-white border-r border-outline-variant md:translate-x-0 flex flex-col shadow-xl"
        aria-label="Sidebar Admin"
        id="drawer-navigation"
    >
        <!-- Scrollable Menu Area -->
        <div class="flex-1 overflow-y-auto py-5 px-3 custom-scrollbar bg-white">
            <!-- Menu Items -->
            <ul class="space-y-1.5 pb-4">
                <!-- Dashboard -->
                <li>
                    <Link :href="route('admin.dashboard')"
                        class="flex items-center p-2.5 text-xs font-bold text-on-surface-variant rounded hover:bg-primary-50 hover:text-primary group transition-all"
                        :class="{'bg-primary-50 text-primary border-l-2 border-primary': $page.url === '/admin/dashboard'}"
                    >
                        <div class="p-1.5 rounded bg-secondary-800 border border-secondary-700 group-hover:border-primary/50 transition-colors"
                             :class="{'border-primary/50 bg-secondary-800': $page.url === '/admin/dashboard'}">
                            <svg class="w-4 h-4 text-secondary-400 group-hover:text-primary transition-colors" :class="{'text-primary': $page.url === '/admin/dashboard'}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1-1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </div>
                        <span class="ml-3">Dashboard</span>
                    </Link>
                </li>

                <!-- Divider -->
                <li class="pt-4">
                    <span class="px-3 text-[9px] font-bold text-on-surface-variant uppercase tracking-wider">Kelola Toko</span>
                </li>

                <!-- Banner -->
                <li>
                    <Link :href="route('admin.banner.index')"
                        class="flex items-center p-2.5 text-xs font-bold text-on-surface-variant rounded hover:bg-primary-50 hover:text-primary group transition-all"
                        :class="{'bg-primary-50 text-primary border-l-2 border-primary': $page.url.startsWith('/admin/banner')}"
                    >
                        <div class="p-1.5 rounded bg-surface border border-outline-variant group-hover:bg-white group-hover:border-primary/50 transition-colors"
                             :class="{'border-primary/30': $page.url.startsWith('/admin/banner')}">
                            <svg class="w-4 h-4 text-on-surface-variant group-hover:text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <span class="ml-3">Banner</span>
                    </Link>
                </li>

                <!-- Category -->
                <li>
                    <Link :href="route('admin.category.index')"
                        class="flex items-center p-2.5 text-xs font-bold text-on-surface-variant rounded hover:bg-primary-50 hover:text-primary group transition-all"
                        :class="{'bg-primary-50 text-primary border-l-2 border-primary': $page.url.startsWith('/admin/category')}"
                    >
                        <div class="p-1.5 rounded bg-surface border border-outline-variant group-hover:bg-white group-hover:border-primary/50 transition-colors"
                             :class="{'border-primary/30': $page.url.startsWith('/admin/category')}">
                            <svg class="w-4 h-4 text-on-surface-variant group-hover:text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <span class="ml-3">Kategori</span>
                    </Link>
                </li>

                <!-- Brand -->
                <li>
                    <Link :href="route('admin.brand.index')"
                        class="flex items-center p-2.5 text-xs font-bold text-on-surface-variant rounded hover:bg-primary-50 hover:text-primary group transition-all"
                        :class="{'bg-primary-50 text-primary border-l-2 border-primary': $page.url.startsWith('/admin/brand')}"
                    >
                        <div class="p-1.5 rounded bg-surface border border-outline-variant group-hover:bg-white group-hover:border-primary/50 transition-colors"
                             :class="{'border-primary/30': $page.url.startsWith('/admin/brand')}">
                            <svg class="w-4 h-4 text-on-surface-variant group-hover:text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        <span class="ml-3">Brand</span>
                    </Link>
                </li>

                <!-- Product -->
                <li>
                    <Link :href="route('admin.product.index')"
                        class="flex items-center p-2.5 text-xs font-bold text-on-surface-variant rounded hover:bg-primary-50 hover:text-primary group transition-all"
                        :class="{'bg-primary-50 text-primary border-l-2 border-primary': $page.url.startsWith('/admin/product')}"
                    >
                        <div class="p-1.5 rounded bg-surface border border-outline-variant group-hover:bg-white group-hover:border-primary/50 transition-colors"
                             :class="{'border-primary/30': $page.url.startsWith('/admin/product')}">
                            <svg class="w-4 h-4 text-on-surface-variant group-hover:text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <span class="ml-3">Produk</span>
                    </Link>
                </li>

                <!-- Divider -->
                <li class="pt-4">
                    <span class="px-3 text-[9px] font-bold text-on-surface-variant uppercase tracking-wider">Transaksi</span>
                </li>

                <!-- Order -->
                <li>
                    <Link :href="route('admin.order.index')"
                        class="flex items-center p-2.5 text-xs font-bold text-on-surface-variant rounded hover:bg-primary-50 hover:text-primary group transition-all"
                        :class="{'bg-primary-50 text-primary border-l-2 border-primary': $page.url.startsWith('/admin/order')}"
                    >
                        <div class="p-1.5 rounded bg-surface border border-outline-variant group-hover:bg-white group-hover:border-primary/50 transition-colors"
                             :class="{'border-primary/30': $page.url.startsWith('/admin/order')}">
                            <svg class="w-4 h-4 text-on-surface-variant group-hover:text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <span class="ml-3">Pesanan</span>
                    </Link>
                </li>

                <!-- Divider -->
                <li class="pt-4">
                    <span class="px-3 text-[9px] font-bold text-on-surface-variant uppercase tracking-wider">Manajemen User</span>
                </li>

                <!-- User -->
                <li>
                    <Link :href="route('admin.user.index')"
                        class="flex items-center p-2.5 text-xs font-bold text-on-surface-variant rounded hover:bg-primary-50 hover:text-primary group transition-all"
                        :class="{'bg-primary-50 text-primary border-l-2 border-primary': $page.url === '/admin/user/index'}"
                    >
                        <div class="p-1.5 rounded bg-surface border border-outline-variant group-hover:bg-white group-hover:border-primary/50 transition-colors"
                             :class="{'border-primary/30': $page.url === '/admin/user/index'}">
                            <svg class="w-4 h-4 text-on-surface-variant group-hover:text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <span class="ml-3">Daftar User</span>
                    </Link>
                </li>

                <!-- Alamat -->
                <li>
                    <Link :href="route('admin.user.addresses')"
                        class="flex items-center p-2.5 text-xs font-bold text-on-surface-variant rounded hover:bg-primary-50 hover:text-primary group transition-all"
                        :class="{'bg-primary-50 text-primary border-l-2 border-primary': $page.url === '/admin/user/addresses'}"
                    >
                        <div class="p-1.5 rounded bg-surface border border-outline-variant group-hover:bg-white group-hover:border-primary/50 transition-colors"
                             :class="{'border-primary/30': $page.url === '/admin/user/addresses'}">
                            <svg class="w-4 h-4 text-on-surface-variant group-hover:text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.994 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <span class="ml-3">Alamat</span>
                    </Link>
                </li>

                <!-- Transaksi -->
                <li>
                    <Link :href="route('admin.payment.index')"
                        class="flex items-center p-2.5 text-xs font-bold text-on-surface-variant rounded hover:bg-primary-50 hover:text-primary group transition-all"
                        :class="{'bg-primary-50 text-primary border-l-2 border-primary': $page.url.startsWith('/admin/payment')}"
                    >
                        <div class="p-1.5 rounded bg-surface border border-outline-variant group-hover:bg-white group-hover:border-primary/50 transition-colors"
                             :class="{'border-primary/30': $page.url.startsWith('/admin/payment')}">
                            <svg class="w-4 h-4 text-on-surface-variant group-hover:text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <span class="ml-3">Transaksi</span>
                    </Link>
                </li>

                <!-- Divider -->
                <li class="pt-4">
                    <span class="px-3 text-[9px] font-bold text-on-surface-variant uppercase tracking-wider">Sistem</span>
                </li>

                <!-- Setting -->
                <li>
                    <Link :href="route('admin.setting.index')"
                        class="flex items-center p-2.5 text-xs font-bold text-on-surface-variant rounded hover:bg-primary-50 hover:text-primary group transition-all"
                        :class="{'bg-primary-50 text-primary border-l-2 border-primary': $page.url.startsWith('/admin/setting')}"
                    >
                        <div class="p-1.5 rounded bg-surface border border-outline-variant group-hover:bg-white group-hover:border-primary/50 transition-colors"
                             :class="{'border-primary/30': $page.url.startsWith('/admin/setting')}">
                            <svg class="w-4 h-4 text-on-surface-variant group-hover:text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <span class="ml-3">Pengaturan</span>
                    </Link>
                </li>

                <!-- Profil Admin -->
                <li>
                    <Link :href="route('admin.profile.edit')"
                        class="flex items-center p-2.5 text-xs font-bold text-on-surface-variant rounded hover:bg-primary-50 hover:text-primary group transition-all"
                        :class="{'bg-primary-50 text-primary border-l-2 border-primary': $page.url.startsWith('/admin/profile')}"
                    >
                        <div class="p-1.5 rounded bg-surface border border-outline-variant group-hover:bg-white group-hover:border-primary/50 transition-colors"
                             :class="{'border-primary/30': $page.url.startsWith('/admin/profile')}">
                            <svg class="w-4 h-4 text-on-surface-variant group-hover:text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <span class="ml-3">Profil Saya</span>
                    </Link>
                </li>
            </ul>
        </div>

        <!-- Bottom Section - Fixed at bottom -->
        <div class="flex-shrink-0 p-4 bg-white border-t border-outline-variant">
            <Link :href="route('home')" target="_blank"
                class="flex items-center p-2.5 text-xs font-bold text-on-surface-variant rounded hover:bg-primary-50 hover:text-primary group transition-all">
                <div class="p-1.5 rounded bg-surface border border-outline-variant group-hover:border-primary/50 group-hover:bg-white transition-colors">
                    <svg class="w-4 h-4 text-on-surface-variant group-hover:text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </div>
                <span class="ml-3 font-bold uppercase tracking-wider text-on-surface-variant group-hover:text-primary transition-colors">Lihat Toko</span>
            </Link>
        </div>
    </aside>
</template>
