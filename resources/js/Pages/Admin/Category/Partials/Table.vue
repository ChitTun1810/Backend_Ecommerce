<template>
    <div class="relative shadow-md sm:rounded-lg mb-5">
        <DataTable class="data-table text-sm" :value="categories" dataKey="id">
            <Column field="name" header="Name">
                <template #body="slotProps">
                    <div class="flex items-center">
                        <img
                            class="w-8 h-8 object-cover me-2 rounded"
                            v-if="slotProps.data.image"
                            :src="slotProps.data.image"
                            :alt="slotProps.data.name"
                        />
                        {{ slotProps.data.name }}
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
                    <TableActions :id="slotProps?.data.id" />
                </template>
            </Column>
        </DataTable>
    </div>
</template>

<script setup>
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import TableActions from "./TableActions.vue";

defineProps({
    categories: Array,
});
</script>

<style lang="scss" scoped></style>
