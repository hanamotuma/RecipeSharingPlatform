<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue';

const props = defineProps({
    align: {
        type: String,
        default: 'right',
    },
    width: {
        type: String,
        default: '48',
    },
    contentClasses: {
        type: String,
        default: 'py-1 bg-white',
    },
});

const open = ref(false);

const closeOnEscape = (e) => {
    if (open.value && e.key === 'Escape') {
        open.value = false;
    }
};

const toggleDropdown = () => {
    open.value = !open.value;
};

const stopPropagation = (e) => {
    e.stopPropagation();
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));
onUnmounted(() => document.removeEventListener('keydown', closeOnEscape));

const widthClass = computed(() => {
    return {
        '48': 'w-48',
        '64': 'w-64',
        '72': 'w-72',
        'full': 'w-full',
    }[props.width.toString()] || 'w-48';
});

const alignmentClasses = computed(() => {
    if (props.align === 'left') {
        return 'ltr:origin-top-left rtl:origin-top-right left-0';
    } else if (props.align === 'right') {
        return 'ltr:origin-top-right rtl:origin-top-left right-0';
    } else {
        return 'origin-top left-1/2 -translate-x-1/2';
    }
});
</script>

<template>
<div class="relative">

    <!-- Trigger Button - This is what user clicks (John Doe ▼) -->
    <div @click.stop="toggleDropdown">
        <slot name="trigger" />
    </div>

    <!-- Overlay - Click outside to close -->
    <div v-if="open" class="fixed inset-0 z-40" @click="open = false"></div>

    <!-- Dropdown Menu - The box containing all options -->
    <Transition
        enter-active-class="transition ease-out duration-200"
        enter-from-class="opacity-0 scale-95"
        enter-to-class="opacity-100 scale-100"
        leave-active-class="transition ease-in duration-75"
        leave-from-class="opacity-100 scale-100"
        leave-to-class="opacity-0 scale-95"
    >
        <div
            v-if="open"
            class="absolute z-50 mt-2 rounded-md shadow-lg"
            :class="[widthClass, alignmentClasses]"
            @click.stop="stopPropagation"
        >
            <!-- The white box containing all menu items -->
            <div class="rounded-md ring-1 ring-black ring-opacity-5" :class="contentClasses">
                <slot name="content" />
            </div>
        </div>
    </Transition>

</div>
</template>