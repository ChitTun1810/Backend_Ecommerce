<template>
    <Head title="Create Township" />
    <AuthenticatedLayout>
        <div class="w-full">
            <Form :cities="cities"/>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";
import Form from "./Partials/Form.vue";

defineProps({ cities: Array });
</script>

<style lang="scss" scoped></style>
