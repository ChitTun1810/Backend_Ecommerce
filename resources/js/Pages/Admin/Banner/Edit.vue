<template>
    <Head title="Edit Brand" />

    <AuthenticatedLayout>
        <div class="w-full">

        <Form :editValue="banner" />
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";

import Form from "./Partials/Form.vue";

const props = defineProps({ banner: Object });
</script>

<style lang="scss" scoped></style>
