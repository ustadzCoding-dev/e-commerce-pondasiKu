<script setup>
import {router, usePage} from "@inertiajs/vue3";
import {ref, watch} from "vue";
import {ElNotification, ElMessageBox} from "element-plus";
import {Plus, Edit, Delete, Picture, Search} from "@element-plus/icons-vue";

defineProps({
    brands: Object
})

const searchValue = usePage().props.search;
const isAddItem = ref(false);
const isEditItem = ref(false);
const dialogVisible = ref(false);

// Form data
const id = ref('');
const name = ref('');
const slug = ref('');
const image = ref('');

const getDefaultImage = () => {
    return '../../images/no_image.jpg';
};

const openAddModal = () => {
    isAddItem.value = true;
    isEditItem.value = false;
    dialogVisible.value = true;
    resetFormData();
}

const openEditModal = (item) => {
    id.value = item.id;
    name.value = item.name;
    slug.value = item.slug;
    image.value = item.image;
    images.value = '';
    isEditItem.value = true;
    isAddItem.value = false;
    dialogVisible.value = true;
}

const dialogPreviewImg = ref(false)
const dialogImageUrl = ref('')
const images = ref([])
const handleFileChange = (file) => {
    images.value.push(file)
}

const handlePictureCardPreview = (file) => {
    dialogImageUrl.value = file.url
    dialogPreviewImg.value = true
}

const handleRemove = (file) => {
    console.log(file)
}

const deleteImage = async (slug) => {
    try {
        await router.delete('/admin/brand/image/' + slug, {
            onSuccess: (page) => {
                resetImage();
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

const resetImage = () => {
    image.value = '';
    images.value = '';
};

// Search
const search = ref(searchValue);
watch(search, (value) => {
    router.get(
        "/admin/brand/index",
        {search: value},
        {preserveState: false}
    );
});

// Add brand
const AddBrand = async () => {
    const formData = new FormData();
    formData.append('name', name.value);
    for (const image of images.value) {
        formData.append('image', image.raw);
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

const updateBrand = async () => {
    const formData = new FormData();
    formData.append('name', name.value);
    formData.append("_method", 'PUT');
    for (const image of images.value) {
        formData.append('image', image.raw);
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

// Delete brand
const deleteBrand = (item) => {
    ElMessageBox.confirm(
        'Tindakan ini tidak dapat dibatalkan. Yakin ingin menghapus brand ini?',
        'Hapus Brand',
        {
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            type: 'warning',
        }
    ).then(() => {
        try {
            router.delete('destroy/' + item.id, {
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

const resetFormData = () => {
    id.value = '';
    name.value = '';
    image.value = '';
    images.value = '';
};
</script>

<template>
    <div class="p-4 lg:p-6 bg-surface">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-xl lg:text-2xl font-bold text-on-surface">Brand</h1>
                    <p class="text-xs text-on-surface-variant mt-1">Kelola brand produk untuk toko Anda</p>
                </div>
                <button @click="openAddModal" 
                    class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-primary text-white font-bold text-xs uppercase tracking-wider rounded hover:bg-opacity-95 shadow transition-all">
                    <el-icon :size="14"><Plus /></el-icon>
                    Tambah Brand
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white border border-outline-variant rounded p-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-surface border border-outline-variant rounded text-on-surface-variant">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m5-4h1m-1 4h1m-6 4v-4a1 1 0 011-1h2a1 1 0 011 1v4" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Total Brand</p>
                        <p class="text-base font-bold text-on-surface">{{ brands.total }}</p>
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
                        placeholder="Cari brand...">
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-surface border-b border-outline-variant">
                        <tr>
                            <th class="px-4 py-3 text-left text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">#</th>
                            <th class="px-4 py-3 text-left text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Nama</th>
                            <th class="px-4 py-3 text-left text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Gambar</th>
                            <th class="px-4 py-3 text-right text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant">
                        <tr v-for="(item, index) in brands.data" :key="item.id" class="hover:bg-surface transition-colors">
                            <td class="px-4 py-3 text-xs text-on-surface-variant">{{ index + 1 }}</td>
                            <td class="px-4 py-3">
                                <span class="text-xs font-bold text-on-surface">{{ item.name }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <img v-if="item.image" :src="item.image" :alt="item.name"
                                    class="w-20 h-12 object-cover rounded border border-outline-variant">
                                <div v-else class="w-20 h-12 bg-surface rounded border border-outline-variant flex items-center justify-center">
                                    <el-icon class="text-on-surface-variant/40" :size="20"><Picture /></el-icon>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <button @click="openEditModal(item)"
                                        class="p-1.5 text-on-surface-variant hover:text-primary hover:bg-surface border border-outline-variant rounded transition-colors">
                                        <el-icon :size="14"><Edit /></el-icon>
                                    </button>
                                    <button @click="deleteBrand(item)"
                                        class="p-1.5 text-on-surface-variant hover:text-red-650 hover:bg-red-50 border border-outline-variant rounded transition-colors">
                                        <el-icon :size="14"><Delete /></el-icon>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal -->
        <el-dialog v-model="dialogVisible" width="500px" class="!rounded">
            <template #header>
                <h3 class="text-sm font-bold text-on-surface uppercase tracking-wider">
                    {{ isEditItem ? 'Edit Brand' : 'Tambah Brand' }}
                </h3>
            </template>

            <form @submit.prevent="isEditItem ? updateBrand() : AddBrand()" class="space-y-5">
                <div>
                    <label class="block text-[10px] font-bold text-on-surface-variant uppercase tracking-wider mb-2">Nama Brand</label>
                    <input type="text" v-model="name" required
                        class="w-full px-4 py-2.5 bg-white border border-outline-variant rounded text-xs text-on-surface placeholder-on-surface-variant/40 focus:ring-1 focus:ring-primary focus:border-transparent transition-all"
                        placeholder="Masukkan nama brand">
                </div>

                <div v-if="!image">
                    <label class="block text-[10px] font-bold text-on-surface-variant uppercase tracking-wider mb-2">Gambar</label>
                    <el-upload v-model:file-list="images" accept=".jpg, .jpeg, .png" list-type="picture-card" :limit="1"
                        :on-preview="handlePictureCardPreview" :on-remove="handleRemove" :on-change="handleFileChange">
                        <el-icon><Plus /></el-icon>
                    </el-upload>
                </div>

                <div v-else class="flex items-start gap-4">
                    <div class="relative">
                        <img :src="image" class="w-32 h-20 object-cover rounded border border-outline-variant">
                        <button @click="deleteImage(slug)" type="button"
                            class="absolute -top-2 -right-2 w-5 h-5 bg-red-650 hover:bg-red-700 text-white rounded-full flex items-center justify-center text-xs font-bold transition-colors">
                            ×
                        </button>
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
