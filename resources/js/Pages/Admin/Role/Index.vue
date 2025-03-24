<template>
    <Head title="Role" />
    <AuthenticatedLayout>
        <div class="mb-5 text-end">
            <Link class="btn-primary" :href="route('admin.roles.create')">
                Create New Role
            </Link>
        </div>
        <Table :roles="roles?.data" />
        <Pagination :links="roles?.links" />
    </AuthenticatedLayout>
</template>

<script setup>
import { Link, Head } from "@inertiajs/vue3";
import Table from "./Partials/Table.vue";
import Pagination from "@/Components/Pagination.vue";
defineProps({
    roles: Object,
});
</script>

<style lang="scss" scoped></style>
