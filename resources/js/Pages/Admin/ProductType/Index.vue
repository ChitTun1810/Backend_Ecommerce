<template>
    <Head title="Product Types" />
    <AuthenticatedLayout>
        <div class="mb-5 text-end">
            <Link
                class="btn-primary"
                :href="route('admin.product-types.create')"
            >
                Create New Type
            </Link>
        </div>
        <Table :productTypes="productTypes?.data" />
        <Pagination :links="productTypes?.links" />
    </AuthenticatedLayout>
</template>

<script setup>
import { Head, Link } from "@inertiajs/vue3";

import Table from "./Partials/Table.vue";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({ productTypes: Object });
</script>

<style lang="scss" scoped></style>
