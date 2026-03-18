<!-- resources/js/Pages/Profile/Edit.vue -->
<template>
    <AppLayout>
        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="text-2xl font-bold mb-6"><Link :href="route('profile.edit')">Edit Profile</Link></h2>

                        <form @submit.prevent="updateProfile">
                            <!-- Name -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                                <input 
                                    type="text" 
                                    v-model="form.name"
                                    class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring focus:ring-orange-200"
                                    :class="{ 'border-red-500': form.errors.name }"
                                >
                                <p v-if="form.errors.name" class="text-red-500 text-xs mt-1">{{ form.errors.name }}</p>
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                                <input 
                                    type="email" 
                                    v-model="form.email"
                                    class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring focus:ring-orange-200"
                                    :class="{ 'border-red-500': form.errors.email }"
                                >
                                <p v-if="form.errors.email" class="text-red-500 text-xs mt-1">{{ form.errors.email }}</p>
                            </div>

                            <!-- Bio -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Bio</label>
                                <textarea 
                                    v-model="form.bio"
                                    rows="4"
                                    class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring focus:ring-orange-200"
                                    :class="{ 'border-red-500': form.errors.bio }"
                                    placeholder="Tell us about yourself and your cooking experience..."
                                ></textarea>
                                <p v-if="form.errors.bio" class="text-red-500 text-xs mt-1">{{ form.errors.bio }}</p>
                            </div>
                              
                            
                            <!-- Divider -->
                            <div class="border-t border-gray-200 my-6"></div>
                            <h3 class="text-lg font-semibold mb-4">Change Password </h3>

                            <!-- Current Password -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Current Password</label>
                                <input 
                                    type="password" 
                                    v-model="form.current_password"
                                    class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring focus:ring-orange-200"
                                    :class="{ 'border-red-500': form.errors.current_password }"
                                >
                                <p v-if="form.errors.current_password" class="text-red-500 text-xs mt-1">{{ form.errors.current_password }}</p>
                            </div>

                            <!-- New Password -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">New Password</label>
                                <input 
                                    type="password" 
                                    v-model="form.new_password"
                                    class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring focus:ring-orange-200"
                                    :class="{ 'border-red-500': form.errors.new_password }"
                                >
                            </div>

                            <!-- Confirm New Password -->
                            <div class="mb-6">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Confirm New Password</label>
                                <input 
                                    type="password" 
                                    v-model="form.new_password_confirmation"
                                    class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring focus:ring-orange-200"
                                >
                                <p v-if="form.errors.new_password" class="text-red-500 text-xs mt-1">{{ form.errors.new_password }}</p>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end space-x-4">
                                <Link :href="route('profile.show', $page.props.auth.user.id)" 
                                      class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                    Cancel
                                </Link>
                                <button 
                                    type="submit"
                                    class="bg-orange-600 text-white px-6 py-3 rounded-lg hover:bg-orange-700 transition disabled:opacity-50"
                                    :disabled="form.processing"
                                >
                                    {{ form.processing ? 'Saving...' : 'Save Changes' }}
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
import { useForm, Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
    user: Object
})

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    bio: props.user.bio || '',
    current_password: '',
    new_password: '',
    new_password_confirmation: ''
})

const updateProfile = () => {
    form.put(route('profile.update'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset('current_password', 'new_password', 'new_password_confirmation')
        }
    })
}
</script>