<template>
    <AppLayout>
        <div class="space-y-6">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">Editar Contato</h1>
                <Link
                    :href="route('contatos.show', contato.id)"
                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md"
                >
                    Voltar
                </Link>
            </div>

            <Card>
                <template #header>
                    <h2 class="text-lg font-medium text-gray-900">Contato de: {{ contato.pessoa.nome }}</h2>
                </template>
                <div class="flex items-center space-x-4">
                    <img :src="contato.pessoa.avatar" :alt="contato.pessoa.nome" class="h-12 w-12 rounded-full" />
                    <div>
                        <p class="font-medium">{{ contato.pessoa.nome }}</p>
                        <p class="text-sm text-gray-500">{{ contato.pessoa.email }}</p>
                    </div>
                </div>
            </Card>

            <Card>
                <form @submit.prevent="submit">
                    <div class="space-y-6">
                        <Select
                            id="country_code"
                            v-model="form.country_code"
                            label="País"
                            :options="countryOptions"
                            placeholder="Selecione o país..."
                            searchable
                            required
                            :error="form.errors.country_code"
                        />

                        <PhoneInput
                            id="number"
                            v-model="form.number"
                            label="Número"
                            placeholder="999999999"
                            required
                            :error="form.errors.number"
                        />

                        <div class="flex justify-end space-x-4">
                            <Link
                                :href="route('contatos.show', contato.id)"
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
import { computed } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import Card from '@/Components/UI/Card.vue'
import Input from '@/Components/UI/Input.vue'
import PhoneInput from '@/Components/UI/PhoneInput.vue'
import Select from '@/Components/UI/Select.vue'
import Button from '@/Components/UI/Button.vue'

const props = defineProps({
    contato: Object,
    countries: Array
})

const form = useForm({
    pessoa_id: props.contato.pessoa_id,
    country_code: props.contato.country_code,
    number: props.contato.number
})

const countryOptions = computed(() => {
    return props.countries.map(country => ({
        value: country.calling_code,
        label: `${country.name} (+${country.calling_code})`
    }))
})

const submit = () => {
    form.put(route('contatos.update', props.contato.id))
}
</script>