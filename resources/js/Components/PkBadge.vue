<template>
    <span :class="badgeClasses">
        <slot />
    </span>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    /**
     * Badge variant: success | danger | warning | info | neutral
     */
    variant: {
        type: String,
        default: 'neutral',
        validator: (value) => ['success', 'danger', 'warning', 'info', 'neutral'].includes(value),
    },
    /**
     * Badge size: sm | md | lg
     */
    size: {
        type: String,
        default: 'md',
        validator: (value) => ['sm', 'md', 'lg'].includes(value),
    },
});

const variantClasses = {
    success: [
        'bg-green-50 text-green-700 border border-green-200',
        '  ',
    ],
    danger: [
        'bg-red-50 text-red-700 border border-red-200',
        '  ',
    ],
    warning: [
        'bg-amber-50 text-amber-700 border border-amber-200',
        '  ',
    ],
    info: [
        'bg-blue-50 text-blue-700 border border-blue-200',
        '  ',
    ],
    neutral: [
        'bg-slate-100 text-slate-700 border border-slate-200',
        '  ',
    ],
};

const sizeClasses = {
    sm: 'text-xs px-2 py-0.5',
    md: 'text-xs px-2.5 py-1',
    lg: 'text-sm px-3 py-1.5',
};

const badgeClasses = computed(() => [
    // Base styles
    'inline-flex items-center rounded-full',
    'uppercase font-black tracking-wider',
    // Size
    sizeClasses[props.size],
    // Variant (light + dark)
    ...variantClasses[props.variant],
]);
</script>
