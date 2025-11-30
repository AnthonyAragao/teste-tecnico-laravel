<template>
    <div class="min-h-screen bg-gray-100">
        <!-- Navigation -->
        <nav class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <Link :href="route('pessoas.index')" class="text-xl font-bold text-gray-800">
                                Gerenciador
                            </Link>
                        </div>
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <Link
                                :href="route('pessoas.index')"
                                :class="[
                                    'inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium',
                                    route().current('pessoas.*') 
                                        ? 'border-blue-500 text-gray-900' 
                                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                                ]"
                            >
                                Pessoas
                            </Link>
                            <Link
                                :href="route('dashboard.paises')"
                                :class="[
                                    'inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium',
                                    route().current('dashboard.paises') 
                                        ? 'border-blue-500 text-gray-900' 
                                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                                ]"
                            >
                                Dashboard Países
                            </Link>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div v-if="$page.props.auth.user" class="flex items-center space-x-4">
                            <span class="text-sm text-gray-700">{{ $page.props.auth.user.name }}</span>
                            <Link
                                :href="route('logout')"
                                method="post"
                                as="button"
                                class="text-sm text-gray-500 hover:text-gray-700"
                            >
                                Sair
                            </Link>
                        </div>
                        <div v-else class="flex items-center space-x-4">
                            <Link
                                :href="route('login')"
                                class="text-sm text-gray-500 hover:text-gray-700"
                            >
                                Entrar
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Flash Messages -->
                <div v-if="$page.props.flash?.success" class="mb-4">
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                        {{ $page.props.flash.success }}
                    </div>
                </div>
                <div v-if="$page.props.flash?.error" class="mb-4">
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        {{ $page.props.flash.error }}
                    </div>
                </div>

                <slot />
            </div>
        </main>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
</script>