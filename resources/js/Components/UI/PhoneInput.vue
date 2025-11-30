<template>
    <div class="mb-4">
        <label v-if="label" :for="id" class="block text-sm font-medium text-gray-700 mb-2">
            {{ label }}
            <span v-if="required" class="text-red-500">*</span>
        </label>
        <input
            :id="id"
            type="tel"
            :value="formattedValue"
            :placeholder="placeholder"
            :required="required"
            :disabled="disabled"
            :class="[
                'block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm',
                { 'border-red-500': error },
                { 'bg-gray-100': disabled }
            ]"
            @input="handleInput"
            @keypress="handleKeypress"
        />
        <p v-if="error" class="mt-1 text-sm text-red-600">{{ error }}</p>
        <p class="mt-1 text-xs text-gray-500">Formato: 999999999 (9 dígitos)</p>
    </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
    id: String,
    label: String,
    modelValue: [String, Number],
    placeholder: {
        type: String,
        default: '999999999'
    },
    required: Boolean,
    disabled: Boolean,
    error: String
})

const emit = defineEmits(['update:modelValue'])

const formattedValue = computed(() => {
    if (!props.modelValue) return ''
    
    // Remove tudo que não é número
    const numbers = props.modelValue.toString().replace(/\D/g, '')
    
    // Limita a 9 dígitos
    const limited = numbers.slice(0, 9)
    
    // Aplica máscara: 99999-9999
    if (limited.length <= 5) {
        return limited
    } else {
        return limited.slice(0, 5) + '-' + limited.slice(5)
    }
})

const handleInput = (event) => {
    const value = event.target.value
    // Remove tudo que não é número
    const numbers = value.replace(/\D/g, '')
    // Limita a 9 dígitos
    const limited = numbers.slice(0, 9)
    
    emit('update:modelValue', limited)
}

const handleKeypress = (event) => {
    // Permite apenas números, backspace, delete, tab, escape, enter
    const allowedKeys = ['Backspace', 'Delete', 'Tab', 'Escape', 'Enter', 'ArrowLeft', 'ArrowRight']
    
    if (allowedKeys.includes(event.key)) {
        return true
    }
    
    // Permite apenas números
    if (!/[0-9]/.test(event.key)) {
        event.preventDefault()
        return false
    }
    
    // Verifica se já tem 9 dígitos
    const currentNumbers = (props.modelValue || '').toString().replace(/\D/g, '')
    if (currentNumbers.length >= 9) {
        event.preventDefault()
        return false
    }
}
</script>