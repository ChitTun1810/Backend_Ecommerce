<template>
    <Head title="Show Customer" />
    <AuthenticatedLayout>
        <h4 class="text-xl font-bold mb-6">Show Customer</h4>
        <div class="border p-3 rounded-md bg-gray-50 mb-4">
            <div class="mb-5">Name : {{ customer.name }}</div>
            <div class="mb-5">Phone : {{ customer.phone }}</div>
            <div>Email : {{ customer.email }}</div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";
const props = defineProps({ customer: Object });
</script>

<style lang="scss" scoped></style>
