<template>
    <div class="relative shadow-md sm:rounded-lg mb-5">
        <DataTable
            class="data-table text-sm"
            v-model:selection="selected"
            :value="users"
            dataKey="id"
        >
            <Column field="name" header="Name"> </Column>
            <Column field="email" header="Email"></Column>
            <Column header="Role">
                <template #body="slotProps">
                    <div v-for="role in slotProps.data.roles" :key="role.id">
                        {{ role.name }}
                    </div>
                </template>
            </Column>
            <Column
                class="text-end"
                :pt="{
                    headerContent: { class: 'justify-end' },
                }"
                header="Actions"
            >
                <template #body="slotProps">
                    <Dropdown align="right" width="32">
                        <template #trigger>
                            <span class="inline-flex rounded-md">
                                <button type="button" class="">
                                    <i class="pi pi-ellipsis-h"></i>
                                </button>
                            </span>
                        </template>

                        <template #content>
                            <DropdownLink
                                :href="
                                    route('admin.users.edit', slotProps.data.id)
                                "
                            >
                                <i class="pi pi-pencil w-5 text-sm me-2"></i
                                >Edit
                            </DropdownLink>
                            <button
                                @click="handleDelete(slotProps.data.id)"
                                class="dropdown-item"
                            >
                                <i class="pi pi-trash w-5 text-sm me-2"></i
                                >Delete
                            </button>
                        </template>
                    </Dropdown>
                </template>
            </Column>
        </DataTable>
    </div>
</template>

<script setup>
import { router } from "@inertiajs/vue3";
import { ref } from "vue";
import { showSuccessToast } from "vant";
const selected = ref();

import DataTable from "primevue/datatable";
import Column from "primevue/column";

import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";

defineProps({
    users: Array,
});

const handleDelete = async (id) => {
    let x = confirm("Are u sure to delete");

    if (x) {
        router.delete(route("admin.users.destroy", id), {
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
