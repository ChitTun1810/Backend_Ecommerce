<template>
    <Head title="Edit City" />

    <AuthenticatedLayout>
        <div class="w-full">

        <Form :cities="cities" :editValue="township" />
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";

import Form from "./Partials/Form.vue";

const props = defineProps({ cities: Array, township: Object });
</script>

<style lang="scss" scoped></style>
