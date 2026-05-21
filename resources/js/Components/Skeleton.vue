<script setup>
import { computed } from 'vue';

/**
 * Skeleton - Loading Placeholder Component with Shimmer Animation
 * Requirement 10: Loading States dan Skeleton Indicators
 *
 * Props:
 *   - variant: Shape variant (text | circle | rectangle) — default text
 *   - size: Size preset (sm | md | lg) — default md
 *   - width: Custom width (CSS value) — overrides size preset
 *   - height: Custom height (CSS value) — overrides size preset
 *   - count: Number of skeleton items to render — default 1
 *   - gap: Gap between multiple skeletons (CSS value) — default 8px
 */

const props = defineProps({
    variant: {
        type: String,
        default: 'text',
        validator: (v) => ['text', 'circle', 'rectangle'].includes(v),
    },
    size: {
        type: String,
        default: 'md',
        validator: (v) => ['sm', 'md', 'lg'].includes(v),
    },
    width: {
        type: String,
        default: null,
    },
    height: {
        type: String,
        default: null,
    },
    count: {
        type: Number,
        default: 1,
        validator: (v) => v > 0,
    },
    gap: {
        type: String,
        default: '8px',
    },
});

// Size presets based on variant
const sizePresets = {
    text: {
        sm: { width: '100%', height: '12px' },
        md: { width: '100%', height: '16px' },
        lg: { width: '100%', height: '24px' },
    },
    circle: {
        sm: { width: '32px', height: '32px' },
        md: { width: '40px', height: '40px' },
        lg: { width: '64px', height: '64px' },
    },
    rectangle: {
        sm: { width: '100%', height: '80px' },
        md: { width: '100%', height: '120px' },
        lg: { width: '100%', height: '200px' },
    },
};

// Computed dimensions
const dimensions = computed(() => {
    const preset = sizePresets[props.variant][props.size];
    return {
        width: props.width || preset.width,
        height: props.height || preset.height,
    };
});

// Border radius based on variant
const borderRadius = computed(() => {
    if (props.variant === 'circle') return '50%';
    if (props.variant === 'text') return '4px';
    return '8px'; // rectangle
});

// Generate array for v-for based on count
const items = computed(() => Array.from({ length: props.count }, (_, i) => i));

// Container style for gap
const containerStyle = computed(() => ({
    display: 'flex',
    flexDirection: 'column',
    gap: props.gap,
}));

// Individual skeleton style
const skeletonStyle = computed(() => ({
    width: dimensions.value.width,
    height: dimensions.value.height,
    borderRadius: borderRadius.value,
}));
</script>

<template>
    <div
        v-if="count > 1"
        class="skeleton-container"
        :style="containerStyle"
        role="status"
        aria-label="Loading..."
    >
        <div
            v-for="index in items"
            :key="index"
            class="skeleton"
            :style="skeletonStyle"
        />
    </div>
    <div
        v-else
        class="skeleton"
        :style="skeletonStyle"
        role="status"
        aria-label="Loading..."
    />
</template>

<style scoped>
/* Base skeleton styles */
.skeleton {
    background: linear-gradient(
        90deg,
        #e2e8f0 25%,  /* slate-200 */
        #f1f5f9 50%,  /* slate-100 */
        #e2e8f0 75%   /* slate-200 */
    );
    background-size: 1000px 100%;
    animation: shimmer 2s infinite linear;
    flex-shrink: 0;
}

/* Dark mode */
:global(.dark) .skeleton {
    background: linear-gradient(
        90deg,
        #1e293b 25%,  /* slate-800 */
        #334155 50%,  /* slate-700 */
        #1e293b 75%   /* slate-800 */
    );
    background-size: 1000px 100%;
}

/* Shimmer animation */
@keyframes shimmer {
    0% {
        background-position: -1000px 0;
    }
    100% {
        background-position: 1000px 0;
    }
}

/* Container for multiple skeletons */
.skeleton-container {
    width: 100%;
}

/* Accessibility: reduce motion for users who prefer it */
@media (prefers-reduced-motion: reduce) {
    .skeleton {
        animation: none;
        background: #e2e8f0; /* slate-200 */
    }
    
    :global(.dark) .skeleton {
        background: #1e293b; /* slate-800 */
    }
}
</style>
