<script setup>
import {ref, watch} from 'vue'
import {router, usePage} from "@inertiajs/vue3";
import {Plus, Edit, Delete, Picture, Search} from '@element-plus/icons-vue'
import {ElNotification, ElMessageBox} from 'element-plus'
import Pagination from "@/Components/Pagination.vue";

defineProps({
    products: Object,
    brands: Object,
});

const categories = usePage().props.categories;
const searchValue = usePage().props.search;
const isAddproduct = ref(false);
const isEditProduct = ref(false);
const dialogVisible = ref(false);

// Upload multiple images
const productImages = ref([])
const dialogPreviewImg = ref(false)
const dialogImageUrl = ref('')
const handleFileChange = (file) => {
    productImages.value.push(file)
}

const handlePictureCardPreview = (file) => {
    dialogImageUrl.value = file.url
    dialogPreviewImg.value = true
}

const handleRemove = (file) => {
    console.log(file)
}

// Search
const search = ref(searchValue);
watch(search, (value) => {
    router.get(
        "/admin/product/index",
        {search: value},
        {preserveState: false}
    );
});

// Form data product
const id = ref('');
const title = ref('');
const price = ref('');
const quantity = ref('');
const description = ref('');
const product_images = ref([]);
const published = ref(true);
const category_id = ref('');
const brand_id = ref('');
const inStock = ref('');
// PondasiKu: Material fields
const unit = ref('pcs');
const weight = ref('');
const min_stock = ref(10);

// Unit options for PondasiKu
const unitOptions = [
    {value: 'pcs', label: 'Pcs (Buah)'},
    {value: 'sak', label: 'Sak (Karung)'},
    {value: 'kg', label: 'Kg (Kilogram)'},
    {value: 'm', label: 'm (Meter)'},
    {value: 'm2', label: 'm² (Meter Persegi)'},
    {value: 'm3', label: 'm³ (Meter Kubik)'},
    {value: 'lbr', label: 'Lembar'},
    {value: 'btg', label: 'Batang'},
];

// Open add modal
const openAddModal = () => {
    isAddproduct.value = true;
    isEditProduct.value = false;
    published.value = true;
    dialogVisible.value = true;
}

// Add product method
const AddProduct = async () => {
    const formData = new FormData();
    formData.append('title', title.value);
    formData.append('price', price.value);
    formData.append('quantity', quantity.value);
    formData.append('description', description.value);
    formData.append('brand_id', brand_id.value);
    formData.append('category_id', category_id.value);
    formData.append('unit', unit.value);
    formData.append('weight', weight.value);
    formData.append('min_stock', min_stock.value);
    formData.append('published', published.value ? 1 : 0);
    for (const image of productImages.value) {
        formData.append('product_images[]', image.raw);
    }

    try {
        await router.post('store', formData, {
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

const resetFormData = () => {
    id.value = '';
    title.value = '';
    price.value = '';
    quantity.value = '';
    description.value = '';
    productImages.value = [];
    dialogImageUrl.value = '';
    unit.value = 'pcs';
    weight.value = '';
    min_stock.value = 10;
    published.value = true;
};

const openEditModal = (product) => {
    id.value = product.id;
    title.value = product.title;
    price.value = Number(product.price);
    quantity.value = product.quantity;
    description.value = product.description;
    brand_id.value = product.brand_id;
    category_id.value = product.category_id;
    product_images.value = product.product_images;
    unit.value = product.unit || 'pcs';
    weight.value = product.weight || '';
    min_stock.value = product.min_stock || 10;
    published.value = !!product.published;

    isEditProduct.value = true;
    isAddproduct.value = false;
    dialogVisible.value = true;
}

// Delete image from product image
const deleteImage = async (pimage, index) => {
    try {
        await router.delete('/admin/product/image/' + pimage.id, {
            onSuccess: (page) => {
                product_images.value.splice(index, 1);
                ElNotification({
                    title: 'Berhasil',
                    message: page.props.flash.success,
                    type: 'success',
                })
            }
        })
    } catch (err) {
        console.log(err);
    }
}

const updateProduct = async () => {
    const formData = new FormData();
    formData.append('title', title.value);
    formData.append('price', price.value);
    formData.append('quantity', quantity.value);
    formData.append('description', description.value);
    formData.append('category_id', category_id.value);
    formData.append('brand_id', brand_id.value);
    formData.append('unit', unit.value);
    formData.append('weight', weight.value);
    formData.append('min_stock', min_stock.value);
    formData.append('published', published.value ? 1 : 0);
    formData.append("_method", 'PUT');
    for (const image of productImages.value) {
        formData.append('product_images[]', image.raw);
    }

    try {
        await router.post('update/' + id.value, formData, {
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

// Delete product method
const deleteProduct = (product) => {
    ElMessageBox.confirm(
        'Tindakan ini tidak dapat dibatalkan. Yakin ingin menghapus produk ini?',
        'Hapus Produk',
        {
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            type: 'warning',
        }
    ).then(() => {
        try {
            router.delete('destroy/' + product.id, {
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
    }).catch(() => {
        // Cancelled
    })
}
</script>

<template>
    <div class="p-4 lg:p-6 bg-surface">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-xl lg:text-2xl font-bold text-on-surface">Produk</h1>
                    <p class="text-xs text-on-surface-variant mt-1">Kelola produk material bangunan untuk toko Anda</p>
                </div>
                <button @click="openAddModal" 
                    class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-primary text-white font-bold text-xs uppercase tracking-wider rounded hover:bg-opacity-95 shadow transition-all">
                    <el-icon :size="14"><Plus /></el-icon>
                    Tambah Produk
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
            <div class="bg-white border border-outline-variant rounded p-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-surface border border-outline-variant rounded text-on-surface-variant">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Total Produk</p>
                        <p class="text-base font-bold text-on-surface">{{ usePage().props.stats?.total || products.total }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white border border-outline-variant rounded p-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-surface border border-outline-variant rounded text-on-surface-variant">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Tersedia</p>
                        <p class="text-base font-bold text-on-surface">{{ usePage().props.stats?.tersedia || 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white border border-outline-variant rounded p-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-surface border border-outline-variant rounded text-on-surface-variant">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Dipublikasi</p>
                        <p class="text-base font-bold text-on-surface">{{ usePage().props.stats?.dipublikasi || 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white border border-outline-variant rounded p-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-surface border border-outline-variant rounded text-on-surface-variant">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Stok Terbatas</p>
                        <p class="text-base font-bold text-on-surface">{{ usePage().props.stats?.stok_terbatas || 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white border border-outline-variant rounded p-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-surface border border-outline-variant rounded text-on-surface-variant">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Stok Habis</p>
                        <p class="text-base font-bold text-on-surface">{{ usePage().props.stats?.stok_habis || 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white border border-outline-variant rounded shadow-none overflow-hidden">
            <!-- Search Bar -->
            <div class="p-4 border-b border-outline-variant">
                <div class="relative max-w-md">
                    <el-icon class="absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant/40" :size="18"><Search /></el-icon>
                    <input type="text" v-model.lazy="search" 
                        class="w-full pl-10 pr-4 py-2.5 bg-white border border-outline-variant rounded text-xs text-on-surface placeholder-on-surface-variant/40 focus:ring-1 focus:ring-primary focus:border-transparent transition-all"
                        placeholder="Cari produk...">
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-surface border-b border-outline-variant">
                        <tr>
                            <th class="px-4 py-3 text-left text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">#</th>
                            <th class="px-4 py-3 text-left text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Nama</th>
                            <th class="px-4 py-3 text-left text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Kategori</th>
                            <th class="px-4 py-3 text-left text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Brand</th>
                            <th class="px-4 py-3 text-left text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Stok</th>
                            <th class="px-4 py-3 text-left text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Satuan</th>
                            <th class="px-4 py-3 text-left text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-left text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Harga</th>
                            <th class="px-4 py-3 text-right text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant">
                        <tr v-for="(product, index) in products.data" :key="product.id" class="hover:bg-surface transition-colors">
                            <td class="px-4 py-3 text-xs text-on-surface-variant">{{ index + 1 }}</td>
                            <td class="px-4 py-3">
                                <span class="text-xs font-bold text-on-surface">{{ product.title }}</span>
                            </td>
                            <td class="px-4 py-3 text-xs text-on-surface-variant">{{ product.category.name }}</td>
                            <td class="px-4 py-3 text-xs text-on-surface-variant">{{ product.brand.name }}</td>
                            <td class="px-4 py-3 text-xs text-on-surface font-bold">{{ product.quantity }}</td>
                            <td class="px-4 py-3">
                                <span class="bg-secondary/15 text-secondary border border-secondary/20 text-[9px] font-bold px-2 py-0.5 rounded">{{ product.unit || 'pcs' }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <span v-if="product.is_low_stock" 
                                    class="inline-flex items-center gap-1.5 px-2 py-0.5 bg-yellow-500/10 text-yellow-700 border border-yellow-500/20 text-[9px] font-bold rounded">
                                    <span class="w-1 h-1 bg-yellow-500 rounded-full"></span>
                                    Stok Terbatas
                                </span>
                                <span v-else-if="product.inStock == 1" 
                                    class="inline-flex items-center gap-1.5 px-2 py-0.5 bg-green-500/10 text-green-700 border border-green-500/20 text-[9px] font-bold rounded">
                                    <span class="w-1 h-1 bg-green-500 rounded-full"></span>
                                    Tersedia
                                </span>
                                <span v-else 
                                    class="inline-flex items-center gap-1.5 px-2 py-0.5 bg-red-500/10 text-red-700 border border-red-500/20 text-[9px] font-bold rounded">
                                    <span class="w-1 h-1 bg-red-500 rounded-full"></span>
                                    Habis
                                </span>
                            </td>
                            <td class="px-4 py-3 text-xs font-bold text-on-surface">Rp {{ Number(product.price).toLocaleString() }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <button @click="openEditModal(product)"
                                        class="p-1.5 text-on-surface-variant hover:text-primary hover:bg-surface border border-outline-variant rounded transition-colors">
                                        <el-icon :size="14"><Edit /></el-icon>
                                    </button>
                                    <button @click="deleteProduct(product)"
                                        class="p-1.5 text-on-surface-variant hover:text-red-650 hover:bg-red-50 border border-outline-variant rounded transition-colors">
                                        <el-icon :size="14"><Delete /></el-icon>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4 border-t border-outline-variant">
                <Pagination :data="products"/>
            </div>
        </div>

        <!-- Modal -->
        <el-dialog v-model="dialogVisible" width="700px" class="!rounded">
            <template #header>
                <h3 class="text-sm font-bold text-on-surface uppercase tracking-wider">
                    {{ isEditProduct ? 'Edit Produk' : 'Tambah Produk' }}
                </h3>
            </template>

            <form @submit.prevent="isEditProduct ? updateProduct() : AddProduct()" class="space-y-5">
                <div>
                    <label class="block text-[10px] font-bold text-on-surface-variant uppercase tracking-wider mb-2">Nama Produk</label>
                    <input type="text" v-model="title" required
                        class="w-full px-4 py-2.5 bg-white border border-outline-variant rounded text-xs text-on-surface placeholder-on-surface-variant/40 focus:ring-1 focus:ring-primary focus:border-transparent transition-all"
                        placeholder="Masukkan nama produk">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold text-on-surface-variant uppercase tracking-wider mb-2">Kategori</label>
                        <select v-model="category_id"
                            class="w-full px-4 py-2.5 bg-white border border-outline-variant rounded text-xs text-on-surface focus:ring-1 focus:ring-primary focus:border-transparent transition-all">
                            <option value="">Pilih kategori</option>
                            <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-on-surface-variant uppercase tracking-wider mb-2">Brand</label>
                        <select v-model="brand_id"
                            class="w-full px-4 py-2.5 bg-white border border-outline-variant rounded text-xs text-on-surface focus:ring-1 focus:ring-primary focus:border-transparent transition-all">
                            <option value="">Pilih brand</option>
                            <option v-for="brand in brands" :key="brand.id" :value="brand.id">{{ brand.name }}</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold text-on-surface-variant uppercase tracking-wider mb-2">Harga</label>
                        <input type="number" v-model="price" required
                            class="w-full px-4 py-2.5 bg-white border border-outline-variant rounded text-xs text-on-surface placeholder-on-surface-variant/40 focus:ring-1 focus:ring-primary focus:border-transparent transition-all"
                            placeholder="Harga produk">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-on-surface-variant uppercase tracking-wider mb-2">Jumlah Stok</label>
                        <input type="number" v-model="quantity" required
                            class="w-full px-4 py-2.5 bg-white border border-outline-variant rounded text-xs text-on-surface placeholder-on-surface-variant/40 focus:ring-1 focus:ring-primary focus:border-transparent transition-all"
                            placeholder="Jumlah stok">
                    </div>
                </div>

                <!-- PondasiKu: Material fields -->
                <div class="bg-surface border border-outline-variant p-4 rounded">
                    <h4 class="text-xs font-bold text-on-surface mb-3 uppercase tracking-wider">Informasi Material</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-on-surface-variant uppercase tracking-wider mb-2">Satuan</label>
                            <select v-model="unit"
                                class="w-full px-4 py-2.5 bg-white border border-outline-variant rounded text-xs text-on-surface focus:ring-1 focus:ring-primary focus:border-transparent transition-all">
                                <option v-for="opt in unitOptions" :key="opt.value" :value="opt.value">{{ opt.label }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-on-surface-variant uppercase tracking-wider mb-2">Berat (kg)</label>
                            <input type="number" step="0.01" v-model="weight"
                                class="w-full px-4 py-2.5 bg-white border border-outline-variant rounded text-xs text-on-surface placeholder-on-surface-variant/40 focus:ring-1 focus:ring-primary focus:border-transparent transition-all"
                                placeholder="Berat dalam kg">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-on-surface-variant uppercase tracking-wider mb-2">Stok Minimum</label>
                            <input type="number" v-model="min_stock"
                                class="w-full px-4 py-2.5 bg-white border border-outline-variant rounded text-xs text-on-surface placeholder-on-surface-variant/40 focus:ring-1 focus:ring-primary focus:border-transparent transition-all"
                                placeholder="Minimum stok">
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-on-surface-variant uppercase tracking-wider mb-2">Deskripsi</label>
                    <textarea v-model="description" rows="3" required
                        class="w-full px-4 py-2.5 bg-white border border-outline-variant rounded text-xs text-on-surface placeholder-on-surface-variant/40 focus:ring-1 focus:ring-primary focus:border-transparent transition-all resize-none"
                        placeholder="Deskripsi produk"></textarea>
                </div>

                <!-- Published toggle -->
                <div class="flex items-center">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" v-model="published" class="sr-only peer">
                        <div class="w-11 h-6 bg-surface border border-outline-variant peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-outline-variant after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary peer-checked:border-primary"></div>
                        <span class="ml-3 text-xs font-bold text-on-surface uppercase tracking-wider">Publikasikan Produk</span>
                    </label>
                </div>

                <!-- Multiple images upload -->
                <div v-if="!product_images.length">
                    <label class="block text-[10px] font-bold text-on-surface-variant uppercase tracking-wider mb-2">Gambar Produk</label>
                    <el-upload v-model:file-list="productImages" accept=".jpg, .jpeg, .png" list-type="picture-card" multiple
                        :on-preview="handlePictureCardPreview" :on-remove="handleRemove" :on-change="handleFileChange">
                        <el-icon><Plus /></el-icon>
                    </el-upload>
                </div>

                <!-- List of images for selected product -->
                <div v-else>
                    <label class="block text-[10px] font-bold text-on-surface-variant uppercase tracking-wider mb-2">Gambar Produk</label>
                    <div class="flex flex-wrap gap-3">
                        <div v-for="(pimage, index) in product_images" :key="pimage.id" class="relative">
                            <img class="w-24 h-20 object-cover rounded border border-outline-variant" :src="pimage.image.startsWith('http') || pimage.image.startsWith('/') ? pimage.image : '/' + pimage.image" alt="">
                            <button @click="deleteImage(pimage, index)" type="button"
                                class="absolute -top-2 -right-2 w-5 h-5 bg-red-650 hover:bg-red-700 text-white rounded-full flex items-center justify-center text-xs font-bold transition-colors">
                                ×
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="button" @click="dialogVisible = false"
                        class="flex-1 px-4 py-2.5 border border-outline-variant text-on-surface font-bold text-xs uppercase tracking-wider rounded hover:bg-surface transition-all">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2.5 bg-primary text-white font-bold text-xs uppercase tracking-wider rounded hover:bg-opacity-95 shadow transition-all">
                        Simpan
                    </button>
                </div>
            </form>
        </el-dialog>

        <!-- Image Preview Dialog -->
        <el-dialog v-model="dialogPreviewImg" width="fit-content" class="!rounded">
            <img :src="dialogImageUrl" class="max-w-full max-h-96 rounded">
        </el-dialog>
    </div>
</template>
