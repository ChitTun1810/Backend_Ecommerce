<template>
    <div class="relative shadow-md sm:rounded-lg mb-5">
        <DataTable class="data-table text-sm" :value="contacts" dataKey="id">
            <Column field="name" header="Name">
                <template #body="slotProps">
                    <div class="flex items-center">
                        {{ slotProps.data.name }}
                    </div>
                </template>
            </Column>
            <Column field="email" header="Email" />
            <Column field="phone" header="Phone" />
            <Column field="except_subject" header="Subject" />
            <Column field="except_message" header="Message" />
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
                                        'admin.contact.show',
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
// import { ref } from "vue";
import { showSuccessToast } from "vant";

import DataTable from "primevue/datatable";
import Column from "primevue/column";

import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";

defineProps({
    contacts: Array,
});

const handleDelete = async (id) => {
    let x = confirm("Are u sure to delete");

    if (x) {
        router.delete(route("admin.contact.destroy", id), {
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
