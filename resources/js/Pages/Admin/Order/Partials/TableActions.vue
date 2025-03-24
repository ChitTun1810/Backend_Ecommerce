<template>
    <Dropdown align="right" width="32">
        <template #trigger>
            <span class="inline-flex rounded-md">
                <button type="button" class="">
                    <i class="pi pi-ellipsis-h"></i>
                </button>
            </span>
        </template>

        <template #content>
            <DropdownLink :href="route('admin.orders.show', id)">
                <i class="pi pi-info-circle w-5 text-sm me-2"></i>Show
            </DropdownLink>
        </template>
    </Dropdown>
</template>

<script setup>
import { router } from "@inertiajs/vue3";
import { showSuccessToast } from "vant";

import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";

defineProps({
    id: Number,
});

const handleDelete = async (id) => {
    let x = confirm("Are u sure to delete");

    if (x) {
        router.delete(route("admin.categories.destroy", id), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                showSuccessToast("Success!");
            },
        });
    }
};
</script>

<style lang="scss" scoped></style>
