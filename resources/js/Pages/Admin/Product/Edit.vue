<template>
    <Head title="Edit Product" />
    <AuthenticatedLayout>
        <Form
            :categories="categories"
            :edit-value="product"
            :brands="brands"
            :countries="countries"
            :productTypes="productTypes"
        />
    </AuthenticatedLayout>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";

import Form from "./Partials/Form.vue";

const props = defineProps({
    categories: Array,
    brands: Array,
    product: Object,
    countries: Array,
    productTypes: Array,
});
</script>

<style lang="scss" scoped></style>
