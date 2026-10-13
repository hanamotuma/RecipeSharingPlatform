<script setup>
import { Link, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import Pagination from '@/Components/Pagination.vue'

const props = defineProps({
    favorites: Object
})

const removeFavorite = (recipeId) => {
    if (confirm('Remove this recipe from favorites?')) {
        router.post(route('recipes.favorite', recipeId), {}, {
            preserveScroll: true,
            onSuccess: () => {
                router.reload({ only: ['favorites'] })
            }
        })
    }
}
</script>

<template>
    <AppLayout>
        <div class="max-w-7xl mx-auto">
            <h2 class="text-2xl font-bold mb-6">My Favorite Recipes</h2>

            <div v-if="!favorites.data || favorites.data.length === 0" class="bg-white rounded-lg p-12 text-center">
                <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                </svg>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">No favorites yet</h3>
                <p class="text-gray-500 mb-6">Start exploring recipes and save your favorites!</p>
                <Link :href="route('recipes.index')" class="bg-orange-600 text-white px-6 py-3 rounded-lg hover:bg-orange-700 transition">
                    Browse Recipes
                </Link>
            </div>

            <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div v-for="favorite in favorites.data" :key="favorite.id" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow">
                    <Link :href="route('recipes.show', favorite.recipe.id)">
                        <div v-if="favorite.recipe.image" class="w-full h-48">
                            <img :src="'/storage/' + favorite.recipe.image" :alt="favorite.recipe.title" class="w-full h-full object-cover">
                        </div>
                        <div v-else class="w-full h-48 bg-gradient-to-r from-orange-100 to-yellow-100 flex items-center justify-center">
                            <span class="text-4xl">🍽️</span>
                        </div>
                        <div class="p-4">
                            <h4 class="font-semibold">{{ favorite.recipe.title }}</h4>
                            <p class="text-sm text-gray-600 mt-1">{{ favorite.recipe.description.substring(0, 100) }}...</p>
                            <div class="flex items-center justify-between mt-2 text-sm text-gray-500">
                                <span>By {{ favorite.recipe.user?.name }}</span>
                                <button @click.prevent="removeFavorite(favorite.recipe.id)" class="text-red-500 hover:text-red-700">
                                    Remove
                                </button>
                            </div>
                        </div>
                    </Link>
                </div>
            </div>

            <div class="mt-6">
                <Pagination :links="favorites.links" />
            </div>
        </div>
    </AppLayout>
</template>
