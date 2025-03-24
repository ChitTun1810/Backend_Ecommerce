<template>
    <Head title="Customers" />
    <AuthenticatedLayout>
        <Table :customers="customers?.data" />
        <Pagination :links="customers?.links" />
    </AuthenticatedLayout>
</template>

<script setup>
import { Link, Head } from "@inertiajs/vue3";
import Table from "./Partials/Table.vue";
import Pagination from "@/Components/Pagination.vue";
defineProps({
    customers: Object,
});
</script>

<style lang="scss" scoped></style>
