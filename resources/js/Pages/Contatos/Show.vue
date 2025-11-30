<template>
    <AppLayout>
        <div class="space-y-6">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">Detalhes do Contato</h1>
                <div class="flex space-x-4">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('contatos.edit', contato.id)"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md"
                    >
                        Editar
                    </Link>
                    <Link
                        :href="route('pessoas.show', contato.pessoa.id)"
                        class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md"
                    >
                        Voltar
                    </Link>
                </div>
            </div>

            <!-- Informações da Pessoa -->
            <Card>
                <template #header>
                    <h2 class="text-xl font-semibold text-gray-900">Pessoa</h2>
                </template>

                <div class="flex items-center space-x-4">
                    <img
                        :src="contato.pessoa.avatar"
                        :alt="contato.pessoa.nome"
                        class="h-16 w-16 rounded-full"
                    />
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">{{ contato.pessoa.nome }}</h3>
                        <p class="text-sm text-gray-500">{{ contato.pessoa.email }}</p>
                    </div>
                </div>
            </Card>

            <!-- Informações do Contato -->
            <Card>
                <template #header>
                    <h2 class="text-xl font-semibold text-gray-900">Informações do Contato</h2>
                </template>

                <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Código do País</dt>
                        <dd class="mt-1 text-sm text-gray-900">+{{ contato.country_code }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Número</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ contato.number }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Número Completo</dt>
                        <dd class="mt-1 text-lg font-medium text-gray-900">+{{ contato.country_code }} {{ contato.number }}</dd>
                    </div>
                </dl>

                <template v-if="$page.props.auth.user" #footer>
                    <div class="flex justify-end">
                        <button
                            @click="deleteContato"
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md"
                        >
                            Excluir Contato
                        </button>
                    </div>
                </template>
            </Card>
        </div>
    </AppLayout>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import Card from '@/Components/UI/Card.vue'

const props = defineProps({
    contato: Object
})

const deleteContato = () => {
    if (confirm('Tem certeza que deseja excluir este contato?')) {
        router.delete(route('contatos.destroy', props.contato.id))
    }
}
</script>