<template>
    <Head title="Create User" />
    <AuthenticatedLayout>
        <div class="w-full">
            <Form :roles="roles" />
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";
import Form from "./Partials/Form.vue";

defineProps({
    roles: Array,
});
</script>

<style lang="scss" scoped></style>
