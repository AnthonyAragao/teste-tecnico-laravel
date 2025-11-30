<template>
    <div class="mb-4">
        <label v-if="label" :for="id" class="block text-sm font-medium text-gray-700 mb-2">
            {{ label }}
            <span v-if="required" class="text-red-500">*</span>
        </label>
        <div class="relative">
            <input
                v-if="searchable"
                :id="id"
                v-model="searchTerm"
                type="text"
                :placeholder="placeholder"
                :class="[
                    'block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm',
                    { 'border-red-500': error }
                ]"
                @focus="showOptions = true"
                @blur="hideOptions"
            />
            <select
                v-else
                :id="id"
                :value="modelValue"
                :required="required"
                :disabled="disabled"
                :class="[
                    'block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm',
                    { 'border-red-500': error },
                    { 'bg-gray-100': disabled }
                ]"
                @change="$emit('update:modelValue', $event.target.value)"
            >
                <option value="">{{ placeholder || 'Selecione...' }}</option>
                <option v-for="option in options" :key="option.value" :value="option.value">
                    {{ option.label }}
                </option>
            </select>
            
            <!-- Dropdown para select pesquisável -->
            <div
                v-if="searchable && showOptions"
                class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-auto"
            >
                <div
                    v-for="option in filteredOptions"
                    :key="option.value"
                    class="px-3 py-2 cursor-pointer hover:bg-gray-100"
                    @mousedown="selectOption(option)"
                >
                    {{ option.label }}
                </div>
                <div v-if="filteredOptions.length === 0" class="px-3 py-2 text-gray-500">
                    Nenhum resultado encontrado
                </div>
            </div>
        </div>
        <p v-if="error" class="mt-1 text-sm text-red-600">{{ error }}</p>
    </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'

const props = defineProps({
    id: String,
    label: String,
    modelValue: [String, Number],
    options: {
        type: Array,
        default: () => []
    },
    placeholder: String,
    required: Boolean,
    disabled: Boolean,
    error: String,
    searchable: Boolean
})

const emit = defineEmits(['update:modelValue'])

const searchTerm = ref('')
const showOptions = ref(false)

const filteredOptions = computed(() => {
    if (!props.searchable || !searchTerm.value) {
        return props.options
    }
    return props.options.filter(option =>
        option.label.toLowerCase().includes(searchTerm.value.toLowerCase())
    )
})

const selectOption = (option) => {
    emit('update:modelValue', option.value)
    searchTerm.value = option.label
    showOptions.value = false
}

const hideOptions = () => {
    setTimeout(() => {
        showOptions.value = false
    }, 200)
}

watch(() => props.modelValue, (newValue) => {
    if (props.searchable && newValue) {
        const option = props.options.find(opt => opt.value === newValue)
        if (option) {
            searchTerm.value = option.label
        }
    }
})
</script>