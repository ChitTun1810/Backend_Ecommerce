<template>
    <Head title="Banners" />
    <AuthenticatedLayout>
        <div class="mb-5 text-end">
            <Link class="btn-primary" :href="route('admin.banners.create')">
                Create New Banner
            </Link>
        </div>
        <Table :banners="banners?.data" />
        <Pagination :links="banners?.links" />
    </AuthenticatedLayout>
</template>

<script setup>
import { Head, Link } from "@inertiajs/vue3";

import Table from "./Partials/Table.vue";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({ banners: Object });
</script>

<style lang="scss" scoped></style>
