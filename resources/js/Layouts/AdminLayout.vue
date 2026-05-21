<script setup>
import Navigation from "@/Pages/Admin/Components/Navigation.vue";
import Sidebar from "@/Pages/Admin/Components/Sidebar.vue";
import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'

// initialize components based on data attribute selectors
onMounted(() => {
    initFlowbite();
})
</script>

<template>
    <div class="antialiased bg-surface min-h-screen text-on-surface">
        <Navigation/>
        <!-- Sidebar -->

        <Sidebar/>

        <main class="p-4 md:ml-64 min-h-screen pt-20 bg-surface">
            <slot />
        </main>
    </div>
</template>
