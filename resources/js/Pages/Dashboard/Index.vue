<template>
    <AppLayout>
        <div class="space-y-6">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">Dashboard - Contatos por País</h1>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <Card v-for="item in contatosPorPais" :key="item.country_code" class="hover:shadow-lg transition-shadow">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600 mb-2">{{ item.total }}</div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ item.country_name }}</h3>
                        <p class="text-sm text-gray-500">Código: +{{ item.country_code }}</p>
                        <div class="mt-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ item.total === 1 ? '1 contato' : `${item.total} contatos` }}
                            </span>
                        </div>
                    </div>
                </Card>
            </div>

            <div v-if="contatosPorPais.length === 0" class="text-center py-12">
                <div class="text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhum contato encontrado</h3>
                    <p class="mt-1 text-sm text-gray-500">Comece criando pessoas e seus contatos.</p>
                    <div class="mt-6">
                        <Link
                            :href="route('pessoas.index')"
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700"
                        >
                            Ver Pessoas
                        </Link>
                    </div>
                </div>
            </div>

            <!-- Estatísticas Resumidas -->
            <Card v-if="contatosPorPais.length > 0">
                <template #header>
                    <h2 class="text-xl font-semibold text-gray-900">Estatísticas</h2>
                </template>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600">{{ totalContatos }}</div>
                        <p class="text-sm text-gray-500">Total de Contatos</p>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-purple-600">{{ contatosPorPais.length }}</div>
                        <p class="text-sm text-gray-500">Países Diferentes</p>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-orange-600">{{ mediaContatosPorPais }}</div>
                        <p class="text-sm text-gray-500">Média por País</p>
                    </div>
                </div>
            </Card>
        </div>
    </AppLayout>
</template>

<script setup>
import { computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import Card from '@/Components/UI/Card.vue'

const props = defineProps({
    contatosPorPais: Array
})

const totalContatos = computed(() => {
    return props.contatosPorPais.reduce((total, item) => total + item.total, 0)
})

const mediaContatosPorPais = computed(() => {
    if (props.contatosPorPais.length === 0) return 0
    return Math.round(totalContatos.value / props.contatosPorPais.length * 10) / 10
})
</script>