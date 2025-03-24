<template>
    <Head title="Edit City" />

    <AuthenticatedLayout>
        <div class="w-full">

        <Form :editValue="city" />
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";

import Form from "./Partials/Form.vue";

const props = defineProps({ city: Object });
</script>

<style lang="scss" scoped></style>
