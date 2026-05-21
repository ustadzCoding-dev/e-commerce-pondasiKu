<script setup>
import { computed } from 'vue';

const props = defineProps({
    modelValue: {
        type: [Boolean, Array],
        default: false,
    },
    value: {
        default: undefined,
    },
    label: {
        type: String,
        default: '',
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['update:modelValue']);

const isChecked = computed(() => {
    if (Array.isArray(props.modelValue)) {
        return props.modelValue.includes(props.value);
    }
    return props.modelValue === true;
});

function toggle() {
    if (props.disabled) return;

    if (Array.isArray(props.modelValue)) {
        const newValue = [...props.modelValue];
        const index = newValue.indexOf(props.value);
        if (index === -1) {
            newValue.push(props.value);
        } else {
            newValue.splice(index, 1);
        }
        emit('update:modelValue', newValue);
    } else {
        emit('update:modelValue', !props.modelValue);
    }
}
</script>

<template>
    <label
        class="inline-flex items-center gap-2 cursor-pointer select-none"
        :class="{ 'opacity-50 cursor-not-allowed': disabled }"
    >
        <!-- Hidden native checkbox for accessibility -->
        <input
            type="checkbox"
            class="sr-only"
            :checked="isChecked"
            :disabled="disabled"
            :value="value"
            @change="toggle"
        />

        <!-- Custom checkbox box -->
        <span
            class="relative flex items-center justify-center flex-shrink-0 rounded-sm border-2 transition-all duration-200 ease-in-out focus-within:ring-2 focus-within:ring-amber-600/30 focus-within:ring-offset-2"
            :class="[
                isChecked
                    ? 'bg-amber-600 border-amber-600'
                    : 'bg-white border-slate-300  ',
                disabled ? 'cursor-not-allowed' : 'cursor-pointer',
            ]"
            style="width: 18px; height: 18px;"
            @click="toggle"
        >
            <!-- Checkmark SVG -->
            <svg
                v-if="isChecked"
                viewBox="0 0 12 10"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
                class="w-3 h-2.5"
                aria-hidden="true"
            >
                <path
                    d="M1 5L4.5 8.5L11 1.5"
                    stroke="white"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
            </svg>
        </span>

        <!-- Label text -->
        <span
            v-if="label"
            class="text-sm font-medium text-slate-700 "
            :class="{ 'cursor-not-allowed': disabled, 'cursor-pointer': !disabled }"
        >
            {{ label }}
        </span>

        <!-- Slot for custom label content -->
        <slot v-else />
    </label>
</template>
