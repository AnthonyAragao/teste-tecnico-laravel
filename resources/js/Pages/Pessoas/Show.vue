<template>
    <AppLayout>
        <div class="space-y-6">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">Detalhes da Pessoa</h1>
                <div class="flex space-x-4">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('pessoas.edit', pessoa.id)"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md"
                    >
                        Editar
                    </Link>
                    <Link
                        :href="route('pessoas.index')"
                        class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md"
                    >
                        Voltar
                    </Link>
                </div>
            </div>

            <!-- Informações da Pessoa -->
            <Card>
                <template #header>
                    <h2 class="text-xl font-semibold text-gray-900">Informações Pessoais</h2>
                </template>

                <div class="flex items-start space-x-6">
                    <img
                        :src="pessoa.avatar"
                        :alt="pessoa.nome"
                        class="h-24 w-24 rounded-full"
                    />
                    <div class="flex-1">
                        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Nome</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ pessoa.nome }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ pessoa.email }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <template v-if="$page.props.auth.user" #footer>
                    <div class="flex justify-end">
                        <button
                            @click="deletePessoa"
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md"
                        >
                            Excluir Pessoa
                        </button>
                    </div>
                </template>
            </Card>

            <!-- Contatos -->
            <Card>
                <template #header>
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-semibold text-gray-900">Contatos</h2>
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('contatos.create', { pessoa_id: pessoa.id })"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm"
                        >
                            Novo Contato
                        </Link>
                    </div>
                </template>

                <div v-if="pessoa.contatos && pessoa.contatos.length > 0">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        País
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Número
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Ações
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="contato in pessoa.contatos" :key="contato.id">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        +{{ contato.country_code }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ contato.number }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        <Link
                                            :href="route('contatos.show', contato.id)"
                                            class="text-blue-600 hover:text-blue-900"
                                        >
                                            Detalhes
                                        </Link>
                                        <Link
                                            v-if="$page.props.auth.user"
                                            :href="route('contatos.edit', contato.id)"
                                            class="text-indigo-600 hover:text-indigo-900"
                                        >
                                            Editar
                                        </Link>
                                        <button
                                            v-if="$page.props.auth.user"
                                            @click="deleteContato(contato.id)"
                                            class="text-red-600 hover:text-red-900"
                                        >
                                            Excluir
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div v-else class="text-center py-8 text-gray-500">
                    Nenhum contato cadastrado
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
    pessoa: Object
})

const deletePessoa = () => {
    if (confirm('Tem certeza que deseja excluir esta pessoa? Todos os contatos também serão excluídos.')) {
        router.delete(route('pessoas.destroy', pessoa.id))
    }
}

const deleteContato = (id) => {
    if (confirm('Tem certeza que deseja excluir este contato?')) {
        router.delete(route('contatos.destroy', id))
    }
}
</script>