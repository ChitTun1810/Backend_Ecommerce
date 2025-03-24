<template>
    <Head title="Edit Cpuntry" />

    <AuthenticatedLayout>
        <div class="w-full">
            <Form :editValue="country" />
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";

import Form from "./Partials/Form.vue";

const props = defineProps({ country: Object });
</script>

<style lang="scss" scoped></style>
