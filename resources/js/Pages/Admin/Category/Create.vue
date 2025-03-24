<template>
    <Head title="Create Category" />

    <AuthenticatedLayout>
        <div class="w-full">
            <Form :categories="categories" />
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";

import Form from "./Partials/Form.vue";

const props = defineProps({ categories: Array });
</script>

<style lang="scss" scoped></style>
