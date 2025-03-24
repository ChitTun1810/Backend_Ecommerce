<template>
    <Head title="Create City" />
    <AuthenticatedLayout>
        <div class="w-full">
            <Form />
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";
import Form from "./Partials/Form.vue";
</script>

<style lang="scss" scoped></style>
