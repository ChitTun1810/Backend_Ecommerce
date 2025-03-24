<template>
    <div class="relative shadow-md sm:rounded-lg mb-5">
        <DataTable
            class="data-table text-sm"
            v-model:selection="selectedProduct"
            :value="products"
            dataKey="id"
        >
            <template #header>
                <ActionBox
                    @is-delete="handleDeleteAll"
                    :categories="categories"
                    :brands="brands"
                    :params="params"
                />
            </template>
            <Column selectionMode="multiple" headerStyle="width: 3rem"></Column>

            <Column field="name" header="Name"> </Column>
            <Column field="brand_id" header="Brand">
                <template #body="slotProps">
                    {{ slotProps.data.brand?.name ?? "-" }}
                </template>
            </Column>
            <Column field="category_id" header="Category">
                <template #body="slotProps">
                    {{
                        slotProps.data?.category
                            ? slotProps.data?.category?.name
                            : ""
                    }}
                </template>
            </Column>
            <Column header="Product Type">
                <template #body="slotProps">
                    {{
                        slotProps.data?.product_type
                            ? slotProps.data?.product_type?.name
                            : ""
                    }}
                </template>
            </Column>
            <Column
                field="price"
                class="text-end"
                :pt="{
                    headerContent: { class: 'justify-end' },
                }"
                header="Price"
            >
                <template #body="slotProps">
                    ${{ slotProps.data.price }}
                </template>
            </Column>
            <Column
                field="stocks"
                class="text-end"
                :pt="{
                    headerContent: { class: 'justify-end' },
                }"
                header="Stocks"
            ></Column>

            <Column
                field="is_new_arrival"
                class="text-end"
                :pt="{
                    headerContent: { class: 'justify-end' },
                }"
                header="New Arrival"
            >
                <template #body="slotProps">
                    <Switch
                        v-model="slotProps.data.is_new_arrival"
                        size="20px"
                        @change="newArrivalHandler(slotProps.data.id)"
                    />
                </template>
            </Column>
            <Column header="Country" class="text-end">
                <template #body="slotProps">
                    {{ slotProps.data.country?.name }}
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
                                    route(
                                        'admin.products.edit',
                                        slotProps.data.id
                                    )
                                "
                            >
                                <i class="pi pi-pencil w-5 text-sm me-2"></i
                                >Edit
                            </DropdownLink>
                            <DropdownLink
                                :href="
                                    route(
                                        'admin.products.show',
                                        slotProps.data.id
                                    )
                                "
                            >
                                <i
                                    class="pi pi-info-circle w-5 text-sm me-2"
                                ></i
                                >Show
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
import { showSuccessToast, showToast, Switch } from "vant";
import { ref } from "vue";

import DataTable from "primevue/datatable";
import Column from "primevue/column";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import ActionBox from "./ActionBox.vue";

defineProps({
    products: Array,
    brands: Array,
    categories: Array,
    params: Object,
});

const preserveOption = {
    preserveScroll: true,
    preserveState: true,
};

const selectedProduct = ref([]);

const handleDelete = async (id) => {
    let x = confirm("Are u sure to delete");

    if (x) {
        router.delete(route("admin.products.destroy", id), {
            ...preserveOption,
            onSuccess: () => {
                showSuccessToast("Success!");
            },
        });
    }
};

const newArrivalHandler = async (id) => {
    router.post(route("admin.products.new-arrival", id), {}, preserveOption);
};

const handleDeleteAll = () => {
    let ids = selectedProduct.value.map((el) => el.id);
    if (ids.length <= 0) {
        showToast("Pleas selected products");
        return;
    }
    let x = confirm("Are u sure to delete");
    if (x) {
        router.post(
            route("admin.products.delete-all"),
            {
                ids: ids,
                _method: "DELETE",
            },
            {
                ...preserveOption,
                onSuccess: () => {
                    showSuccessToast("Success!");
                },
            }
        );
    }
};
</script>

<style lang="scss" scoped></style>
