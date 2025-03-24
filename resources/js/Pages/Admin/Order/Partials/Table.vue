<template>
    <div class="relative shadow-md sm:rounded-lg mb-5">
        <DataTable class="data-table text-sm" :value="orders" dataKey="id">
            <template #header>
                <ActionBox
                    :deliveryStatus="deliveryStatus"
                    :paymentStatus="paymentStatus"
                    :params="params"
                />
            </template>
            <Column field="order_number" header="Order Number" />
            <Column
                field="delivery_fee"
                class="text-end"
                :pt="{
                    headerContent: { class: 'justify-end' },
                }"
                header="Delivery Fee"
            />
            <Column
                field="exchange_rate"
                class="text-end"
                :pt="{
                    headerContent: { class: 'justify-end' },
                }"
                header="Exchange Rate"
            />
            <Column
                field="usd_total"
                class="text-end"
                :pt="{
                    headerContent: { class: 'justify-end' },
                }"
                header="USD Total"
            />
            <Column
                field="total"
                class="text-end"
                :pt="{
                    headerContent: { class: 'justify-end' },
                }"
                header="Total"
            />
            <Column
                field="grand_total"
                class="text-end"
                :pt="{
                    headerContent: { class: 'justify-end' },
                }"
                header="Grand Total"
            />
            <Column
                field="delivery_status"
                class="text-end"
                :pt="{
                    headerContent: { class: 'justify-end' },
                }"
                header="Delivery Status"
            >
                <template #body="slotProps">
                    <span
                        class="uppercase text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300"
                        :class="
                            slotProps.data.delivery_status != 'confirmed'
                                ? 'bg-yellow-100 text-yellow-800'
                                : 'bg-blue-100 text-blue-800'
                        "
                    >
                        {{ slotProps.data.delivery_status }}
                    </span>
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
import ActionBox from "./ActionBox.vue";

defineProps({
    orders: Array,
    deliveryStatus: Object,
    paymentStatus: Object,
    params: Object,
});
</script>

<style lang="scss" scoped></style>
