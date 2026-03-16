<template>
    <AppLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Profile Header -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-8">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center space-x-6">
                                <!-- Avatar -->
                                <div class="relative">
                                    <div class="w-24 h-24 rounded-full bg-gradient-to-r from-orange-400 to-red-500 flex items-center justify-center text-white text-4xl font-bold">
                                        {{ profileUser.name.charAt(0).toUpperCase() }}
                                    </div>
                                </div>
                                
                                <!-- User Info -->
                                <div>
                                    <h2 class="text-3xl font-bold text-gray-900">{{ profileUser.name }}</h2>
                                    <p class="text-gray-600 mt-1">{{ profileUser.email }}</p>
                                    
                                    <!-- Bio -->
                                    <p v-if="profileUser.bio" class="mt-4 text-gray-700 max-w-2xl">
                                        {{ profileUser.bio }}
                                    </p>
                                    
                                    <!-- Stats -->
                                    <div class="flex space-x-6 mt-4">
                                        <div class="text-center">
                                            <span class="block text-2xl font-bold text-orange-600">{{ stats.recipes_count }}</span>
                                            <span class="text-sm text-gray-500">Recipes</span>
                                        </div>
                                        <div class="text-center">
                                            <span class="block text-2xl font-bold text-orange-600">{{ stats.likes_count }}</span>
                                            <span class="text-sm text-gray-500">Likes</span>
                                        </div>
                                        <div class="text-center">
                                            <span class="block text-2xl font-bold text-orange-600">{{ stats.favorites_count }}</span>
                                            <span class="text-sm text-gray-500">Favorites</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Edit Profile Button (only show if it's your profile) -->
                            <Link 
                                v-if="$page.props.auth.user && $page.props.auth.user.id === profileUser.id" 
                                :href="route('profile.edit')"
                                class="bg-orange-600 text-white px-6 py-2 rounded-lg hover:bg-orange-700 transition"
                            >
                                Edit Profile
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- User's Recipes -->
                <h3 class="text-2xl font-bold mb-6">{{ profileUser.name }}'s Recipes</h3>
                
                <div v-if="recipes.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div v-for="recipe in recipes" :key="recipe.id" class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                        <Link :href="route('recipes.show', recipe.id)">
                            <div v-if="recipe.image" class="h-48">
                                <img :src="'/storage/' + recipe.image" :alt="recipe.title" class="w-full h-full object-cover">
                            </div>
                            <div v-else class="h-48 bg-gradient-to-r from-orange-100 to-yellow-100 flex items-center justify-center">
                                <span class="text-5xl">🍽️</span>
                            </div>
                            <div class="p-6">
                                <h4 class="font-bold text-xl mb-2">{{ recipe.title }}</h4>
                                <p class="text-gray-600 mb-4">{{ recipe.description.substring(0, 100) }}...</p>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-500">{{ recipe.cooking_time }} mins</span>
                                    <div class="flex items-center space-x-3">
                                        <span class="flex items-center text-red-500">
                                            ❤️ {{ recipe.likes_count || 0 }}
                                        </span>
                                        <span class="flex items-center text-blue-500">
                                            💬 {{ recipe.comments_count || 0 }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </Link>
                    </div>
                </div>
                
                <div v-else class="bg-white rounded-lg p-12 text-center">
                    <p class="text-gray-500 text-lg mb-4">No recipes yet</p>
                    <Link 
                        v-if="$page.props.auth.user && $page.props.auth.user.id === profileUser.id"
                        :href="route('recipes.create')" 
                        class="inline-block bg-orange-600 text-white px-6 py-3 rounded-lg hover:bg-orange-700 transition"
                    >
                        Create Your First Recipe
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

defineProps({
    profileUser: Object,
    recipes: Array,
    stats: Object
})
</script>