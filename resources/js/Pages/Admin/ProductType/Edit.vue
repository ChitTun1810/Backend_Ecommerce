<template>
    <Head title="Edit Product Type" />

    <AuthenticatedLayout>
        <div class="w-full">
            <Form :editValue="productType" :categories="categories" />
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";

import Form from "./Partials/Form.vue";

const props = defineProps({ productType: Object, categories: Array });
</script>

<style lang="scss" scoped></style>
