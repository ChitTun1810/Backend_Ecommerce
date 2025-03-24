<template>
    <Head title="Product Inquiries" />
    <AuthenticatedLayout>
        <Table :contacts="products?.data" />
        <Pagination :links="products?.links" />
    </AuthenticatedLayout>
</template>

<script setup>
import { Head, Link } from "@inertiajs/vue3";

import Table from "./Partials/Table.vue";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({ products: Object });
</script>

<style lang="scss" scoped></style>
