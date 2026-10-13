<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import Pagination from '@/Components/Pagination.vue'

defineProps({
    category: Object,
    recipes: Object
})
</script>

<template>
    <Head :title="`${category.name} Recipes`" />

    <AppLayout>
        <div class="max-w-7xl mx-auto">
            <!-- Category Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-8 flex items-center space-x-4">
                    <div class="text-5xl">{{ category.icon || '🍽️' }}</div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">{{ category.name }}</h1>
                        <p class="text-gray-600 mt-1">{{ category.description || 'Explore recipes in this category.' }}</p>
                    </div>
                </div>
            </div>

            <!-- Recipes Grid -->
            <div v-if="recipes.data && recipes.data.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div v-for="recipe in recipes.data" :key="recipe.id" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow">
                    <Link :href="route('recipes.show', recipe.id)">
                        <div v-if="recipe.image" class="w-full h-48">
                            <img :src="'/storage/' + recipe.image" :alt="recipe.title" class="w-full h-full object-cover">
                        </div>
                        <div v-else class="w-full h-48 bg-gradient-to-r from-orange-100 to-yellow-100 flex items-center justify-center">
                            <span class="text-4xl">{{ category.icon || '🍽️' }}</span>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-xl font-semibold text-gray-900">{{ recipe.title }}</h3>
                                <span class="px-2 py-1 bg-orange-100 text-orange-800 text-xs rounded-full">
                                    {{ recipe.cooking_time }} min
                                </span>
                            </div>
                            <p class="text-gray-600 mb-4">{{ recipe.description.substring(0, 100) }}...</p>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500">By {{ recipe.user?.name || 'Unknown' }}</span>
                                <div class="flex items-center space-x-3">
                                    <span class="flex items-center text-red-500">❤️ {{ recipe.likes_count || 0 }}</span>
                                    <span class="flex items-center text-blue-500">💬 {{ recipe.comments_count || 0 }}</span>
                                </div>
                            </div>
                        </div>
                    </Link>
                </div>
            </div>

            <!-- Empty -->
            <div v-else class="bg-white rounded-lg p-12 text-center">
                <h3 class="text-xl font-semibold text-gray-700 mb-2">No recipes in this category yet</h3>
                <Link :href="route('recipes.index')" class="text-orange-600 hover:underline">Browse all recipes</Link>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                <Pagination :links="recipes.links" />
            </div>
        </div>
    </AppLayout>
</template>
