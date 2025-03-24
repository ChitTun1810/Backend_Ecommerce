<template>
    <div class="relative shadow-md sm:rounded-lg mb-5">
        <DataTable class="data-table text-sm" :value="logs" dataKey="id">
            <Column field="log_name" header="Log name" />
            <Column field="description" header="Description" />
            <Column header="Causer">
                <template #body="slotProps">
                    <div class="flex items-center">
                        {{ slotProps.data.user.name }}
                    </div>
                </template>
            </Column>
            <Column field="date_format" header="Data & Time" />
        </DataTable>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";

import DataTable from "primevue/datatable";
import Column from "primevue/column";

defineProps({
    logs: Array,
});
</script>

<style lang="scss" scoped></style>
