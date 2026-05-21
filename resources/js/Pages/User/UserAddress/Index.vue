<script setup>
import Pagination from "@/Components/Pagination.vue";
import {Head, router, usePage} from "@inertiajs/vue3";
import {ref, watch, computed} from "vue";
import {ElNotification} from "element-plus";
import App from "@/Layouts/App.vue";
import Swal from "sweetalert2";
import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue';

const address = computed(() => usePage().props.address)
const provinces = usePage().props.provinces;

const searchValue = usePage().props.search;
const isAddItem = ref(false);
const isEditItem = ref(false);
const dialogVisible = ref(false);

//form data address
const id = ref('');
const type = ref('');
const address1 = ref('');
const no_hp = ref('');
const city = ref('');
const isMain = ref(false);
const postcode = ref('');
const country_code = ref('ID');
const city_id = ref('');
const prov_id = ref(null);
const cities = ref([]);

const getCityByProvince = async () => {
    if (!prov_id.value) return;
    try {
        const response = await fetch(`/address/city/${prov_id.value}`);
        const data = await response.json();
        cities.value = data.data;
    } catch (error) {
        console.error(error);
    }
}

const openAddModal = () => {
    isAddItem.value = true;
    isEditItem.value = false;
    dialogVisible.value = true;

    prov_id.value = null;
    cities.value = [];
    resetFormData();
}

const openEditModal = async (item) => {
    id.value = item.id;
    type.value = item.type;
    address1.value = item.address1;
    no_hp.value = item.no_hp;
    city.value = item.city;
    prov_id.value = item.prov_id;
    isMain.value = item.isMain;
    postcode.value = item.postcode;
    country_code.value = item.country_code;
    city_id.value = item.city_id;

    isEditItem.value = true;
    isAddItem.value = false;
    dialogVisible.value = true;

    if (prov_id.value) {
        await getCityByProvince();
    }
}

//search
const search = ref(searchValue);
watch(search, (value) => {
    router.get(
        "/address",
        {search: value},
        {preserveState: true}
    );
});

//add address
const AddAddress = async () => {
    const formData = new FormData();
    formData.append('address1', address1.value);
    formData.append('no_hp', no_hp.value);
    formData.append('prov_id', prov_id.value);
    formData.append('city_id', city_id.value);
    formData.append('postcode', postcode.value);
    formData.append('country_code', country_code.value);
    formData.append('isMain', isMain.value);
    formData.append('type', type.value);

    try {
        await router.post('address/store', formData, {
            onSuccess: page => {
                ElNotification({
                    title: 'Berhasil',
                    message: page.props.flash.success,
                    type: 'success',
                })
                dialogVisible.value = false;
                resetFormData();
            },
        })
    } catch (err) {
        console.log(err)
    }
}

const updateAddress = async () => {
    const formData = new FormData();
    formData.append('address1', address1.value);
    formData.append('no_hp', no_hp.value);
    formData.append('prov_id', prov_id.value);
    formData.append('city_id', city_id.value);
    formData.append('postcode', postcode.value);
    formData.append('country_code', country_code.value);
    formData.append('isMain', isMain.value);
    formData.append('type', type.value);
    formData.append("_method", 'PUT');

    try {
        await router.post('address/update/' + id.value, formData, {
            onSuccess: (page) => {
                dialogVisible.value = false;
                resetFormData();
                ElNotification({
                    title: 'Berhasil',
                    message: page.props.flash.success,
                    type: 'success',
                })
            }
        })
    } catch (err) {
        console.log(err)
    }
}

const deleteAddress = (item) => {
    Swal.fire({
        title: 'Hapus Alamat?',
        text: "Alamat ini akan dihapus permanen dari daftar Anda.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#0F172A',
        cancelButtonColor: '#EF4444',
        cancelButtonText: 'Batal',
        confirmButtonText: 'Ya, Hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            try {
                router.delete('address/delete/' + item.id, {
                    onSuccess: (page) => {
                        ElNotification({
                            title: 'Berhasil',
                            message: page.props.flash.success,
                            type: 'success',
                        })
                    }
                })
            } catch (err) {
                console.log(err)
            }
        }
    })
}

const resetFormData = () => {
    id.value = '';
    type.value = '';
    address1.value = '';
    no_hp.value = '';
    city.value = '';
    prov_id.value = '';
    isMain.value = false;
    postcode.value = '';
    country_code.value = 'ID';
    city_id.value = '';
};
</script>

<template>
    <App>
        <Head title="Daftar Alamat Pengiriman" />
        
        <div class="bg-surface min-h-screen pt-20 pb-20">
            <!-- Header Minimalis -->
            <div class="max-w-[1440px] mx-auto px-margin-desktop mb-8">
                <h1 class="text-2xl font-bold text-on-surface mb-2">Daftar Alamat</h1>
                <p class="text-sm text-on-surface-variant max-w-2xl">Kelola berbagai destinasi pengantaran material, alamat kantor kontraktor, dan set lokasi bongkar muat utama Anda.</p>
            </div>

            <div class="max-w-[1440px] mx-auto px-margin-desktop mt-8 relative z-10">
                <div class="bg-white border border-outline-variant rounded overflow-hidden shadow-none">
                    <!-- Actions Row -->
                    <div class="p-6 border-b border-outline-variant flex flex-col md:flex-row justify-between items-center gap-4 bg-white">
                        <div class="w-full md:w-1/3 relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-on-surface-variant">
                                <span class="material-symbols-outlined text-base">search</span>
                            </span>
                            <input type="text" v-model.lazy="search" class="w-full border border-outline-variant rounded pl-11 pr-4 py-2 text-xs focus:border-primary focus:ring-1 focus:ring-primary outline-none" placeholder="Cari alamat proyek..." />
                        </div>
                        <button @click="openAddModal" class="w-full md:w-auto pk-btn-accent gap-2">
                            <span class="material-symbols-outlined text-sm">add_location</span>
                            Tambah Alamat Proyek
                        </button>
                    </div>

                    <!-- Address Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-surface text-on-surface-variant text-xs font-bold uppercase tracking-wider border-b border-outline-variant">
                                <tr>
                                    <th class="px-6 py-4">No.</th>
                                    <th class="px-6 py-4">Detail Lokasi Proyek</th>
                                    <th class="px-6 py-4">Kota & Provinsi</th>
                                    <th class="px-6 py-4">Tipe Label</th>
                                    <th class="px-6 py-4 text-right font-bold">Kelola</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-outline-variant">
                                <tr v-for="(item, index) in address.data" :key="item.id" class="hover:bg-surface bg-white transition-colors">
                                    <td class="px-6 py-5 text-xs text-on-surface-variant font-bold">{{ index + 1 }}</td>
                                    <td class="px-6 py-5">
                                        <div class="font-bold text-sm text-on-surface mb-1.5 leading-snug">{{ item.address1 }}</div>
                                        <div class="text-xs text-on-surface-variant flex items-center gap-1.5 uppercase font-bold">
                                            <span class="material-symbols-outlined text-sm">phone_iphone</span>
                                            {{ item.no_hp }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="text-xs font-bold text-on-surface leading-normal">{{ item.city }}, {{ item.province }}</div>
                                        <div class="text-xs text-on-surface-variant mt-1 uppercase tracking-wider">Kodepos: {{ item.postcode }}</div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex flex-col gap-1.5 w-fit">
                                            <span class="inline-flex w-fit px-2 py-0.5 bg-surface text-on-surface-variant text-xs font-bold border border-outline-variant uppercase rounded tracking-wider">{{ item.type }}</span>
                                            <span v-if="item.isMain" class="inline-block px-2 py-0.5 text-xs font-bold bg-primary/10 text-primary border border-primary/20 rounded uppercase tracking-wider w-fit">Alamat Utama</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-right">
                                        <div class="flex justify-end gap-1">
                                            <button @click="openEditModal(item)" class="p-1.5 text-on-surface-variant hover:text-primary hover:bg-surface rounded transition-colors" aria-label="Edit Alamat">
                                                <span class="material-symbols-outlined text-base">edit</span>
                                            </button>
                                            <button @click="deleteAddress(item)" class="p-1.5 text-on-surface-variant hover:text-red-650 hover:bg-red-50 rounded transition-colors" aria-label="Hapus Alamat">
                                                <span class="material-symbols-outlined text-base">delete</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="!address.data.length">
                                    <td colspan="5" class="py-16 text-center">
                                        <div class="w-12 h-12 bg-surface border border-outline-variant rounded flex items-center justify-center mx-auto mb-4 text-on-surface-variant">
                                            <span class="material-symbols-outlined text-2xl">location_off</span>
                                        </div>
                                        <p class="text-xs text-on-surface-variant font-bold uppercase tracking-wider">Belum ada daftar alamat tersimpan</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="p-5 border-t border-outline-variant bg-surface">
                        <Pagination :data="address" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Address Modal Dialog using Headless UI -->
        <TransitionRoot as="template" :show="dialogVisible">
            <Dialog as="div" class="relative z-50" @close="dialogVisible = false">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                    <div class="fixed inset-0 bg-black bg-opacity-40 transition-opacity" />
                </TransitionChild>

                <div class="fixed inset-0 z-50 overflow-y-auto">
                    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                        <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                            <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-outline-variant">
                                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                    <div class="flex items-center gap-2 border-b border-outline-variant pb-3 mb-4">
                                        <span class="material-symbols-outlined text-primary text-xl">location_on</span>
                                        <h3 class="text-sm font-bold text-on-surface uppercase tracking-wider">
                                            {{ isEditItem ? 'Perbarui Alamat Proyek' : 'Tambah Alamat Proyek' }}
                                        </h3>
                                    </div>
                                    <form @submit.prevent="isEditItem ? updateAddress() : AddAddress()" class="space-y-4">
                                        <div>
                                            <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-1">Alamat Jalan & Nomor Rumah</label>
                                            <input type="text" v-model="address1" class="w-full border border-outline-variant rounded px-3 py-2 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none" placeholder="Nama Jalan, No. Proyek" required />
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-1">Provinsi Pengantaran</label>
                                                <select v-model="prov_id" @change="getCityByProvince" class="w-full border border-outline-variant rounded px-3 py-2 text-sm bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none" required>
                                                    <option :value="null" disabled>Pilih Provinsi</option>
                                                    <option v-for="(prov, idx) in provinces" :key="idx" :value="prov.province_id">{{ prov.province }}</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-1">Kota / Kabupaten</label>
                                                <select v-model="city_id" :disabled="!prov_id" class="w-full border border-outline-variant rounded px-3 py-2 text-sm bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none" required>
                                                    <option value="" disabled>Pilih Kota</option>
                                                    <option v-for="(city, idx) in cities" :key="idx" :value="city.city_id">{{ city.city_name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-1">Kode Pos</label>
                                                <input type="text" v-model="postcode" class="w-full border border-outline-variant rounded px-3 py-2 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none" placeholder="12345" required />
                                            </div>
                                            <div>
                                                <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-1">Nomor Telepon Seluler</label>
                                                <input type="text" v-model="no_hp" class="w-full border border-outline-variant rounded px-3 py-2 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none" placeholder="08xxxxxxxx" required />
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-1">Label Lokasi</label>
                                                <select v-model="type" class="w-full border border-outline-variant rounded px-3 py-2 text-sm bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none" required>
                                                    <option value="" disabled>Label</option>
                                                    <option value="home">Rumah</option>
                                                    <option value="office">Kantor</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-1">Set Utama</label>
                                                <select v-model="isMain" class="w-full border border-outline-variant rounded px-3 py-2 text-sm bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none" required>
                                                    <option :value="true">Ya</option>
                                                    <option :value="false">Tidak</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="flex gap-3 pt-4 border-t border-outline-variant">
                                            <button type="button" @click="dialogVisible = false" class="flex-1 py-2.5 border border-outline-variant text-on-surface font-bold text-xs uppercase tracking-wider rounded hover:bg-surface transition-all">Batal</button>
                                            <button type="submit" class="flex-1 py-2.5 bg-primary text-white font-bold text-xs uppercase tracking-wider rounded hover:bg-opacity-95 shadow transition-all">Simpan Alamat</button>
                                        </div>
                                    </form>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </App>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0');
</style>
