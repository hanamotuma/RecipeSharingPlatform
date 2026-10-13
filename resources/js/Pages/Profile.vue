<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'

defineProps({
    user: Object
})
</script>

<template>
    <AppLayout>
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">My Profile</h1>

    <div class="bg-white shadow rounded p-4">
        <p><strong>Name:</strong> {{ user.name }}</p>
        <p><strong>Email:</strong> {{ user.email }}</p>
    </div>
</div>
    </AppLayout>
</template>