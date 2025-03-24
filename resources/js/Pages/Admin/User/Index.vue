<template>
    <Head title="User" />
    <AuthenticatedLayout>
        <div class="mb-5 text-end">
            <Link class="btn-primary" :href="route('admin.users.create')">
                Create New User
            </Link>
        </div>
        <Table :users="users?.data" />
        <Pagination :links="users?.links" />
    </AuthenticatedLayout>
</template>

<script setup>
import { Link, Head } from "@inertiajs/vue3";
import Table from "./Partials/Table.vue";
import Pagination from "@/Components/Pagination.vue";
defineProps({
    users: Object,
});
</script>

<style lang="scss" scoped></style>
