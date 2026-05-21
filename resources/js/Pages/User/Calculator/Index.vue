<script setup>
import App from "@/Layouts/App.vue";
import { Head } from "@inertiajs/vue3";
import { ref, computed } from "vue";
import axios from "axios";

const activeTab = ref('cat');
const result = ref(null);
const loading = ref(false);

const forms = {
    cat: { luas_dinding: '', jumlah_coating: 2 },
    cement: { luas_area: '', ketebalan: '' },
    brick: { luas_dinding: '' },
    steel: { luas_lantai: '', jenis: 'plat' },
    roof: { luas_atap: '', material: 'genteng' },
};

const currentForm = ref({ ...forms.cat });

const calculate = async () => {
    loading.value = true;
    result.value = null;
    try {
        const response = await axios.post(route('calculator.calculate'), {
            type: activeTab.value,
            ...currentForm.value
        });
        result.value = response.data;
    } catch (error) {
        console.error(error);
        alert('Terjadi kesalahan saat menghitung');
    } finally {
        loading.value = false;
    }
};

const selectTab = (tab) => {
    activeTab.value = tab;
    currentForm.value = { ...forms[tab] };
    result.value = null;
};

const tabLabels = {
    cat: { label: 'Cat Tembok', icon: 'brush' },
    cement: { label: 'Semen & Pasir', icon: 'architecture' },
    brick: { label: 'Dinding Bata', icon: 'grid_view' },
    steel: { label: 'Besi Beton', icon: 'rebase_edit' },
    roof: { label: 'Atap Genteng', icon: 'roofing' },
};

const activeIcon = computed(() => tabLabels[activeTab.value].icon);
</script>

<template>
    <App>
        <Head title="Kalkulator Kebutuhan Material" />
        
        <div class="bg-surface min-h-screen pt-20 pb-24 relative overflow-hidden">
            <!-- Header Minimalis -->
            <div class="max-w-[1440px] mx-auto px-margin-desktop mb-8">
                <h1 class="text-2xl font-bold text-on-surface mb-2">Kalkulator Material</h1>
                <p class="text-sm text-on-surface-variant max-w-2xl">Hitung estimasi volume kebutuhan material konstruksi Anda dengan akurasi tinggi berdasarkan standar teknis pekerjaan bangunan.</p>
            </div>

            <div class="max-w-[1440px] mx-auto px-margin-desktop relative z-10">

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                    <!-- Sidebar: Tabs -->
                    <div class="lg:col-span-4 space-y-6">
                        <div class="bg-white border border-outline-variant rounded p-5 sticky top-28 shadow-none">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-4">Pilih Jenis Pekerjaan</h3>
                            <div class="flex flex-col gap-3">
                                <button 
                                    v-for="(info, tab) in tabLabels"
                                    :key="tab"
                                    @click="selectTab(tab)"
                                    :class="[
                                        'w-full px-4 py-3 rounded font-bold text-xs uppercase tracking-wider transition-all flex items-center gap-3 border',
                                        activeTab === tab 
                                            ? 'bg-primary border-primary text-white -translate-x-1 shadow-none' 
                                            : 'bg-white border-outline-variant text-on-surface-variant hover:border-primary hover:text-primary'
                                    ]"
                                >
                                    <span class="material-symbols-outlined text-xl" :class="activeTab === tab ? 'text-white' : 'text-on-surface-variant'">
                                        {{ info.icon }}
                                    </span>
                                    {{ info.label }}
                                </button>
                            </div>
                        </div>

                        <!-- Trust Badge -->
                        <div class="bg-primary bg-gradient-to-br from-primary to-primary-600 border border-primary-600 rounded p-6 text-white relative overflow-hidden group">
                            <div class="relative z-10">
                                <span class="material-symbols-outlined text-primary text-3xl mb-3">verified</span>
                                <h4 class="font-bold text-base mb-1.5">Akurasi SNI</h4>
                                <p class="text-xs text-white/70 font-medium leading-relaxed">Algoritma perhitungan kami disesuaikan dengan Standar Nasional Indonesia untuk meminimalisir pembuangan material.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Main: Form & Result -->
                    <div class="lg:col-span-8 space-y-6">
                        <!-- Form Panel -->
                        <div class="bg-white border border-outline-variant rounded overflow-hidden shadow-none">
                            <div class="p-6 border-b border-outline-variant bg-white flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-primary text-white rounded flex items-center justify-center">
                                        <span class="material-symbols-outlined text-xl">{{ activeIcon }}</span>
                                    </div>
                                    <div>
                                        <h2 class="text-base font-bold text-on-surface uppercase tracking-wider">Formulasi {{ tabLabels[activeTab].label }}</h2>
                                        <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Masukkan dimensi pengerjaan Anda</p>
                                    </div>
                                </div>
                            </div>

                            <div class="p-6">
                                <form @submit.prevent="calculate" class="space-y-6">
                                    <!-- Dynamic Inputs based on activeTab -->
                                    <div v-if="activeTab === 'cat'" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="space-y-2">
                                            <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant ml-1">Luas Dinding (m²)</label>
                                            <div class="relative">
                                                <input type="number" v-model="currentForm.luas_dinding" class="w-full border border-outline-variant rounded pl-10 pr-3 py-2 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none" placeholder="0.00" required />
                                                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 material-symbols-outlined text-on-surface-variant text-base">square_foot</span>
                                            </div>
                                        </div>
                                        <div class="space-y-2">
                                            <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant ml-1">Jumlah Lapisan</label>
                                            <select v-model="currentForm.jumlah_coating" class="w-full border border-outline-variant rounded px-3 py-2 text-sm bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                                                <option :value="1">1 Lapis (Tipis)</option>
                                                <option :value="2">2 Lapis (Standar)</option>
                                                <option :value="3">3 Lapis (Tebal)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div v-if="activeTab === 'cement'" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="space-y-2">
                                            <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant ml-1">Luas Area (m²)</label>
                                            <div class="relative">
                                                <input type="number" v-model="currentForm.luas_area" class="w-full border border-outline-variant rounded pl-10 pr-3 py-2 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none" placeholder="0.00" required />
                                                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 material-symbols-outlined text-on-surface-variant text-base">straighten</span>
                                            </div>
                                        </div>
                                        <div class="space-y-2">
                                            <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant ml-1">Ketebalan Spesi (cm)</label>
                                            <div class="relative">
                                                <input type="number" v-model="currentForm.ketebalan" class="w-full border border-outline-variant rounded pl-10 pr-3 py-2 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none" placeholder="Contoh: 2" required />
                                                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 material-symbols-outlined text-on-surface-variant text-base">height</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div v-if="activeTab === 'brick'" class="space-y-2">
                                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant ml-1">Luas Dinding (m²)</label>
                                        <div class="relative">
                                            <input type="number" v-model="currentForm.luas_dinding" class="w-full border border-outline-variant rounded pl-10 pr-3 py-2 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none" placeholder="0.00" required />
                                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 material-symbols-outlined text-on-surface-variant text-base">grid_view</span>
                                        </div>
                                    </div>

                                    <div v-if="activeTab === 'steel'" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="space-y-2">
                                            <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant ml-1">Luas Lantai (m²)</label>
                                            <div class="relative">
                                                <input type="number" v-model="currentForm.luas_lantai" class="w-full border border-outline-variant rounded pl-10 pr-3 py-2 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none" placeholder="0.00" required />
                                                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 material-symbols-outlined text-on-surface-variant text-base">layers</span>
                                            </div>
                                        </div>
                                        <div class="space-y-2">
                                            <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant ml-1">Tipe Konstruksi</label>
                                            <select v-model="currentForm.jenis" class="w-full border border-outline-variant rounded px-3 py-2 text-sm bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                                                <option value="plat">Plat Dak Lantai</option>
                                                <option value="pondasi">Pondasi Cakar Ayam</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div v-if="activeTab === 'roof'" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="space-y-2">
                                            <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant ml-1">Luas Atap (m²)</label>
                                            <div class="relative">
                                                <input type="number" v-model="currentForm.luas_atap" class="w-full border border-outline-variant rounded pl-10 pr-3 py-2 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none" placeholder="0.00" required />
                                                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 material-symbols-outlined text-on-surface-variant text-base">roofing</span>
                                            </div>
                                        </div>
                                        <div class="space-y-2">
                                            <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant ml-1">Jenis Penutup</label>
                                            <select v-model="currentForm.material" class="w-full border border-outline-variant rounded px-3 py-2 text-sm bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                                                <option value="genteng">Genteng Tanah Liat</option>
                                                <option value="asbes">Asbes / Seng</option>
                                                <option value="spandek">Spandek Baja Ringan</option>
                                            </select>
                                        </div>
                                    </div>

                                    <button type="submit" :disabled="loading" class="pk-btn-accent w-full py-3.5 rounded text-xs font-bold uppercase tracking-wider">
                                        <span v-if="!loading" class="flex items-center justify-center gap-2">
                                            Mulai Kalkulasi Akurat
                                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                        </span>
                                        <span v-else class="flex items-center justify-center gap-3">
                                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            Memproses Data...
                                        </span>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Result Section -->
                        <Transition
                            enter-active-class="transition duration-500 ease-out"
                            enter-from-class="transform translate-y-8 opacity-0"
                            enter-to-class="transform translate-y-0 opacity-100"
                        >
                            <div v-if="result" class="space-y-4">
                                <div class="bg-primary bg-gradient-to-br from-primary to-primary-600 border border-primary-600 p-6 md:p-8 rounded relative overflow-hidden group shadow-none">
                                    <div class="relative z-10">
                                        <div class="flex items-center gap-3 mb-6">
                                            <div class="w-8 h-8 bg-primary/20 text-primary rounded-full flex items-center justify-center">
                                                <span class="material-symbols-outlined text-base">analytics</span>
                                            </div>
                                            <h3 class="text-xs font-bold uppercase tracking-wider text-white">Laporan Estimasi Material</h3>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                            <div v-for="(val, key) in result.output" :key="key" class="bg-white/5 p-4 rounded border border-white/10 hover:border-primary/30 transition-all">
                                                <p class="text-xs font-bold text-white/70 uppercase tracking-wider mb-2">{{ key.replace(/_/g, ' ') }}</p>
                                                <div class="flex items-baseline gap-2">
                                                    <span class="text-xl font-bold text-white">{{ val }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="bg-primary/10 border border-primary/20 p-4 rounded">
                                            <div class="flex gap-3">
                                                <span class="material-symbols-outlined text-primary text-lg">info</span>
                                                <p class="text-xs text-white/80 font-medium leading-relaxed">
                                                    <strong class="text-white block mb-0.5">Catatan Logistik:</strong>
                                                    Estimasi di atas sudah termasuk faktor pembuangan (wastage factor) sebesar 5-10% sesuai standar pengerjaan konstruksi lapangan.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action CTA -->
                                <div class="flex flex-col md:flex-row gap-4">
                                    <Link :href="route('product.index')" class="pk-btn-accent flex-1 py-3 text-center rounded justify-center">Cari Produk Terkait</Link>
                                    <button @click="result = null" class="w-full md:w-auto px-6 py-3 border border-outline-variant rounded font-bold text-xs uppercase tracking-wider hover:border-primary hover:text-primary transition-all bg-white text-on-surface">Hitung Ulang</button>
                                </div>
                            </div>
                        </Transition>
                    </div>
                </div>
            </div>
        </div>
    </App>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0');

/* Custom scrollbar for sidebar on mobile */
::-webkit-scrollbar {
    height: 4px;
}
</style>