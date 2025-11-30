<template>
    <AppLayout>
        <div class="space-y-6">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">Editar Pessoa</h1>
                <Link
                    :href="route('pessoas.show', pessoa.id)"
                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md"
                >
                    Voltar
                </Link>
            </div>

            <Card>
                <form @submit.prevent="submit">
                    <div class="space-y-6">
                        <Input
                            id="nome"
                            v-model="form.nome"
                            label="Nome"
                            placeholder="Digite o nome completo"
                            required
                            :error="form.errors.nome"
                        />

                        <Input
                            id="email"
                            v-model="form.email"
                            type="email"
                            label="Email"
                            placeholder="Digite o email"
                            required
                            :error="form.errors.email"
                        />

                        <div class="flex justify-end space-x-4">
                            <Link
                                :href="route('pessoas.show', pessoa.id)"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md"
                            >
                                Cancelar
                            </Link>
                            <Button
                                type="submit"
                                variant="primary"
                                :disabled="form.processing"
                            >
                                {{ form.processing ? 'Salvando...' : 'Salvar' }}
                            </Button>
                        </div>
                    </div>
                </form>
            </Card>
        </div>
    </AppLayout>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import Card from '@/Components/UI/Card.vue'
import Input from '@/Components/UI/Input.vue'
import Button from '@/Components/UI/Button.vue'

const props = defineProps({
    pessoa: Object
})

const form = useForm({
    nome: props.pessoa.nome,
    email: props.pessoa.email
})

const submit = () => {
    form.put(route('pessoas.update', props.pessoa.id))
}
</script>