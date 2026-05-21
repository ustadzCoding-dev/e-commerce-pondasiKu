<script setup>
import { computed, onMounted, onUnmounted, ref, watch, nextTick } from 'vue';

/**
 * PkModal - Design System 6: Modal/Dialog Component
 *
 * Features:
 * - Overlay backdrop with fade-in animation (200ms)
 * - Modal entrance: scale 0.95→1.0 + fade-in (200ms ease-in-out)
 * - Header, default (body), and footer slots
 * - Close button (top-right X icon)
 * - Keyboard Escape to close
 * - Click outside backdrop to close
 * - Focus trap inside modal when open
 * - v-model support via modelValue prop
 * - Dark mode support
 */

const props = defineProps({
    /**
     * Controls modal visibility (v-model)
     */
    modelValue: {
        type: Boolean,
        default: false,
    },
    /**
     * Modal title shown in header (if no header slot provided)
     */
    title: {
        type: String,
        default: '',
    },
    /**
     * Modal size: sm | md | lg | xl
     */
    size: {
        type: String,
        default: 'md',
        validator: (value) => ['sm', 'md', 'lg', 'xl'].includes(value),
    },
    /**
     * Whether the modal can be closed by user (X button, Escape, backdrop click)
     */
    closable: {
        type: Boolean,
        default: true,
    },
});

const emit = defineEmits(['update:modelValue', 'close']);

const modalRef = ref(null);
const previouslyFocused = ref(null);

// Size → max-width mapping
const sizeClasses = computed(() => ({
    sm: 'max-w-sm',
    md: 'max-w-[600px]',
    lg: 'max-w-2xl',
    xl: 'max-w-4xl',
}[props.size]));

const close = () => {
    if (!props.closable) return;
    emit('update:modelValue', false);
    emit('close');
};

// Keyboard handler: Escape closes modal
const onKeydown = (e) => {
    if (!props.modelValue) return;

    if (e.key === 'Escape') {
        close();
        return;
    }

    // Focus trap: Tab / Shift+Tab cycles within modal
    if (e.key === 'Tab' && modalRef.value) {
        const focusable = modalRef.value.querySelectorAll(
            'a[href], button:not([disabled]), textarea:not([disabled]), input:not([disabled]), select:not([disabled]), [tabindex]:not([tabindex="-1"])'
        );
        const focusableArray = Array.from(focusable);
        if (focusableArray.length === 0) return;

        const first = focusableArray[0];
        const last = focusableArray[focusableArray.length - 1];

        if (e.shiftKey) {
            if (document.activeElement === first) {
                e.preventDefault();
                last.focus();
            }
        } else {
            if (document.activeElement === last) {
                e.preventDefault();
                first.focus();
            }
        }
    }
};

// Lock body scroll and manage focus when modal opens/closes
watch(
    () => props.modelValue,
    async (isOpen) => {
        if (isOpen) {
            previouslyFocused.value = document.activeElement;
            document.body.style.overflow = 'hidden';
            await nextTick();
            // Focus first focusable element inside modal
            if (modalRef.value) {
                const focusable = modalRef.value.querySelector(
                    'a[href], button:not([disabled]), textarea:not([disabled]), input:not([disabled]), select:not([disabled]), [tabindex]:not([tabindex="-1"])'
                );
                if (focusable) focusable.focus();
                else modalRef.value.focus();
            }
        } else {
            document.body.style.overflow = '';
            // Restore focus to previously focused element
            if (previouslyFocused.value) {
                previouslyFocused.value.focus();
                previouslyFocused.value = null;
            }
        }
    }
);

onMounted(() => document.addEventListener('keydown', onKeydown));
onUnmounted(() => {
    document.removeEventListener('keydown', onKeydown);
    document.body.style.overflow = '';
});
</script>

<template>
    <Teleport to="body">
        <!-- Overlay + Modal wrapper -->
        <Transition
            enter-active-class="duration-200 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="duration-200 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="modelValue"
                class="fixed inset-0 z-50 flex items-center justify-center p-4"
                role="dialog"
                aria-modal="true"
                :aria-label="title || 'Modal'"
            >
                <!-- Backdrop -->
                <div
                    class="absolute inset-0 bg-black/50"
                    aria-hidden="true"
                    @click="close"
                />

                <!-- Modal container with scale + fade entrance -->
                <Transition
                    appear
                    enter-active-class="duration-200 ease-in-out"
                    enter-from-class="opacity-0 scale-95"
                    enter-to-class="opacity-100 scale-100"
                    leave-active-class="duration-200 ease-in-out"
                    leave-from-class="opacity-100 scale-100"
                    leave-to-class="opacity-0 scale-95"
                >
                    <div
                        v-if="modelValue"
                        ref="modalRef"
                        tabindex="-1"
                        class="relative z-10 w-[90%] max-h-[90vh] flex flex-col overflow-hidden
                               bg-white 
                               border border-slate-200 
                               rounded-lg shadow-xl
                               focus:outline-none"
                        :class="sizeClasses"
                    >
                        <!-- Header -->
                        <div
                            class="flex items-center justify-between shrink-0
                                   px-6 py-5
                                   border-b border-slate-100 "
                        >
                            <!-- Header slot or default title -->
                            <slot name="header">
                                <h3
                                    v-if="title"
                                    class="font-display text-lg font-bold text-slate-900  leading-snug"
                                >
                                    {{ title }}
                                </h3>
                            </slot>

                            <!-- Close button -->
                            <button
                                v-if="closable"
                                type="button"
                                class="ml-auto shrink-0 flex items-center justify-center
                                       w-8 h-8 rounded-lg
                                       text-slate-400 hover:text-slate-700  
                                       hover:bg-slate-100 
                                       transition-colors duration-150
                                       focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 "
                                aria-label="Tutup modal"
                                @click="close"
                            >
                                <!-- X icon (inline SVG, no external dependency) -->
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-4 h-4"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2.5"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    aria-hidden="true"
                                >
                                    <line x1="18" y1="6" x2="6" y2="18" />
                                    <line x1="6" y1="6" x2="18" y2="18" />
                                </svg>
                            </button>
                        </div>

                        <!-- Body -->
                        <div class="flex-1 overflow-y-auto px-6 py-6">
                            <slot />
                        </div>

                        <!-- Footer (only rendered if slot has content) -->
                        <div
                            v-if="$slots.footer"
                            class="shrink-0 flex items-center justify-end gap-3
                                   px-6 py-4
                                   border-t border-slate-100 "
                        >
                            <slot name="footer" />
                        </div>
                    </div>
                </Transition>
            </div>
        </Transition>
    </Teleport>
</template>
