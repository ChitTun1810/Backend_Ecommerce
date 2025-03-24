<template>
    <nav class="relative flex justify-end">
        <template v-for="link in links" :key="link.label">
            <Link
                preserve-scroll
                preserve-state
                :href="link.url ?? ''"
                v-html="link.label"
                class="flex items-center justify-center px-3 h-8 text-sm rounded-lg text-gray-600"
                :class="{ 'bg-blue-600 text-white': link.active }"
            />
        </template>
    </nav>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({ links: Array });
</script>

<style lang="scss" scoped></style>
