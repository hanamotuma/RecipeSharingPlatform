<template>
  <div class="relative ml-3">
    <!-- Dropdown trigger button -->
    <button
      type="button"
      class="flex items-center max-w-xs text-sm bg-white rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
      id="user-menu-button"
      aria-expanded="false"
      @click="dropdownOpen = !dropdownOpen"
    >
      <span class="sr-only">Open user menu</span>
      <div class="flex items-center space-x-3">
        <span class="text-gray-700">{{ user?.email }}</span>
        <!-- User avatar - you can replace with actual avatar -->
        <div class="w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center text-white">
          {{ userInitial }}
        </div>
      </div>
    </button>

    <!-- Dropdown menu -->
    <div
      v-if="dropdownOpen"
      class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
      role="menu"
      aria-orientation="vertical"
      aria-labelledby="user-menu-button"
      tabindex="-1"
    >
      <!-- Signed in as info -->
      <div class="px-4 py-2 text-xs text-gray-500 border-b border-gray-100">
        Signed in as <br />
        <span class="font-medium text-gray-900">{{ user?.email }}</span>
      </div>

      <!-- Menu items -->
      <Link
        href="/profile"
        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
        role="menuitem"
        tabindex="-1"
        @click="dropdownOpen = false"
      >
        My Profile
      </Link>

      <Link
        href="/favorites"
        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
        role="menuitem"
        tabindex="-1"
        @click="dropdownOpen = false"
      >
        My Favorites
      </Link>

      <Link
        href="/settings"
        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
        role="menuitem"
        tabindex="-1"
        @click="dropdownOpen = false"
      >
        Settings
      </Link>

      <form @submit.prevent="logout">
        <button
          type="submit"
          class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
          role="menuitem"
          tabindex="-1"
        >
          Logout
        </button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Link, usePage, router } from '@inertiajs/vue3'

const dropdownOpen = ref(false)

// Get user from Inertia shared data
const user = computed(() => usePage().props.auth.user)

// Get user initials for avatar
const userInitial = computed(() => {
  if (user.value?.name) {
    return user.value.name.charAt(0).toUpperCase()
  }
  return user.value?.email?.charAt(0).toUpperCase() || 'U'
})

// Logout function
const logout = () => {
  router.post(route('logout'))
}

// Close dropdown when clicking outside
const handleClickOutside = (event) => {
  if (!event.target.closest('.relative')) {
    dropdownOpen.value = false
  }
}

// Add/remove event listener for outside click
onMounted(() => {
  document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>