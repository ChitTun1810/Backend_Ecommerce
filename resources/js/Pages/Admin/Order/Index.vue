<template>
    <Head title="Orders" />
    <AuthenticatedLayout>
        <Table
            :payment-status="paymentStatus"
            :delivery-status="deliveryStatus"
            :params="params"
            :orders="orders?.data"
        />
        <Pagination :links="orders?.links" />
    </AuthenticatedLayout>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";
import Table from "./Partials/Table.vue";

const props = defineProps({
    orders: Object,
    paymentStatus: Object,
    deliveryStatus: Object,
    params: Object,
});
</script>
