<template>
    <Head title="Brands" />
    <AuthenticatedLayout>
        <div class="mb-5 text-end">
            <Link class="btn-primary" :href="route('admin.brands.create')">
                Create New Brand
            </Link>
        </div>
        <Table :brands="brands?.data" />
        <Pagination :links="brands?.links" />
    </AuthenticatedLayout>
</template>

<script setup>
import { Head, Link } from "@inertiajs/vue3";

import Table from "./Partials/Table.vue";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({ brands: Object });
</script>

<style lang="scss" scoped></style>
