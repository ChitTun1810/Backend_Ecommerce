<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'flex items-center p-2 text-white rounded-lg hover:bg-slate-400 group transition duration-150 ease-in-out'
        : 'flex bg-blue-100 items-center p-2 text-white rounded-lg hover:bg-slate-400 group transition duration-150 ease-in-out transition duration-150 ease-in-out'
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
