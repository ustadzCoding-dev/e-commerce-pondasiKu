<script setup>
import { computed } from 'vue';

const props = defineProps({
    modelValue: {
        type: [String, Number],
        default: '',
    },
    label: {
        type: String,
        default: '',
    },
    placeholder: {
        type: String,
        default: '',
    },
    type: {
        type: String,
        default: 'text',
    },
    disabled: {
        type: Boolean,
        default: false,
    },
    error: {
        type: String,
        default: '',
    },
    helperText: {
        type: String,
        default: '',
    },
    required: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['update:modelValue']);

const inputClasses = computed(() => [
    'pk-input',
    'w-full',
    'min-h-[44px]',
    props.error ? 'pk-input--error' : '',
    props.disabled ? 'pk-input--disabled' : '',
]);

const handleInput = (event) => {
    emit('update:modelValue', event.target.value);
};
</script>

<template>
    <div class="pk-input-wrapper">
        <!-- Label -->
        <label
            v-if="label"
            class="pk-input-label"
        >
            {{ label }}
            <span v-if="required" class="text-red-500 ml-0.5" aria-hidden="true">*</span>
        </label>

        <!-- Input field -->
        <input
            :type="type"
            :value="modelValue"
            :placeholder="placeholder"
            :disabled="disabled"
            :required="required"
            :aria-invalid="!!error"
            :aria-describedby="error ? `${label}-error` : helperText ? `${label}-helper` : undefined"
            :class="inputClasses"
            @input="handleInput"
        />

        <!-- Error message -->
        <p
            v-if="error"
            :id="`${label}-error`"
            class="pk-input-error"
            role="alert"
        >
            {{ error }}
        </p>

        <!-- Helper text (only shown when no error) -->
        <p
            v-else-if="helperText"
            :id="`${label}-helper`"
            class="pk-input-helper"
        >
            {{ helperText }}
        </p>
    </div>
</template>
