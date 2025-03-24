<template>
    <Head title="Countries" />
    <AuthenticatedLayout>
        <div class="mb-5 text-end">
            <Link class="btn-primary" :href="route('admin.countries.create')">
                Create New Country
            </Link>
        </div>
        <Table :countries="countries?.data" />
        <Pagination :links="countries?.links" />
    </AuthenticatedLayout>
</template>

<script setup>
import { Head, Link } from "@inertiajs/vue3";
import Table from "./Partials/Table.vue";
import Pagination from "@/Components/Pagination.vue";

defineProps({ countries: Object });
</script>

<style lang="scss" scoped></style>
