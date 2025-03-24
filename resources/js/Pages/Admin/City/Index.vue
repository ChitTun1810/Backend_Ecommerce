<template>
    <Head title="Cities" />
    <AuthenticatedLayout>
        <div class="mb-5 text-end">
            <Link class="btn-primary" :href="route('admin.cities.create')">
                Create New City
            </Link>
        </div>
        <Table :cities="cities?.data" />
        <Pagination :links="cities?.links" />
    </AuthenticatedLayout>
</template>

<script setup>
import { Head, Link } from "@inertiajs/vue3";

import Table from "./Partials/Table.vue";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({ cities: Object });
</script>

<style lang="scss" scoped></style>
