<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { useRolePermission } from "@/composables/useRolePermission";

const { hasRole, hasPermission } = useRolePermission();

const props = defineProps({
    counting: Array,
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-flow-row grid-cols-5 space-x-4">
                <Link
                    v-for="(count, key) in counting"
                    :href="route(`admin.${key}.index`)"
                    class="card bg-slate-50 border border-gray-100 p-5 rounded-lg shadow hover:shadow-md hover:border-blue-500 focus:border-blue-500 duration-75 ease-in-out"
                >
                    <div class="flex justify-between items-center">
                        <div class="flex gap-y-2 flex-col capitalize">
                            <i
                                class="pi text-3xl text-blue-500"
                                :class="
                                    key == 'customers'
                                        ? 'pi-users'
                                        : key == 'orders'
                                        ? 'pi-truck'
                                        : key == 'products'
                                        ? 'pi-inbox'
                                        : 'pi-tag'
                                "
                            ></i>
                            <span class="text-sm">
                                {{ key }}
                            </span>
                        </div>
                        <span class="text-2xl text-blue-500 font-bold">
                            {{ count }}
                        </span>
                    </div>
                </Link>
            </div>

            <!-- <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">You're logged in!</div>
            </div> -->
        </div>
    </AuthenticatedLayout>
</template>
