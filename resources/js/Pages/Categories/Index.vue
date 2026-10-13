<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

defineProps({
    categories: Array
})
</script>

<template>
    <Head title="Recipe Categories" />

    <AppLayout>
        <div class="max-w-6xl mx-auto">
            <h1 class="text-3xl font-bold mb-8 text-gray-800">Browse Categories</h1>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div v-for="category in categories" :key="category.id"
                     class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="text-4xl mb-3">{{ category.icon || '🍽️' }}</div>

                    <h2 class="text-xl font-bold text-gray-900">{{ category.name }}</h2>

                    <p class="text-gray-600 mt-2 text-sm leading-relaxed">
                        {{ category.description || 'Explore recipes in this category.' }}
                    </p>

                    <p class="text-sm text-gray-500 mt-2">{{ category.recipes_count || 0 }} recipes</p>

                    <Link :href="route('categories.show', category.slug)"
                          class="mt-4 inline-flex items-center text-orange-600 font-medium hover:underline">
                        Explore recipes
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"></path></svg>
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
