<template>
    <div class="relative shadow-md sm:rounded-lg mb-5">
        <DataTable
            class="data-table text-sm"
            v-model:selection="selected"
            :value="customers"
            dataKey="id"
        >
            <Column field="name" header="Name"> </Column>
            <Column field="email" header="Email"></Column>
            <Column field="phone" header="Phone"></Column>
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
                                    route(
                                        'admin.customers.show',
                                        slotProps.data.id
                                    )
                                "
                            >
                                <i
                                    class="pi pi-info-circle w-5 text-sm me-2"
                                ></i
                                >Show
                            </DropdownLink>
                        </template>
                    </Dropdown>
                </template>
            </Column>
        </DataTable>
    </div>
</template>

<script setup>
import { router, Link } from "@inertiajs/vue3";
import { ref } from "vue";
const selected = ref();

import DataTable from "primevue/datatable";
import Column from "primevue/column";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";

defineProps({
    customers: Array,
});
</script>

<style lang="scss" scoped></style>
P
