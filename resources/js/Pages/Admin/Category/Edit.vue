<template>
    <Head title="Edit Category" />

    <AuthenticatedLayout>
        <div>
            <Form :editValue="category" :categories="categories" />
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";

import Form from "./Partials/Form.vue";

const props = defineProps({ category: Object, categories: Array });
</script>

<style lang="scss" scoped></style>
