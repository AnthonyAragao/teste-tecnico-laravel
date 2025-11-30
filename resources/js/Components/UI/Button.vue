<template>
    <button
        :type="type"
        :class="[
            'inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150',
            variantClasses,
            sizeClasses,
            { 'opacity-25': disabled }
        ]"
        :disabled="disabled"
    >
        <slot />
    </button>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
    type: {
        type: String,
        default: 'button'
    },
    variant: {
        type: String,
        default: 'primary'
    },
    size: {
        type: String,
        default: 'md'
    },
    disabled: {
        type: Boolean,
        default: false
    }
})

const variantClasses = computed(() => {
    const variants = {
        primary: 'bg-blue-600 hover:bg-blue-700 text-white focus:ring-blue-500',
        secondary: 'bg-gray-600 hover:bg-gray-700 text-white focus:ring-gray-500',
        danger: 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500',
        success: 'bg-green-600 hover:bg-green-700 text-white focus:ring-green-500'
    }
    return variants[props.variant] || variants.primary
})

const sizeClasses = computed(() => {
    const sizes = {
        sm: 'px-3 py-1.5 text-xs',
        md: 'px-4 py-2 text-sm',
        lg: 'px-6 py-3 text-base'
    }
    return sizes[props.size] || sizes.md
})
</script>