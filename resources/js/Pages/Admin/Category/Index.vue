<template>
    <Head title="Categories" />
    <AuthenticatedLayout>
        <div class="mb-5 text-end">
            <div>
                <Link
                    class="btn-primary"
                    :href="route('admin.categories.create')"
                >
                    Create New Category
                </Link>
            </div>
        </div>
        <Table :categories="categories?.data" />
        <Pagination :links="categories?.links" />
    </AuthenticatedLayout>
</template>

<script setup>
import { Head, Link } from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";
import Table from "./Partials/Table.vue";

const props = defineProps({ categories: Object, selectCategory: Array });
</script>

<style lang="scss" scoped></style>
