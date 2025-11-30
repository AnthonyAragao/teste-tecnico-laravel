<template>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div v-if="$slots.header" class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <slot name="header" />
        </div>
        <div class="p-6">
            <slot />
        </div>
        <div v-if="$slots.footer" class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            <slot name="footer" />
        </div>
    </div>
</template>