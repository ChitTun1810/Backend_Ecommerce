<template>
    <Head title="Show Contact" />
    <AuthenticatedLayout>
        <h4 class="text-xl font-bold mb-6">Show Contact</h4>
        <div class="border p-3 rounded-md bg-gray-50 mb-4">
            <div class="mb-5">Name : {{ contact.name }}</div>
            <div class="mb-5">Email : {{ contact.email }}</div>
            <div class="mb-5">Phone : {{ contact.phone }}</div>
            <div class="mb-5">Subject : {{ contact.subject }}</div>
            <div class="mb-5">Message : {{ contact.message }}</div>
        </div>
        <!-- <div>
            <PrimaryButton>
                <i class="pi pi-send me-2 text-sm"></i> Replay
            </PrimaryButton>
        </div> -->
    </AuthenticatedLayout>
</template>
<script setup>
import { Head } from "@inertiajs/vue3";

defineProps({
    contact: Object,
});
</script>
