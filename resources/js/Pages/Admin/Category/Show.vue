<template>
    <Head title="Show Category" />
    <AuthenticatedLayout>
        <h4 class="text-xl font-bold mb-6">Show Category</h4>
        <div class="border p-3 rounded-md bg-gray-50 mb-4">
            <div class="mb-5">Parent name : {{ category.name }}</div>
            <div class="mb-2" v-if="category.image">
                <h6 class="mb-2">Image Preview</h6>
                <img class="h-60 rounded-md" :src="category.image" />
            </div>
        </div>
        <ThreeTable :categories="childCategories" />
    </AuthenticatedLayout>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";
import ThreeTable from "./Partials/ThreeTable.vue";

const props = defineProps({ category: Object, childCategories: Array });
</script>

<style lang="scss" scoped></style>
