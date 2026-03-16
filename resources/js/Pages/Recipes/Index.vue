<template>
    <AppLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Welcome Message -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h1 class="text-3xl font-bold text-gray-900">Welcome to RecipeShare! 🍳</h1>
                        <p class="text-gray-600 mt-2">Discover and share amazing recipes from around the world.</p>
                    </div>
                </div>

                <!-- Debug Info - Remove after testing -->
                <div v-if="$page.props.recipes && $page.props.recipes.data" class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">
                    Found {{ $page.props.recipes.data.length }} recipes
                </div>

                <!-- Filters Section -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Search -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                                <input 
                                    type="text" 
                                    v-model="filters.search"
                                    @keyup.enter="applyFilters"
                                    placeholder="Search recipes..."
                                    class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring focus:ring-orange-200"
                                >
                            </div>

                            <!-- Category Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                                <select v-model="filters.category" @change="applyFilters" class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring focus:ring-orange-200">
                                    <option value="">All Categories</option>
                                    <option v-for="category in categories" :key="category.id" :value="category.id">
                                        {{ category.name }}
                                    </option>
                                </select>
                            </div>

                            <!-- Sort -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                                <select v-model="filters.sort" @change="applyFilters" class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring focus:ring-orange-200">
                                    <option value="latest">Latest</option>
                                    <option value="popular">Most Popular</option>
                                    <option value="oldest">Oldest</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recipes Grid -->
                <div v-if="recipes && recipes.data && recipes.data.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div v-for="recipe in recipes.data" :key="recipe.id" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow">
                        <Link :href="route('recipes.show', recipe.id)">
                            <div v-if="recipe.image" class="w-full h-48">
                                <img :src="'/storage/' + recipe.image" :alt="recipe.title" class="w-full h-full object-cover">
                            </div>
                            <div v-else class="w-full h-48 bg-gradient-to-r from-orange-100 to-yellow-100 flex items-center justify-center">
                                <span class="text-4xl">🍽️</span>
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

                <!-- No Recipes Found -->
                <div v-else class="bg-white rounded-lg p-12 text-center">
                    <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">No recipes found</h3>
                    <p class="text-gray-500 mb-6">Be the first to share a recipe!</p>
                    <Link v-if="$page.props.auth?.user" :href="route('recipes.create')" class="bg-orange-600 text-white px-6 py-3 rounded-lg hover:bg-orange-700 transition">
                        Create Recipe
                    </Link>
                    <Link v-else :href="route('login')" class="bg-orange-600 text-white px-6 py-3 rounded-lg hover:bg-orange-700 transition">
                        Login to Create Recipe
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, watch } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
    recipes: Object,
    categories: Array,
    filters: Object
})

const searchQuery = ref(props.filters?.search || '')
const selectedCategory = ref(props.filters?.category || '')
const selectedSort = ref(props.filters?.sort || 'latest')

const applyFilters = () => {
    router.get(route('recipes.index'), {
        search: searchQuery.value,
        category: selectedCategory.value,
        sort: selectedSort.value
    }, {
        preserveState: true,
        preserveScroll: true
    })
}


let searchTimeout
watch(searchQuery, (newValue) => {
    clearTimeout(searchTimeout)
    searchTimeout = setTimeout(() => {
        applyFilters()
    }, 500)
})


watch([selectedCategory, selectedSort], () => {
    applyFilters()
})
</script>