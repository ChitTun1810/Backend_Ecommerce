<template>
    <div class="relative shadow-md sm:rounded-lg mb-5">
        <table class="min-w-full text-sm data-table">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-3 text-start">Name</th>
                    <th class="p-3 text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <template v-for="category in categories" :key="category.id">
                    <tr>
                        <td class="border-b p-3">
                            <div class="flex items-center">
                                <img
                                    class="w-8 h-8 object-cover me-2 rounded"
                                    v-if="category.image"
                                    :src="category.image"
                                    :alt="category.name"
                                />
                                {{ category.name }}
                            </div>
                        </td>
                        <td class="border-b p-3 text-end">
                            <TableActions :id="category.id" />
                        </td>
                    </tr>

                    <template
                        v-if="category.children && category.children.length > 0"
                    >
                        <tr
                            v-for="child in category.children"
                            :key="child.id"
                            class="bg-gray-100"
                        >
                            <td class="border-b p-3 pl-5">
                                <div class="flex items-center">
                                    <img
                                        class="w-8 h-8 object-cover me-2 rounded"
                                        v-if="child.image"
                                        :src="child.image"
                                        :alt="child.name"
                                    />
                                    {{ child.name }}
                                </div>
                            </td>
                            <td class="border-b p-3 text-end">
                                <TableActions :id="child.id" />
                            </td>
                        </tr>
                    </template>
                </template>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import { ref } from "vue";

import Menu from "primevue/menu";
import TableActions from "./TableActions.vue";

defineProps({
    categories: Array,
});
</script>

<style lang="scss" scoped></style>
