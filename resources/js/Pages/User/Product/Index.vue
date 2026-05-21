<script setup>
import App from "@/Layouts/App.vue";
import {Head, router, useForm} from "@inertiajs/vue3";
import {ref, watch} from 'vue'
import {
    Dialog,
    DialogPanel,
    TransitionChild,
    TransitionRoot,
} from '@headlessui/vue'
import { XMarkIcon } from '@heroicons/vue/24/outline'
import { FunnelIcon } from '@heroicons/vue/20/solid'
import ProductList from "@/Pages/User/Product/ProductList.vue";

const props = defineProps({
    products: Object,
    categories: Object,
    brands: Object,
    selectedBrands: Array,
    selectedCategories: Array,
    selectedPrices: Object,
})

const selectedBrands = ref([...(props.selectedBrands || [])])
const selectedCategories = ref([...(props.selectedCategories || [])])

const filterPrices = useForm({
    prices: [props.selectedPrices?.from ?? 0, props.selectedPrices?.to ?? 1000000]
})

const mobileFiltersOpen = ref(false)

watch(selectedBrands, () => {
    updateFilteredProducts()
})
watch(selectedCategories, () => {
    updateFilteredProducts()
})

watch(() => props.selectedBrands, (newVal) => {
    selectedBrands.value = [...(newVal || [])]
})
watch(() => props.selectedCategories, (newVal) => {
    selectedCategories.value = [...(newVal || [])]
})
watch(() => props.selectedPrices, (newVal) => {
    if (newVal) {
        filterPrices.prices = [newVal.from, newVal.to]
    }
})

function updateFilteredProducts() {
    router.get(route('product.index'), {
        brands: selectedBrands.value,
        categories: selectedCategories.value,
        prices: {
            from: filterPrices.prices[0],
            to: filterPrices.prices[1]
        }
    }, {
        preserveState: true,
        preserveScroll: true,
        replace: true
    })
}

const priceFilter = () => {
    updateFilteredProducts()
}
</script>

<template>
    <App>
        <Head title="Katalog Material Konstruksi" />
        
        <div class="bg-surface min-h-screen pt-20">
            <!-- Header Minimalis -->
            <div class="max-w-[1440px] mx-auto px-margin-desktop mb-8">
                <h1 class="text-2xl font-bold text-on-surface mb-2">Katalog Material</h1>
                <p class="text-sm text-on-surface-variant max-w-2xl">Pilihan terlengkap semen, besi beton SNI, keramik, cat, pipa, dan kayu lapis original untuk konstruksi kokoh.</p>
            </div>

            <main class="mx-auto max-w-[1440px] px-margin-desktop py-10 relative z-10">
                <div class="flex items-baseline justify-between border-b border-outline-variant pb-4 mb-6">
                    <div>
                        <span class="text-xs font-bold text-primary uppercase tracking-wider mb-1 block">Semua Material</span>
                        <h2 class="text-lg lg:text-xl font-bold text-on-surface">Daftar Inventori</h2>
                    </div>

                    <div class="flex items-center">
                        <button type="button" class="inline-flex items-center gap-2 px-4 py-2 border border-outline-variant text-on-surface hover:border-primary rounded text-xs font-bold uppercase tracking-wider lg:hidden" @click="mobileFiltersOpen = true">
                            <FunnelIcon class="h-4 w-4" aria-hidden="true" />
                            Filter
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-lg pt-4">
                    <!-- Desktop Sidebar Filters -->
                    <aside class="hidden lg:block lg:col-span-3 space-y-6">
                        
                        <!-- Price Filter -->
                        <div class="bg-white border border-outline-variant rounded p-5 shadow-none">
                            <h3 class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-4">Rentang Harga</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="text-xs font-bold text-on-surface-variant uppercase">Minimal (Rp)</label>
                                    <input type="number" v-model="filterPrices.prices[0]" class="w-full mt-1 border border-outline-variant rounded px-3 py-2 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none" placeholder="0" />
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-on-surface-variant uppercase">Maksimal (Rp)</label>
                                    <input type="number" v-model="filterPrices.prices[1]" class="w-full mt-1 border border-outline-variant rounded px-3 py-2 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none" placeholder="1.000.000" />
                                </div>
                                <button @click="priceFilter()" class="w-full pk-btn-accent py-2 text-xs font-bold uppercase tracking-wider rounded">
                                    Terapkan Filter
                                </button>
                            </div>
                        </div>

                        <!-- Brand Filter -->
                        <div class="bg-white border border-outline-variant rounded p-5 shadow-none">
                            <h3 class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-4">Pabrikan / Brand</h3>
                            <div class="space-y-3 max-h-60 overflow-y-auto pr-2">
                                <div v-for="brand in brands" :key="brand.id" class="flex items-center">
                                    <input :id="`brand-${brand.id}`" :value="brand.id" v-model="selectedBrands" type="checkbox" class="h-4 w-4 rounded border-outline-variant text-primary focus:ring-primary cursor-pointer" />
                                    <label :for="`brand-${brand.id}`" class="ml-3 text-xs font-bold text-on-surface-variant hover:text-primary cursor-pointer transition uppercase tracking-wider">{{ brand.name }}</label>
                                </div>
                            </div>
                        </div>

                        <!-- Category Filter -->
                        <div class="bg-white border border-outline-variant rounded p-5 shadow-none">
                            <h3 class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-4">Grup Kategori</h3>
                            <div class="space-y-3 max-h-60 overflow-y-auto pr-2">
                                <div v-for="category in categories" :key="category.id" class="flex items-center">
                                    <input :id="`cat-${category.id}`" :value="category.id" v-model="selectedCategories" type="checkbox" class="h-4 w-4 rounded border-outline-variant text-primary focus:ring-primary cursor-pointer" />
                                    <label :for="`cat-${category.id}`" class="ml-3 text-xs font-bold text-on-surface-variant hover:text-primary cursor-pointer transition uppercase tracking-wider">{{ category.name }}</label>
                                </div>
                            </div>
                        </div>
                    </aside>

                    <!-- Product Grid column -->
                    <div class="lg:col-span-9">
                        <ProductList :products="products" />
                    </div>
                </div>
            </main>

            <!-- Mobile filter dialog -->
            <TransitionRoot as="template" :show="mobileFiltersOpen">
                <Dialog as="div" class="relative z-50 lg:hidden" @close="mobileFiltersOpen = false">
                    <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100" leave-to="opacity-0">
                        <div class="fixed inset-0 bg-black bg-opacity-40" />
                    </TransitionChild>

                    <div class="fixed inset-0 z-50 flex">
                        <TransitionChild as="template" enter="transition ease-in-out duration-300 transform" enter-from="translate-x-full" enter-to="translate-x-0" leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0" leave-to="translate-x-full">
                            <DialogPanel class="relative ml-auto flex h-full w-full max-w-xs flex-col overflow-y-auto bg-white py-6 pb-12 shadow-none border-l border-outline-variant">
                                <div class="flex items-center justify-between px-5 mb-6">
                                    <h2 class="text-sm font-bold text-on-surface uppercase tracking-wider">Filter Material</h2>
                                    <button type="button" class="flex h-9 w-9 items-center justify-center rounded bg-surface border border-outline-variant text-on-surface-variant hover:text-on-surface" @click="mobileFiltersOpen = false">
                                        <XMarkIcon class="h-5 w-5" aria-hidden="true" />
                                    </button>
                                </div>

                                <form class="border-t border-outline-variant px-5 py-6 space-y-6">
                                    <!-- Price -->
                                    <div>
                                        <h3 class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-4">Rentang Harga</h3>
                                        <div class="space-y-4">
                                            <input type="number" v-model="filterPrices.prices[0]" class="w-full border border-outline-variant rounded px-3 py-2 text-xs focus:border-primary focus:ring-1 focus:ring-primary outline-none" placeholder="Min" />
                                            <input type="number" v-model="filterPrices.prices[1]" class="w-full border border-outline-variant rounded px-3 py-2 text-xs focus:border-primary focus:ring-1 focus:ring-primary outline-none" placeholder="Max" />
                                            <button @click="priceFilter()" type="button" class="w-full pk-btn-accent py-2 text-xs font-bold uppercase tracking-wider rounded">Terapkan</button>
                                        </div>
                                    </div>
                                    
                                    <!-- Brands -->
                                    <div class="border-t border-outline-variant pt-6">
                                        <h3 class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-4">Brand</h3>
                                        <div class="space-y-3">
                                            <div v-for="brand in brands" :key="brand.id" class="flex items-center">
                                                <input :id="`mob-brand-${brand.id}`" :value="brand.id" v-model="selectedBrands" type="checkbox" class="h-4 w-4 rounded border-outline-variant text-primary focus:ring-primary" />
                                                <label :for="`mob-brand-${brand.id}`" class="ml-3 text-xs font-bold text-on-surface-variant uppercase tracking-wider">{{ brand.name }}</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Categories -->
                                    <div class="border-t border-outline-variant pt-6">
                                        <h3 class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-4">Kategori</h3>
                                        <div class="space-y-3">
                                            <div v-for="category in categories" :key="category.id" class="flex items-center">
                                                <input :id="`mob-cat-${category.id}`" :value="category.id" v-model="selectedCategories" type="checkbox" class="h-4 w-4 rounded border-outline-variant text-primary focus:ring-primary" />
                                                <label :for="`mob-cat-${category.id}`" class="ml-3 text-xs font-bold text-on-surface-variant uppercase tracking-wider">{{ category.name }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </Dialog>
            </TransitionRoot>
        </div>
    </App>
</template>
