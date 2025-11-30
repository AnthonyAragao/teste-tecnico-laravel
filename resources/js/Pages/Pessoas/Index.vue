<template>
    <AppLayout>
        <div class="space-y-6">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">Pessoas</h1>
                <Link
                    v-if="$page.props.auth.user"
                    :href="route('pessoas.create')"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md"
                >
                    Nova Pessoa
                </Link>
            </div>

            <Card>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Avatar
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nome
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Contatos
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="pessoa in pessoas.data" :key="pessoa.id">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <img
                                        :src="pessoa.avatar"
                                        :alt="pessoa.nome"
                                        class="h-10 w-10 rounded-full"
                                    />
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ pessoa.nome }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ pessoa.email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ pessoa.contatos_count || pessoa.contatos?.length || 0 }} contatos
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                    <Link
                                        :href="route('pessoas.show', pessoa.id)"
                                        class="text-blue-600 hover:text-blue-900"
                                    >
                                        Detalhes
                                    </Link>
                                    <Link
                                        v-if="$page.props.auth.user"
                                        :href="route('pessoas.edit', pessoa.id)"
                                        class="text-indigo-600 hover:text-indigo-900"
                                    >
                                        Editar
                                    </Link>
                                    <button
                                        v-if="$page.props.auth.user"
                                        @click="deletePessoa(pessoa.id)"
                                        class="text-red-600 hover:text-red-900"
                                    >
                                        Excluir
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Paginação -->
                <div v-if="pessoas.links" class="mt-6 flex justify-between items-center">
                    <div class="text-sm text-gray-700">
                        Mostrando {{ pessoas.from }} a {{ pessoas.to }} de {{ pessoas.total }} resultados
                    </div>
                    <div class="flex space-x-1">
                        <template v-for="link in pessoas.links" :key="link.label">
                            <Link
                                v-if="link.url"
                                :href="link.url"
                                :class="[
                                    'px-3 py-2 text-sm border rounded',
                                    link.active
                                        ? 'bg-blue-500 text-white border-blue-500'
                                        : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50'
                                ]"
                                v-html="link.label"
                            />
                            <span
                                v-else
                                :class="[
                                    'px-3 py-2 text-sm border rounded',
                                    'bg-gray-100 text-gray-400 border-gray-300 cursor-not-allowed'
                                ]"
                                v-html="link.label"
                            />
                        </template>
                    </div>
                </div>
            </Card>
        </div>
    </AppLayout>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import Card from '@/Components/UI/Card.vue'

defineProps({
    pessoas: Object
})

const deletePessoa = (id) => {
    if (confirm('Tem certeza que deseja excluir esta pessoa?')) {
        router.delete(route('pessoas.destroy', id))
    }
}
</script>