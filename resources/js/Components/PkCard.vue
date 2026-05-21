<script setup>
import { computed, useSlots } from 'vue';

/**
 * PkCard - Design System Card Component
 * Refined for Modern Industrial Premium design
 */

const props = defineProps({
    hoverable: {
        type: Boolean,
        default: false,
    },
    shadow: {
        type: String,
        default: 'sm',
        validator: (v) => ['none', 'sm', 'md', 'lg', 'xl'].includes(v),
    },
    padding: {
        type: String,
        default: 'lg',
        validator: (v) => ['none', 'sm', 'md', 'lg', 'xl'].includes(v),
    },
    noBorder: {
        type: Boolean,
        default: false,
    },
});

const slots = useSlots();

const shadowClass = computed(() => ({
    none: 'shadow-none',
    sm:   'shadow-sm',
    md:   'shadow-md',
    lg:   'shadow-lg',
    xl:   'shadow-xl',
}[props.shadow]));

const paddingClass = computed(() => ({
    none: '',
    sm:   'p-2',
    md:   'p-4',
    lg:   'p-6',
    xl:   'p-8',
}[props.padding]));

const bodyPaddingClass = computed(() => ({
    none: '',
    sm:   'px-2 py-2',
    md:   'px-4 py-4',
    lg:   'px-6 py-6',
    xl:   'px-8 py-8',
}[props.padding]));

const headerFooterPaddingClass = computed(() => ({
    none: '',
    sm:   'px-2 py-2',
    md:   'px-4 py-3',
    lg:   'px-6 py-4',
    xl:   'px-8 py-5',
}[props.padding]));
</script>

<template>
    <div
        class="pk-card-root"
        :class="[
            shadowClass,
            { 'pk-card-hoverable': hoverable },
            { 'pk-card-no-border': noBorder },
        ]"
    >
        <!-- Header slot -->
        <div
            v-if="slots.header"
            class="pk-card-header"
            :class="headerFooterPaddingClass"
        >
            <slot name="header" />
        </div>

        <!-- Body / default slot -->
        <div
            class="pk-card-body"
            :class="slots.header || slots.footer ? bodyPaddingClass : paddingClass"
        >
            <slot />
        </div>

        <!-- Footer slot -->
        <div
            v-if="slots.footer"
            class="pk-card-footer"
            :class="headerFooterPaddingClass"
        >
            <slot name="footer" />
        </div>
    </div>
</template>

<style scoped>
.pk-card-root {
    @apply bg-white  border border-slate-200  rounded-2xl overflow-hidden transition-all duration-300;
}

.pk-card-no-border {
    @apply border-0;
}

.pk-card-header {
    @apply bg-slate-50/50  border-b border-slate-100 
}

.pk-card-footer {
    @apply bg-slate-50/50  border-t border-slate-100 
}

.pk-card-hoverable {
    @apply cursor-pointer;
}

.pk-card-hoverable:hover {
    @apply -translate-y-1.5 shadow-2xl shadow-slate-200/50  border-slate-300 
}
</style>