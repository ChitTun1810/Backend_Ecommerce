<template>
    <Head title="Edit Role" />
    <AuthenticatedLayout>
        <div class="w-full">
            <Form :edit-value="role" :permissions="permissions" />
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";
import Form from "./Partials/Form.vue";

defineProps({
    permissions: Array,
    role: Object,
    errors: Object,
});
</script>

<style lang="scss" scoped></style>
