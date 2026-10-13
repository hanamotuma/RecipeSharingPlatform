<template>
    <AppLayout>
        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="text-2xl font-bold mb-6">Create New Recipe</h2>

                        <form @submit.prevent="submit" enctype="multipart/form-data">
                            <!-- Title -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                                <input 
                                    type="text" 
                                    v-model="form.title"
                                    class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring focus:ring-orange-200"
                                    :class="{ 'border-red-500': form.errors.title }"
                                >
                                <p v-if="form.errors.title" class="text-red-500 text-xs mt-1">{{ form.errors.title }}</p>
                            </div>

                            <!-- Description -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                                <textarea 
                                    v-model="form.description"
                                    rows="3"
                                    class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring focus:ring-orange-200"
                                    :class="{ 'border-red-500': form.errors.description }"
                                ></textarea>
                                <p v-if="form.errors.description" class="text-red-500 text-xs mt-1">{{ form.errors.description }}</p>
                            </div>

                            <!-- Category and Cooking Time -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Category</label>
                                    <select 
                                        v-model="form.category_id"
                                        class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring focus:ring-orange-200"
                                        :class="{ 'border-red-500': form.errors.category_id }"
                                    >
                                        <option value="">Select a category</option>
                                        <option v-for="category in categories" :key="category.id" :value="category.id">
                                            {{ category.name }}
                                        </option>
                                    </select>
                                    <p v-if="form.errors.category_id" class="text-red-500 text-xs mt-1">{{ form.errors.category_id }}</p>
                                </div>

                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Cooking Time (minutes)</label>
                                    <input 
                                        type="number" 
                                        v-model="form.cooking_time"
                                        min="1"
                                        class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring focus:ring-orange-200"
                                        :class="{ 'border-red-500': form.errors.cooking_time }"
                                    >
                                    <p v-if="form.errors.cooking_time" class="text-red-500 text-xs mt-1">{{ form.errors.cooking_time }}</p>
                                </div>
                            </div>

                            <!-- Difficulty -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Difficulty</label>
                                <div class="flex space-x-4">
                                    <label class="inline-flex items-center">
                                        <input type="radio" v-model="form.difficulty" value="easy" class="text-orange-600">
                                        <span class="ml-2">Easy</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" v-model="form.difficulty" value="medium" class="text-orange-600">
                                        <span class="ml-2">Medium</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" v-model="form.difficulty" value="hard" class="text-orange-600">
                                        <span class="ml-2">Hard</span>
                                    </label>
                                </div>
                                <p v-if="form.errors.difficulty" class="text-red-500 text-xs mt-1">{{ form.errors.difficulty }}</p>
                            </div>

                            <!-- Ingredients -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Ingredients</label>
                                <textarea 
                                    v-model="form.ingredients"
                                    rows="5"
                                    class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring focus:ring-orange-200"
                                    :class="{ 'border-red-500': form.errors.ingredients }"
                                    placeholder="List each ingredient on a new line"
                                ></textarea>
                                <p v-if="form.errors.ingredients" class="text-red-500 text-xs mt-1">{{ form.errors.ingredients }}</p>
                            </div>

                            <!-- Instructions -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Instructions</label>
                                <textarea 
                                    v-model="form.instructions"
                                    rows="8"
                                    class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring focus:ring-orange-200"
                                    :class="{ 'border-red-500': form.errors.instructions }"
                                    placeholder="Write step-by-step instructions"
                                ></textarea>
                                <p v-if="form.errors.instructions" class="text-red-500 text-xs mt-1">{{ form.errors.instructions }}</p>
                            </div>

                            <!-- Image Upload -->
                            <div class="mb-6">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Recipe Image</label>
                                <input 
                                    type="file" 
                                    @change="handleImageUpload"
                                    accept="image/*"
                                    class="w-full"
                                    :class="{ 'border-red-500': form.errors.image }"
                                > <!-- helps to drag from the gallery and drop it here -->
                                <p v-if="form.errors.image" class="text-red-500 text-xs mt-1">{{ form.errors.image }}</p>
                                <div v-if="imagePreview" class="mt-2">
                                    <img :src="imagePreview" alt="Image preview" class="max-w-xs max-h-48 rounded">
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end">
                                <button 
                                    type="submit"
                                    class="bg-orange-600 text-white px-6 py-3 rounded-lg hover:bg-orange-700 transition disabled:opacity-50"
                                    :disabled="form.processing"
                                >
                                    {{ form.processing ? 'Creating...' : 'Create Recipe' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import {ref} from 'vue'
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
    categories: Array
})

const form = useForm({
    title: '',
    description: '',
    category_id: '',
    cooking_time: '',
    difficulty: 'medium',
    ingredients: '',
    instructions: '',
    image: null
})

const imagePreview = ref(null)

const handleImageUpload = (event) => {
    const file = event.target.files[0]
    form.image = file
    if (file) {
        
        if (imagePreview.value) {
            URL.revokeObjectURL(imagePreview.value)
        }
        imagePreview.value = URL.createObjectURL(file)
    } else {
        imagePreview.value = null
    }
}


const submit = () => {
    form.post(route('recipes.store'), {
        forceFormData: true,
        onSuccess: () => {
            form.reset()
            imagePreview.value=null
        }
    })
}
</script>