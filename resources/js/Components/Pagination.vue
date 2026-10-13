
<template>
    <div v-if="links.length > 3" class="flex flex-wrap justify-center gap-1">
        <template v-for="(link, key) in links" :key="key">
            <div
                v-if="link.url === null"
                class="px-4 py-2 text-gray-400 bg-white border rounded-lg"
                v-html="link.label"
            />
            <Link
                v-else
                :href="link.url"
                class="px-4 py-2 text-gray-700 bg-white border rounded-lg hover:bg-orange-50 hover:text-orange-600 transition"
                :class="{ 'bg-orange-600 text-white hover:bg-orange-700 hover:text-white': link.active }"
                v-html="link.label"
            />
        </template>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    links: {
        type: Array,
        required: true
    }
})
</script>