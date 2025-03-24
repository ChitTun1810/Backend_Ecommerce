<template>
    <Head title="Create Role" />
    <AuthenticatedLayout>
        <div class="w-full">
            <Form :permissions="permissions" />
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";
import Form from "./Partials/Form.vue";

defineProps({
    permissions: Array,
});
</script>

<style lang="scss" scoped></style>
