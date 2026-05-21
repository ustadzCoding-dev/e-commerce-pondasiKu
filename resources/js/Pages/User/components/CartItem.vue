<script setup>
import { computed } from 'vue';

const props = defineProps({
    item: Object,
});

const emit = defineEmits(['add-quantity', 'reduce-quantity', 'delete-product']);

const imageUrl = computed(() => {
    if (props.item.product_image && props.item.product_image.length > 0) {
        return props.item.product_image[0].image.startsWith('/') 
            ? props.item.product_image[0].image 
            : '/' + props.item.product_image[0].image;
    }
    return '/images/logo/logo-square.webp';
});
</script>

<template>
    <div class="p-5 hover:bg-surface/50 transition-colors group">
        <div class="flex flex-col sm:flex-row gap-5">
            <!-- Product Image -->
            <div class="w-full sm:w-24 h-24 flex-shrink-0 bg-surface rounded overflow-hidden border border-outline-variant">
                <img v-if="item.product_image && item.product_image.length > 0" :src="imageUrl" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" alt="product">
                <img v-else src="/images/logo/logo-square.webp" class="w-full h-full object-cover" alt="no-image">
            </div>

            <!-- Product info details -->
            <div class="flex-1 flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-sm font-bold text-on-surface mb-1 group-hover:text-primary transition-colors">{{ item.product.title }}</h3>
                        <span class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">{{ item.product.unit_display || item.product.unit || 'pcs' }}</span>
                    </div>
                    <button @click="$emit('delete-product', item)" class="text-on-surface-variant hover:text-red-650 transition-colors p-1.5 rounded hover:bg-red-50" aria-label="Hapus item">
                        <span class="material-symbols-outlined text-base">delete</span>
                    </button>
                </div>

                <div class="flex flex-wrap items-end justify-between gap-4 mt-2">
                    <!-- Quantity Controls -->
                    <div class="flex items-center bg-white rounded p-0.5 border border-outline-variant">
                        <button @click.prevent="$emit('reduce-quantity', item)" :disabled="item.quantity === 1" class="w-7 h-7 flex items-center justify-center rounded text-on-surface-variant hover:bg-surface disabled:opacity-30 transition-all">
                            <span class="material-symbols-outlined text-sm">remove</span>
                        </button>
                        <span class="w-10 text-center text-xs font-bold text-on-surface">{{ item.quantity }}</span>
                        <button @click.prevent="$emit('add-quantity', item)" class="w-7 h-7 flex items-center justify-center rounded text-on-surface hover:bg-surface transition-all">
                            <span class="material-symbols-outlined text-sm">add</span>
                        </button>
                    </div>

                    <!-- Unit pricing -->
                    <div class="text-right">
                        <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-0.5">Harga Retail</p>
                        <p class="text-base font-bold text-primary">Rp {{ Number(item.product.price * item.quantity).toLocaleString() }}</p>
                        <p class="text-xs font-medium text-on-surface-variant uppercase">Rp {{ Number(item.product.price).toLocaleString() }} / unit</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
