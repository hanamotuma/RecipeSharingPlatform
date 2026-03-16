<template>
    <div class="min-h-screen bg-gray-100">
        <!-- Navigation -->
        <nav class="bg-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center space-x-8">
                        <!-- Logo -->
                        <Link :href="route('home')" class="flex-shrink-0">
                            <h1 class="text-2xl font-bold text-orange-600">RecipeShare</h1>
                        </Link>

                        <!-- Navigation Links -->
                        <div class="hidden md:flex md:space-x-8">
                            <NavLink :href="route('home')" :active="$page.url === '/'">
                                Home
                            </NavLink>
                            <NavLink v-if="isAuthenticated" :href="route('recipes.create')" :active="$page.url === '/recipes/create'">
                                Create Recipe
                            </NavLink>
                        </div>
                    </div>

                    <!-- Center - Search Bar -->
                    <div class="flex-1 max-w-lg mx-4">
                        <div class="relative">
                            <input 
                                v-model="searchQuery"
                                @keyup.enter="search"
                                type="text" 
                                placeholder="Search recipes..."
                                class="w-full rounded-lg border-gray-300 pl-4 pr-10 py-2 focus:border-orange-500 focus:ring focus:ring-orange-200"
                            >
                            <button @click="search" class="absolute right-2 top-2 text-gray-400 hover:text-orange-600">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Right side - Profile / Auth -->
                    <div class="flex items-center space-x-4">
                        <!-- If user is logged in - Show profile dropdown -->
                        <div v-if="isAuthenticated">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <button class="flex items-center space-x-2 text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none">
                                        <!-- Profile Image -->
                                        <div class="w-8 h-8 rounded-full bg-orange-500 flex items-center justify-center text-white font-bold">
                                            {{ userInitials }}
                                        </div>
                                        <span class="hidden md:inline-block">{{ user.name }}</span>
                                        <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </template>

                                <template #content>
                                    <!-- Dropdown menu items -->
                                    <div class="px-4 py-2 text-xs text-gray-500 border-b">
                                        Signed in as<br>
                                        <span class="font-medium text-gray-900">{{ user.email }}</span>
                                    </div>

                                    <DropdownLink :href="route('profile.show', user.id)">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            <span>My Profile</span>
                                        </div>
                                    </DropdownLink>

                                    <DropdownLink :href="route('favorites.index')">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                            </svg>
                                            <span>My Favorites</span>
                                        </div>
                                    </DropdownLink>

                                    <DropdownLink :href="route('profile.edit')">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            <span>Settings</span>
                                        </div>
                                    </DropdownLink>

                                    <div class="border-t border-gray-100 my-1"></div>

                                    <DropdownLink :href="route('logout')" method="post" as="button">
                                        <div class="flex items-center space-x-2 text-red-600 hover:text-red-700">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                            </svg>
                                            <span>Logout</span>
                                        </div>
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </div>
                        
                        <!-- If user is NOT logged in - Show Sign Up/Login buttons -->
                        <div v-else class="flex items-center space-x-3">
                            <Link :href="route('login')" class="text-gray-600 hover:text-gray-900 px-3 py-2 text-sm font-medium">
                                Login
                            </Link>
                            <Link :href="route('register')" class="bg-orange-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-orange-700 transition">
                                Sign Up
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Flash Messages -->
                <div v-if="$page.props.flash?.success" class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ $page.props.flash.success }}
                </div>
                <div v-if="$page.props.flash?.error" class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    {{ $page.props.flash.error }}
                </div>
                
                <slot />
            </div>
        </main>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Link, router, usePage } from '@inertiajs/vue3'
import Dropdown from '@/Components/Dropdown.vue'
import DropdownLink from '@/Components/DropdownLink.vue'
import NavLink from '@/Components/NavLink.vue'

const page = usePage()
const searchQuery = ref('')

const isAuthenticated = computed(() => {
    return page.props.auth?.user !== null && page.props.auth?.user !== undefined
})

const user = computed(() => {
    return page.props.auth?.user || null
})

const userInitials = computed(() => {
    if (!user.value) return ''
    return user.value.name
        .split(' ')
        .map(word => word[0])
        .join('')
        .toUpperCase()
        .substring(0, 2)
})

const search = () => {
    if (searchQuery.value.trim()) {
        router.get(route('recipes.index'), { search: searchQuery.value }, {
            preserveState: true,
            preserveScroll: true
        })
    }
}
</script>