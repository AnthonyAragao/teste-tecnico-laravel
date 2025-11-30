<template>
    <div class="mb-4">
        <label v-if="label" :for="id" class="block text-sm font-medium text-gray-700 mb-2">
            {{ label }}
            <span v-if="required" class="text-red-500">*</span>
        </label>
        <input
            :id="id"
            :type="type"
            :value="modelValue"
            :placeholder="placeholder"
            :required="required"
            :disabled="disabled"
            :class="[
                'block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm',
                { 'border-red-500': error },
                { 'bg-gray-100': disabled }
            ]"
            @input="$emit('update:modelValue', $event.target.value)"
        />
        <p v-if="error" class="mt-1 text-sm text-red-600">{{ error }}</p>
    </div>
</template>

<script setup>
defineProps({
    id: String,
    label: String,
    type: {
        type: String,
        default: 'text'
    },
    modelValue: [String, Number],
    placeholder: String,
    required: Boolean,
    disabled: Boolean,
    error: String
})

defineEmits(['update:modelValue'])
</script>