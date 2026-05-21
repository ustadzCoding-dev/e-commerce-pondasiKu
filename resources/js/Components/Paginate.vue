<script setup>
import {Link} from "@inertiajs/vue3";
import {DArrowLeft, DArrowRight} from "@element-plus/icons-vue";

defineProps({
    products: {
        type: Object,
        default: () => ({}),
    },
});
</script>
<template>
<!--  -->
    <div v-for="(link, index) in products.links" class="flex text-gray-700">
            <Link preserve-scroll  v-if="link.label.includes('Previous')" class="w-10 h-10 flex items-center justify-center rounded-full border border-slate-200 bg-transparent text-sm text-slate-700  transition duration-150 ease-in-out hover:bg-slate-100 " :href="link.url ? products.prev_page_url : products.first_page_url" :class="link.url ? '' : 'hidden'" aria-label="Previous">
                <el-icon>
                    <DArrowLeft />
                </el-icon>
            </Link>
            <Link preserve-scroll v-else-if="link.label.includes('Next')" class="w-10 h-10 flex items-center justify-center rounded-full border border-slate-200 bg-transparent text-sm text-slate-700  transition duration-150 ease-in-out hover:bg-slate-100 " :href="link.url ? products.next_page_url : products.last_page_url" :class="link.url ? '' : 'hidden'" aria-label="Previous">
                <el-icon>
                    <DArrowRight />
                </el-icon>
            </Link>
            <Link preserve-scroll v-else class="w-10 h-10 flex items-center justify-center rounded-full text-md transition duration-150 ease-in-out"
                  :key="index"
                  :class="link.active ? 'bg-gradient-to-t via-90% from-amber-600 to-amber-400 hover:bg-gradient-to-b text-white hover:text-white' : 'bg-gray-200 hover:bg-gray-200 text-gray-900'"
                  :href="link.url"
                  v-html="link.label"
            >
            </Link>
    </div>
</template>
