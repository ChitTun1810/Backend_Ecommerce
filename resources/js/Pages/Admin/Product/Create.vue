<template>
    <Head title="Create Product" />
    <AuthenticatedLayout>
        <Form
            :categories="categories"
            :brands="brands"
            :countries="countries"
            :productTypes="productTypes"
        />
    </AuthenticatedLayout>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";

import Form from "./Partials/Form.vue";

defineProps({
    categories: Array,
    brands: Array,
    countries: Array,
    productTypes: Array,
});
</script>

<style lang="scss" scoped></style>
