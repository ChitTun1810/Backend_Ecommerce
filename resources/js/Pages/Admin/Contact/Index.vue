<template>
    <Head title="Contact Us" />
    <AuthenticatedLayout>
        <Table :contacts="contacts?.data" />
        <Pagination :links="contacts?.links" />
    </AuthenticatedLayout>
</template>

<script setup>
import { Head, Link } from "@inertiajs/vue3";

import Table from "./Partials/Table.vue";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({ contacts: Object });
</script>

<style lang="scss" scoped></style>
