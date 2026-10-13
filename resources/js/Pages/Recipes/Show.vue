<template>
    <AppLayout>
        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <!-- Recipe Header -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div v-if="recipe.image" class="w-full h-96">
                        <img :src="'/storage/' + recipe.image" :alt="recipe.title" class="w-full h-full object-cover">
                    </div>
                    
                    <div class="p-6">
                        <!-- Title and Actions -->
                        <div class="flex justify-between items-start mb-4">
                            <h1 class="text-3xl font-bold">{{ recipe.title }}</h1>
                            
                            <div class="flex items-center space-x-4">
                                <!-- Like Button -->
                                <button @click="toggleLike" class="flex items-center space-x-1 text-gray-600 hover:text-red-500 transition" :disabled="!isAuthenticated">
                                    <svg class="w-6 h-6" :class="{ 'text-red-500 fill-current': isLiked }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    <span>{{ recipe.likes_count }}</span>
                                </button>

                                <!-- Share Button -->
                                <button @click="showShareModal = true" class="flex items-center space-x-1 text-gray-600 hover:text-blue-500 transition">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                    </svg>
                                </button>

                                <!-- Favorite Button -->
                                <button @click="toggleFavorite" class="flex items-center space-x-1 text-gray-600 hover:text-yellow-500 transition" :disabled="!isAuthenticated">
                                    <svg class="w-6 h-6" :class="{ 'text-yellow-500 fill-current': isFavorited }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                </button>

                                <!-- Edit/Delete for Owner -->
                                <div v-if="isAuthenticated && user.id === recipe.user_id" class="flex space-x-2 border-l pl-4">
                                    <Link :href="route('recipes.edit', recipe.id)" class="text-blue-600 hover:text-blue-800">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </Link>
                                    <button @click="deleteRecipe" class="text-red-600 hover:text-red-800">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Meta Info -->
                        <div class="flex items-center space-x-4 text-gray-600 mb-6">
                            <span>By <Link :href="route('profile.show', recipe.user.id)" class="text-orange-600 hover:underline">{{ recipe.user.name }}</Link></span>
                            <span>•</span>
                            <span>{{ recipe.category.name }}</span>
                            <span>•</span>
                            <span>{{ recipe.cooking_time }} mins</span>
                            <span>•</span>
                            <span class="capitalize px-2 py-1 bg-gray-100 rounded-full text-xs">{{ recipe.difficulty }}</span>
                        </div>

                        <!-- Description -->
                        <p class="text-gray-700 mb-6">{{ recipe.description }}</p>

                        <!-- Ingredients -->
                        <div class="mb-6">
                            <h2 class="text-xl font-semibold mb-3">Ingredients</h2>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="whitespace-pre-line">{{ recipe.ingredients }}</p>
                            </div>
                        </div>

                        <!-- Instructions -->
                        <div class="mb-6">
                            <h2 class="text-xl font-semibold mb-3">Instructions</h2>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="whitespace-pre-line">{{ recipe.instructions }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Comments Section -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="text-2xl font-bold mb-6">Comments ({{ recipe.comments.length }})</h2>

                        <!-- Add Comment Form -->
                        <div v-if="isAuthenticated" class="mb-6">
                            <form @submit.prevent="submitComment">
                                <textarea 
                                    v-model="newComment"
                                    rows="3"
                                    class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring focus:ring-orange-200"
                                    placeholder="Share your thoughts about this recipe..."
                                ></textarea>
                                <div class="mt-2 flex justify-end">
                                    <button type="submit" class="bg-orange-600 text-white px-6 py-2 rounded-lg hover:bg-orange-700 transition" :disabled="!newComment.trim()">
                                        Post Comment
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div v-else class="mb-6 p-4 bg-gray-50 rounded-lg text-center">
                            <p class="text-gray-600">Please <Link :href="route('login')" class="text-orange-600 hover:underline">login</Link> to leave a comment.</p>
                        </div>

                        <!-- Comments List -->
                        <div v-if="recipe.comments.length > 0" class="space-y-4">
                            <div v-for="comment in recipe.comments" :key="comment.id" class="border-b pb-4">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center">
                                                <span class="text-orange-600 font-bold text-sm">
                                                    {{ comment.user.name.charAt(0) }}
                                                </span>
                                            </div>
                                            <div>
                                                <Link :href="route('profile.show', comment.user.id)" class="font-semibold text-orange-600 hover:underline">
                                                    {{ comment.user.name }}
                                                </Link>
                                                <p class="text-gray-600 mt-1">{{ comment.comment }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-sm text-gray-400">{{ formatDate(comment.created_at) }}</span>
                                        <button v-if="isAuthenticated && user.id === comment.user_id" @click="deleteComment(comment.id)" class="text-red-500 hover:text-red-700">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-else class="text-center py-8 text-gray-500">
                            No comments yet. Be the first to comment!
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Share Modal -->
        <div v-if="showShareModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center">
            <div class="bg-white rounded-lg shadow-xl p-6 max-w-md w-full">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold">Share this recipe</h3>
                    <button @click="showShareModal = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="space-y-4">
                    <!-- Share Link -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Recipe Link</label>
                        <div class="flex">
                            <input 
                                type="text" 
                                readonly 
                                :value="shareUrl"
                                class="flex-1 rounded-l-lg border-gray-300 focus:border-orange-500"
                            >
                            <button @click="copyToClipboard" class="bg-orange-600 text-white px-4 rounded-r-lg hover:bg-orange-700">
                                Copy
                            </button>
                        </div>
                    </div>

                    <!-- Social Share Buttons -->
                    <div class="grid grid-cols-3 gap-2">
                        <a :href="`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(shareUrl)}`" target="_blank" class="bg-blue-600 text-white p-3 rounded-lg text-center hover:bg-blue-700">
                            Facebook
                        </a>
                        <a :href="`https://twitter.com/intent/tweet?url=${encodeURIComponent(shareUrl)}&text=${encodeURIComponent(recipe.title)}`" target="_blank" class="bg-sky-500 text-white p-3 rounded-lg text-center hover:bg-sky-600">
                            Twitter
                        </a>
                        <a :href="`https://pinterest.com/pin/create/button/?url=${encodeURIComponent(shareUrl)}&description=${encodeURIComponent(recipe.title)}`" target="_blank" class="bg-red-600 text-white p-3 rounded-lg text-center hover:bg-red-700">
                            Pinterest
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Link, router, usePage } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const page = usePage()
const props = defineProps({
    recipe: Object,
    isLiked: Boolean,
    isFavorited: Boolean
})

const newComment = ref('')
const showShareModal = ref(false)

const isAuthenticated = computed(() => {
    return page.props.auth?.user !== null && page.props.auth?.user !== undefined
})

const user = computed(() => {
    return page.props.auth?.user || null
})

const shareUrl = computed(() => {
    return window.location.href
})

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    })
}

const toggleLike = () => {
    if (!isAuthenticated.value) {
        router.get(route('login'))
        return
    }
    
    router.post(route('recipes.like', props.recipe.id), {}, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: (page) => {
            props.isLiked = page.props.isLiked
            props.recipe.likes_count = page.props.recipe.likes_count
        }
    })
}

const toggleFavorite = () => {
    if (!isAuthenticated.value) {
        router.get(route('login'))
        return
    }
    
    router.post(route('recipes.favorite', props.recipe.id), {}, {
        preserveState: true,
        preserveScroll: true
    })
}

const submitComment = () => {
    if (!newComment.value.trim()) return
    
    router.post(route('recipes.comments.store', props.recipe.id), {
        comment: newComment.value
    }, {
        preserveScroll: true,
        onSuccess: () => {
            newComment.value = ''
        }
    })
}

const deleteComment = (commentId) => {
    if (confirm('Are you sure you want to delete this comment?')) {
        router.delete(route('comments.destroy', commentId), {
            preserveScroll: true
        })
    }
}

const deleteRecipe = () => {
    if (confirm('Are you sure you want to delete this recipe?')) {
        router.delete(route('recipes.destroy', props.recipe.id))
    }
}

const copyToClipboard = () => {
    navigator.clipboard.writeText(shareUrl.value)
    alert('Link copied to clipboard!')
}
</script>