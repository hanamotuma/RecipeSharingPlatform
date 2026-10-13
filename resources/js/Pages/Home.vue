<template>
    <AppLayout>
        <!-- Hero Section -->
        <div class="relative bg-gradient-to-r from-orange-500 to-red-600 text-white">
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl mb-6">
                    Welcome to RecipeShare
                </h1>
                <p class="text-xl max-w-3xl mx-auto mb-10">
                    Discover, share, and celebrate the rich flavors of Ethiopian cuisine and recipes from around the world
                </p>
                <div class="flex justify-center space-x-4">
                    <Link :href="route('recipes.index')" class="bg-white text-orange-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                        Browse Recipes
                    </Link>
                    <Link v-if="!isAuthenticated" :href="route('register')" class="bg-orange-700 text-white px-8 py-3 rounded-lg font-semibold hover:bg-orange-800 transition">
                        Join Now
                    </Link>
                </div>
            </div>
        </div>

        <!-- Featured Categories -->
        <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-12">Popular Categories</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div v-for="category in categories" :key="category.id" class="text-center">
                    <Link :href="route('recipes.index', { category: category.id })" class="block p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition">
                        <div class="text-4xl mb-3">{{ category.icon || '🍽️' }}</div>
                        <h3 class="font-semibold text-lg">{{ category.name }}</h3>
                        <p class="text-sm text-gray-500">{{ category.recipes_count || 0 }} recipes</p>
                    </Link>
                </div>
            </div>
        </div>

        <!-- Featured Recipes -->
        <div class="bg-gray-50 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center mb-12">Featured Ethiopian Recipes</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div v-for="recipe in featuredRecipes" :key="recipe.id" class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                        <Link :href="route('recipes.show', recipe.id)">
                            <div v-if="recipe.image" class="h-48">
                                <img :src="'/storage/' + recipe.image" :alt="recipe.title" class="w-full h-full object-cover">
                            </div>
                            <div v-else class="h-48 bg-gradient-to-r from-orange-100 to-yellow-100 flex items-center justify-center">
                                <span class="text-5xl">🇪🇹</span>
                            </div>
                            <div class="p-6">
                                <h3 class="font-bold text-xl mb-2">{{ recipe.title }}</h3>
                                <p class="text-gray-600 mb-4">{{ recipe.description.substring(0, 100) }}...</p>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-500">By {{ recipe.user?.name }}</span>
                                    <span class="text-orange-600 font-semibold">{{ recipe.cooking_time }} min</span>
                                </div>
                            </div>
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="bg-orange-600 text-white py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl font-bold mb-4">Share Your Favorite Recipes</h2>
                <p class="text-xl mb-8">Join our community of food lovers and share your culinary creations</p>
                <Link v-if="isAuthenticated" :href="route('recipes.create')" class="bg-white text-orange-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition inline-block">
                    Create Recipe
                </Link>
                <Link v-else :href="route('register')" class="bg-white text-orange-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition inline-block">
                    Sign Up Now
                </Link>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { computed } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const page = usePage()

const props = defineProps({
    categories: {
        type: Array,
        default: () => []
    },
    featuredRecipes: {
        type: Array,
        default: () => []
    }
})

const isAuthenticated = computed(() => {
    return page.props.auth?.user !== null && page.props.auth?.user !== undefined
})
</script>