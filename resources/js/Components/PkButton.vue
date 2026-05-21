<script setup>
/**
 * PkButton - PondasiKu Design System Button Component
 *
 * Variants: primary, secondary, accent, danger
 * Sizes: lg, md, sm
 * States: loading, disabled
 *
 * Requirements: 8.1-8.9
 */
const props = defineProps({
    /**
     * Button variant
     * - primary: Slate 900 background, white text (default)
     * - secondary: Transparent background, Slate 200 border
     * - accent: Amber 600 background, white text (high-priority CTA)
     * - danger: Red 600 background, white text
     */
    variant: {
        type: String,
        default: 'primary',
        validator: (value) => ['primary', 'secondary', 'accent', 'danger'].includes(value),
    },
    /**
     * Button size
     * - lg: py-4 px-8, text-sm, min-height 44px
     * - md: py-3 px-6, text-sm, min-height 44px (default)
     * - sm: py-2 px-4, text-xs, min-height 36px
     */
    size: {
        type: String,
        default: 'md',
        validator: (value) => ['lg', 'md', 'sm'].includes(value),
    },
    /**
     * HTML button type attribute
     */
    type: {
        type: String,
        default: 'button',
    },
    /**
     * Loading state — shows spinner, disables interaction
     */
    loading: {
        type: Boolean,
        default: false,
    },
    /**
     * Disabled state — opacity 50%, cursor not-allowed
     */
    disabled: {
        type: Boolean,
        default: false,
    },
    /**
     * Make button full width
     */
    block: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['click']);

const handleClick = (event) => {
    if (props.loading || props.disabled) {
        event.preventDefault();
        return;
    }
    emit('click', event);
};
</script>

<template>
    <button
        :type="type"
        :disabled="disabled || loading"
        :aria-disabled="disabled || loading"
        :aria-busy="loading"
        :class="[
            // Base styles
            'inline-flex items-center justify-center gap-2',
            'font-bold text-sm leading-none',
            'rounded-lg',
            'transition-all duration-200 ease-in-out',
            'focus:outline-none focus:ring-2 focus:ring-amber-600 focus:ring-offset-2',
            'select-none',

            // Block / full-width
            block ? 'w-full' : '',

            // Size variants — Requirements 8.7 (min 44px mobile touch target)
            size === 'lg' && 'py-4 px-8 min-h-[44px] text-sm',
            size === 'md' && 'py-3 px-6 min-h-[44px] text-sm',
            size === 'sm' && 'py-2 px-4 min-h-[36px] text-xs',

            // Variant: primary — Requirements 8.1, 8.2
            variant === 'primary' && !disabled && !loading && [
                'bg-slate-900 text-white border border-slate-900',
                'hover:bg-slate-800 hover:border-slate-800 hover:-translate-y-0.5 hover:shadow-md',
                'active:bg-slate-950 active:translate-y-0 active:shadow-sm',
                '  ',
                ' ',
            ],
            variant === 'primary' && (disabled || loading) && [
                'bg-slate-900 text-white border border-slate-900 opacity-50 cursor-not-allowed',
                '  ',
            ],

            // Variant: secondary — Requirements 8.3, 8.4
            variant === 'secondary' && !disabled && !loading && [
                'bg-transparent text-slate-700 border-2 border-slate-200',
                'hover:bg-slate-50 hover:border-slate-900',
                'active:bg-slate-100',
                ' ',
                ' ',
            ],
            variant === 'secondary' && (disabled || loading) && [
                'bg-transparent text-slate-700 border-2 border-slate-200 opacity-50 cursor-not-allowed',
                ' ',
            ],

            // Variant: accent — Requirements 8.5
            variant === 'accent' && !disabled && !loading && [
                'bg-amber-600 text-white border border-amber-600',
                'shadow-[0_4px_6px_-1px_rgba(217,119,6,0.2)]',
                'hover:bg-amber-700 hover:border-amber-700 hover:scale-[1.02] hover:shadow-pk-amber',
                'active:bg-amber-800 active:scale-[0.98]',
            ],
            variant === 'accent' && (disabled || loading) && [
                'bg-amber-600 text-white border border-amber-600 opacity-50 cursor-not-allowed',
            ],

            // Variant: danger — Requirements 8.1 (danger variant)
            variant === 'danger' && !disabled && !loading && [
                'bg-red-600 text-white border border-red-600',
                'hover:bg-red-700 hover:border-red-700 hover:-translate-y-0.5 hover:shadow-md',
                'active:bg-red-800 active:translate-y-0',
            ],
            variant === 'danger' && (disabled || loading) && [
                'bg-red-600 text-white border border-red-600 opacity-50 cursor-not-allowed',
            ],

            // Loading state — Requirements 8.6
            loading && 'opacity-70 cursor-not-allowed pointer-events-none',
        ]"
        @click="handleClick"
    >
        <!-- Loading spinner SVG — Requirements 8.6, 10.6 -->
        <svg
            v-if="loading"
            class="animate-spin w-4 h-4 shrink-0"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            aria-hidden="true"
        >
            <circle
                class="opacity-25"
                cx="12"
                cy="12"
                r="10"
                stroke="currentColor"
                stroke-width="4"
            />
            <path
                class="opacity-75"
                fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
            />
        </svg>

        <!-- Button content -->
        <slot />
    </button>
</template>
