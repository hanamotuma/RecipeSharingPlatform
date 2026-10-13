<template>
    <Transition
        enter-active-class="transition ease-out duration-300"
        enter-from-class="transform opacity-0 translate-y-2"
        enter-to-class="transform opacity-100 translate-y-0"
        leave-active-class="transition ease-in duration-200"
        leave-from-class="transform opacity-100 translate-y-0"
        leave-to-class="transform opacity-0 translate-y-2"
    >
        <div v-if="show" class="fixed bottom-5 right-5 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            ✅ {{ message }}
        </div>
    </Transition>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const show = ref(false);
const message = ref('');

// Watch for flash messages from Laravel
watch(() => page.props?.flash?.message, (newMessage) => {
    if (newMessage) {
        message.value = newMessage;
        show.value = true;
        setTimeout(() => (show.value = false), 3000);
    }
}, { immediate: true });
</script>