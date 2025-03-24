<template>
    <Head title="Edit User" />
    <AuthenticatedLayout>
        <div class="w-full">
            <Form :edit-value="user" :roles="roles" />
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";
import Form from "./Partials/Form.vue";

defineProps({
    roles: Array,
    user: Object,
});
</script>

<style lang="scss" scoped></style>
