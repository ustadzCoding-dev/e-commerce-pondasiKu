<script setup>
import Skeleton from '../Skeleton.vue';
</script>

<template>
    <div class="p-8 space-y-12">
        <div>
            <h1 class="text-2xl font-bold mb-6">Skeleton Component Test</h1>
            <p class="text-sm text-gray-600 mb-8">
                Testing Skeleton component with shimmer animation, variants, sizes, and dark mode support.
            </p>
        </div>

        <!-- Text Variant -->
        <div>
            <h2 class="text-xl font-semibold mb-4">Text Variant</h2>
            <div class="space-y-6">
                <div>
                    <h3 class="text-sm font-medium mb-2">Small (sm)</h3>
                    <Skeleton variant="text" size="sm" />
                </div>
                <div>
                    <h3 class="text-sm font-medium mb-2">Medium (md) - Default</h3>
                    <Skeleton variant="text" size="md" />
                </div>
                <div>
                    <h3 class="text-sm font-medium mb-2">Large (lg)</h3>
                    <Skeleton variant="text" size="lg" />
                </div>
                <div>
                    <h3 class="text-sm font-medium mb-2">Multiple Text Lines (count=3)</h3>
                    <Skeleton variant="text" size="md" :count="3" />
                </div>
                <div>
                    <h3 class="text-sm font-medium mb-2">Custom Width (50%)</h3>
                    <Skeleton variant="text" size="md" width="50%" />
                </div>
            </div>
        </div>

        <!-- Circle Variant -->
        <div>
            <h2 class="text-xl font-semibold mb-4">Circle Variant (Avatar)</h2>
            <div class="flex gap-6 items-end">
                <div>
                    <h3 class="text-sm font-medium mb-2">Small (32px)</h3>
                    <Skeleton variant="circle" size="sm" />
                </div>
                <div>
                    <h3 class="text-sm font-medium mb-2">Medium (40px)</h3>
                    <Skeleton variant="circle" size="md" />
                </div>
                <div>
                    <h3 class="text-sm font-medium mb-2">Large (64px)</h3>
                    <Skeleton variant="circle" size="lg" />
                </div>
                <div>
                    <h3 class="text-sm font-medium mb-2">Custom (80px)</h3>
                    <Skeleton variant="circle" width="80px" height="80px" />
                </div>
            </div>
        </div>

        <!-- Rectangle Variant -->
        <div>
            <h2 class="text-xl font-semibold mb-4">Rectangle Variant (Cards, Images)</h2>
            <div class="space-y-6">
                <div>
                    <h3 class="text-sm font-medium mb-2">Small (80px height)</h3>
                    <Skeleton variant="rectangle" size="sm" />
                </div>
                <div>
                    <h3 class="text-sm font-medium mb-2">Medium (120px height)</h3>
                    <Skeleton variant="rectangle" size="md" />
                </div>
                <div>
                    <h3 class="text-sm font-medium mb-2">Large (200px height)</h3>
                    <Skeleton variant="rectangle" size="lg" />
                </div>
                <div>
                    <h3 class="text-sm font-medium mb-2">Custom Dimensions (300px x 150px)</h3>
                    <Skeleton variant="rectangle" width="300px" height="150px" />
                </div>
            </div>
        </div>

        <!-- Multiple Skeletons -->
        <div>
            <h2 class="text-xl font-semibold mb-4">Multiple Skeletons (count prop)</h2>
            <div class="space-y-6">
                <div>
                    <h3 class="text-sm font-medium mb-2">3 Text Lines</h3>
                    <Skeleton variant="text" :count="3" />
                </div>
                <div>
                    <h3 class="text-sm font-medium mb-2">5 Text Lines with Custom Gap (16px)</h3>
                    <Skeleton variant="text" :count="5" gap="16px" />
                </div>
                <div>
                    <h3 class="text-sm font-medium mb-2">3 Rectangles</h3>
                    <Skeleton variant="rectangle" size="sm" :count="3" gap="12px" />
                </div>
            </div>
        </div>

        <!-- Product Card Skeleton Example -->
        <div>
            <h2 class="text-xl font-semibold mb-4">Product Card Skeleton Example</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div
                    v-for="i in 4"
                    :key="i"
                    class="border border-slate-200  rounded-xl p-5 bg-white "
                >
                    <!-- Product Image -->
                    <Skeleton variant="rectangle" height="200px" class="mb-4" />
                    
                    <!-- Brand -->
                    <Skeleton variant="text" size="sm" width="40%" class="mb-2" />
                    
                    <!-- Product Title -->
                    <Skeleton variant="text" size="md" :count="2" gap="8px" class="mb-3" />
                    
                    <!-- Price -->
                    <Skeleton variant="text" size="lg" width="60%" />
                </div>
            </div>
        </div>

        <!-- Dashboard Statistics Card Skeleton Example -->
        <div>
            <h2 class="text-xl font-semibold mb-4">Dashboard Statistics Card Skeleton</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div
                    v-for="i in 3"
                    :key="i"
                    class="border border-slate-200  rounded-xl p-5 bg-white  flex items-center gap-4"
                >
                    <!-- Icon -->
                    <Skeleton variant="circle" size="lg" />
                    
                    <!-- Content -->
                    <div class="flex-1">
                        <Skeleton variant="text" size="sm" width="60%" class="mb-2" />
                        <Skeleton variant="text" size="lg" width="40%" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Skeleton Example -->
        <div>
            <h2 class="text-xl font-semibold mb-4">Table Skeleton Example</h2>
            <div class="border border-slate-200  rounded-xl overflow-hidden bg-white ">
                <!-- Table Header -->
                <div class="bg-slate-50  p-4 border-b border-slate-100 ">
                    <div class="grid grid-cols-5 gap-4">
                        <Skeleton variant="text" size="sm" width="80%" />
                        <Skeleton variant="text" size="sm" width="80%" />
                        <Skeleton variant="text" size="sm" width="80%" />
                        <Skeleton variant="text" size="sm" width="80%" />
                        <Skeleton variant="text" size="sm" width="80%" />
                    </div>
                </div>
                
                <!-- Table Rows -->
                <div
                    v-for="i in 5"
                    :key="i"
                    class="p-4 border-b border-slate-100  last:border-b-0"
                >
                    <div class="grid grid-cols-5 gap-4 items-center">
                        <Skeleton variant="text" size="md" width="90%" />
                        <Skeleton variant="text" size="md" width="70%" />
                        <Skeleton variant="text" size="md" width="60%" />
                        <Skeleton variant="text" size="sm" width="50%" />
                        <Skeleton variant="rectangle" height="32px" width="80px" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Dark Mode Test -->
        <div>
            <h2 class="text-xl font-semibold mb-4">Dark Mode Support</h2>
            <p class="text-sm text-gray-600 mb-4">
                Toggle dark mode to see the skeleton adapt to the theme.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-6 bg-white  border border-slate-200  rounded-xl">
                    <h3 class="text-sm font-medium mb-4">Light Mode Preview</h3>
                    <Skeleton variant="text" :count="3" gap="12px" />
                    <div class="mt-4">
                        <Skeleton variant="rectangle" size="md" />
                    </div>
                </div>
                <div class="p-6 bg-slate-900 border border-slate-800 rounded-xl dark">
                    <h3 class="text-sm font-medium mb-4 text-white">Dark Mode Preview</h3>
                    <Skeleton variant="text" :count="3" gap="12px" />
                    <div class="mt-4">
                        <Skeleton variant="rectangle" size="md" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Accessibility Note -->
        <div class="p-6 bg-blue-50  border border-blue-200  rounded-xl">
            <h3 class="text-sm font-semibold mb-2">Accessibility Features</h3>
            <ul class="text-sm text-gray-700  space-y-1">
                <li>• <code>role="status"</code> and <code>aria-label="Loading..."</code> for screen readers</li>
                <li>• Respects <code>prefers-reduced-motion</code> - animation disabled for users who prefer reduced motion</li>
                <li>• Proper contrast ratios in both light and dark modes</li>
            </ul>
        </div>
    </div>
</template>

<style scoped>
/* Additional test styles if needed */
</style>
