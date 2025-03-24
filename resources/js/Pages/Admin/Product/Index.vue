<template>
    <Head title="Products" />
    <AuthenticatedLayout>
        <div class="mb-5 text-end">
            <a href="/products/export" class="btn btn-primary me-3">
                Export Product
            </a>
            <Link
                class="btn-primary me-3"
                :href="route('admin.products.browse')"
            >
                Import New Product
            </Link>
            <Link class="btn-primary" :href="route('admin.products.create')">
                Create New Product
            </Link>
        </div>
        <Table
            :products="products?.data"
            :brands="brands"
            :categories="categories"
            :params="params"
        />
        <Pagination :links="products?.links" />
    </AuthenticatedLayout>
</template>

<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import Table from "./Partials/Table.vue";
import Pagination from "@/Components/Pagination.vue";

const handleExportProduct = () => {
    router.post(route("admin.products.export"));
};

defineProps({
    products: Object,
    brands: Array,
    categories: Array,
    params: Object,
});
</script>

<style lang="scss" scoped></style>
