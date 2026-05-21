<script setup>
import App from "@/Layouts/App.vue";
import {computed, reactive, ref} from "vue";
import {Head, router, usePage, Link} from "@inertiajs/vue3";
import {ElNotification} from "element-plus";
import Swal from "sweetalert2";
import CartItem from "./components/CartItem.vue";
import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue';

const carts = computed(() => usePage().props.carts)
const total = computed(() => usePage().props.total)
const shippings = computed(() => usePage().props.shippings)

defineProps({
    userAddress: Object,
    provinces: Object
})

const reduceQuantity = async (item) => {
    if (item.quantity === 1) {
        return;
    }
    try {
        await router.patch(route('cart.update', item.product_id), {
            quantity: item.quantity - 1,
        }, {
            preserveScroll: true,
            onSuccess: page => {
                ElNotification({
                    title: 'Berhasil',
                    message: page.props.flash.success,
                    type: 'success',
                })
            },
        });
    } catch (err) {
        alert(err)
    }
};

const addQuantity = async (item) => {
    try {
        await router.patch(route('cart.update', item.product_id), {
            quantity: item.quantity + 1,
        }, {
            preserveScroll: true,
            onSuccess: page => {
                ElNotification({
                    title: 'Berhasil',
                    message: page.props.flash.success,
                    type: 'success',
                })
            },
        });
    } catch (err) {
        alert(err)
    }
};

const deleteProduct = (product) => {
    Swal.fire({
        title: 'Hapus Item?',
        text: "Item ini akan dikeluarkan dari keranjang belanja Anda.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#0F172A',
        cancelButtonColor: '#EF4444',
        cancelButtonText: 'Batal',
        confirmButtonText: 'Ya, Hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            try {
                router.delete(route('cart.delete', product), {
                    preserveScroll: true,
                    onSuccess: (page) => {
                        Swal.fire({
                            toast: true,
                            icon: "success",
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 2000,
                            title: page.props.flash.success
                        });
                    }
                })
            } catch (err) {
                console.log(err)
            }
        }
    })
}

const form = reactive({
    shipping: null,
})

const shippingPrice = computed(() => {
    if (!form.shipping) return 0;
    const parts = form.shipping.split('-');
    return Number(parts[parts.length - 1]) || 0;
})

const grandTotal = computed(() => {
    return Number(total.value || 0) + shippingPrice.value;
})

function submit() {
    router.visit(route('checkout.store'), {
        method: 'post',
        data: {
            items: form
        },
        onSuccess: page => {
            ElNotification({
                title: 'Berhasil',
                message: page.props.flash.success,
                type: 'success',
            })
        },
    })
}

const isAddItem = ref(false);
const dialogVisible = ref(false);

//form data address
const type = ref('');
const address1 = ref('');
const no_hp = ref('');
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
    dialogVisible.value = true;
    prov_id.value = null;
    cities.value = [];
}

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
        await router.post('address', formData, {
            onSuccess: page => {
                ElNotification({
                    title: 'Berhasil',
                    message: page.props.flash.success,
                    type: 'success',
                })
                dialogVisible.value = false;
            },
        })
    } catch (err) {
        console.log(err)
    }
}
</script>

<template>
    <App>
        <Head title="Keranjang Belanja" />
        
        <div class="bg-surface min-h-screen pt-20 pb-20">
            <!-- Header Minimalis -->
            <div class="max-w-[1440px] mx-auto px-margin-desktop mb-8">
                <h1 class="text-2xl font-bold text-on-surface mb-2">Keranjang Belanja</h1>
                <p class="text-sm text-on-surface-variant max-w-2xl">Tinjau estimasi kargo pengiriman, atur alamat bongkar muat proyek, dan selesaikan transaksi invoice Anda.</p>
            </div>

            <div class="max-w-[1440px] mx-auto px-margin-desktop relative z-10">
                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- Left: Cart Items manifest -->
                    <div class="w-full lg:w-2/3 space-y-6">
                        <div class="bg-white border border-outline-variant rounded overflow-hidden shadow-none">
                            <div class="p-5 border-b border-outline-variant flex justify-between items-center bg-white">
                                <h2 class="text-sm font-bold text-on-surface flex items-center gap-2 uppercase tracking-wider">
                                    <span class="material-symbols-outlined text-primary text-xl">shopping_cart</span>
                                    Daftar Belanja
                                </h2>
                                <span class="px-2 py-0.5 bg-primary text-white rounded text-xs font-bold uppercase tracking-wider">
                                    {{ carts ? carts.length : 0 }} Item
                                </span>
                            </div>

                            <div class="divide-y divide-outline-variant">
                                <div v-if="carts && carts.length > 0">
                                    <CartItem 
                                        v-for="(item, index) in carts" 
                                        :key="index" 
                                        :item="item" 
                                        @add-quantity="addQuantity" 
                                        @reduce-quantity="reduceQuantity" 
                                        @delete-product="deleteProduct" 
                                    />
                                </div>

                                <!-- Empty Cart screen -->
                                <div v-else class="p-16 text-center">
                                    <div class="w-12 h-12 bg-surface border border-outline-variant rounded flex items-center justify-center mx-auto mb-4 text-on-surface-variant">
                                        <span class="material-symbols-outlined text-2xl">shopping_cart</span>
                                    </div>
                                    <h3 class="text-sm font-bold text-on-surface mb-2 uppercase tracking-wider">Keranjang Anda Kosong</h3>
                                    <p class="text-xs text-on-surface-variant mb-6 max-w-sm mx-auto">Anda belum memasukkan material apapun ke dalam keranjang logistik Anda.</p>
                                    <Link :href="route('product.index')" class="pk-btn-accent py-3 px-6 text-xs gap-2">
                                        <span>Jelajahi Produk SNI</span>
                                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Cargo and Invoice summary -->
                    <div class="w-full lg:w-1/3">
                        <div class="bg-white border border-outline-variant rounded p-6 lg:p-8 sticky top-24 shadow-none">
                            <h2 class="text-sm font-bold text-on-surface mb-6 uppercase tracking-wider border-b border-outline-variant pb-3">Ringkasan Invoice</h2>
                            
                            <!-- Address Block -->
                            <div class="mb-6">
                                <div class="flex justify-between items-center mb-3">
                                    <h3 class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Alamat Bongkar Proyek</h3>
                                    <button v-if="userAddress" @click="openAddModal" class="text-xs font-bold text-primary hover:underline uppercase tracking-wider">Ubah Alamat</button>
                                </div>
                                
                                <div v-if="userAddress" class="bg-surface p-4 rounded border border-outline-variant">
                                    <div class="flex gap-2.5 items-start">
                                        <span class="material-symbols-outlined text-primary mt-0.5 text-base">location_on</span>
                                        <div>
                                            <p class="text-xs font-bold text-on-surface mb-1 leading-normal">{{ userAddress.address1 }}</p>
                                            <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">{{ userAddress.city }}, {{ userAddress.postcode }}</p>
                                        </div>
                                    </div>
                                </div>
                                <button v-else @click="openAddModal" class="w-full flex items-center justify-center gap-2 p-5 border border-dashed border-outline-variant hover:border-primary rounded text-on-surface-variant hover:text-primary transition-all bg-white font-bold text-xs uppercase tracking-wider group">
                                    <span class="material-symbols-outlined text-base">add_location_alt</span>
                                    <span>Tambah Alamat Proyek</span>
                                </button>
                            </div>

                            <!-- Shipping Method -->
                            <div v-if="userAddress" class="mb-6">
                                <h3 class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-3">Tarif Kargo Pengiriman</h3>
                                <div class="space-y-2">
                                    <div v-for="(ship, index) in shippings" :key="index" class="relative">
                                        <input class="peer hidden" v-model="form.shipping" :value="`${ship.name}-${ship.type}-${ship.price}`" :id="'radio_' + index" type="radio" name="radio" required />
                                        <label :for="'radio_' + index" class="flex items-center gap-3 p-3 border border-outline-variant rounded cursor-pointer hover:bg-surface peer-checked:border-primary peer-checked:bg-primary/[0.04] transition-all">
                                            <div class="w-8 h-8 bg-surface rounded flex items-center justify-center text-on-surface-variant border border-outline-variant flex-shrink-0">
                                                <span class="material-symbols-outlined text-lg">local_shipping</span>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-xs font-bold text-on-surface capitalize leading-none mb-1">{{ ship.name }} ({{ ship.type }})</p>
                                                <p class="text-xs font-bold text-primary">Rp {{ Number(ship.price).toLocaleString() }}</p>
                                            </div>
                                            <div class="w-4 h-4 rounded-full border border-outline-variant flex items-center justify-center">
                                                <div class="w-2 h-2 bg-primary rounded-full opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Subtotal and Grand total -->
                            <div class="border-t border-dashed border-outline-variant pt-5 mb-6">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-xs font-bold text-on-surface-variant uppercase">Subtotal Material</span>
                                    <span class="text-on-surface font-bold text-sm">Rp {{ Number(total || 0).toLocaleString() }}</span>
                                </div>
                                <div v-if="shippingPrice > 0" class="flex justify-between items-center mb-2">
                                    <span class="text-xs font-bold text-on-surface-variant uppercase">Ongkos Kirim Kargo</span>
                                    <span class="text-on-surface font-bold text-sm">Rp {{ shippingPrice.toLocaleString() }}</span>
                                </div>
                                <div class="flex justify-between items-center text-base font-bold tracking-wider pt-2 border-t border-outline-variant">
                                    <span class="text-on-surface uppercase">Total Bayar</span>
                                    <span class="text-primary">Rp {{ grandTotal.toLocaleString() }}</span>
                                </div>
                            </div>

                            <!-- Actions submit -->
                            <form @submit.prevent="submit" class="space-y-4">
                                <button v-if="carts && carts.length > 0 && userAddress" type="submit" class="w-full pk-btn-accent flex items-center justify-center gap-2">
                                    <span>Lanjut Ke Pembayaran</span>
                                    <span class="material-symbols-outlined text-sm">payments</span>
                                </button>
                                <div v-else-if="!userAddress" class="p-4 bg-primary/10 rounded border border-primary/20 flex gap-2.5 items-start">
                                    <span class="material-symbols-outlined text-primary text-base">warning</span>
                                    <p class="text-xs text-primary font-bold uppercase tracking-wider leading-relaxed">
                                        Silakan lengkapi Alamat Bongkar Proyek di atas terlebih dahulu untuk memproses tarif kargo kurir RajaOngkir.
                                    </p>
                                </div>
                                
                                <Link :href="route('product.index')" class="w-full inline-flex items-center justify-center py-2 text-xs font-bold text-on-surface-variant hover:text-primary transition-colors uppercase tracking-wider">
                                    &larr; Tambah Belanjaan Lain
                                </Link>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Address Modal dialog using Headless UI -->
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
                                        <span class="material-symbols-outlined text-primary text-xl">add_road</span>
                                        <h3 class="text-sm font-bold text-on-surface uppercase tracking-wider">Tambah Alamat Baru</h3>
                                    </div>
                                    <form @submit.prevent="AddAddress()" class="space-y-4">
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
