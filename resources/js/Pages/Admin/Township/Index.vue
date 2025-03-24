<template>
    <Head title="Townships" />
    <AuthenticatedLayout>
        <div class="mb-5 justify-between flex">
            <div class="flex items-center gap-3">
                Show Delivery Fee
                <Switch v-model="status" size="20px" @change="onChangeSwitch" />
            </div>
            <Link class="btn-primary" :href="route('admin.townships.create')">
                Create New Township
            </Link>
        </div>
        <Table :townships="townships?.data" />
        <Pagination :links="townships?.links" />
    </AuthenticatedLayout>
</template>

<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import { Switch } from "vant";
import { ref } from "vue";

import Table from "./Partials/Table.vue";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({ townships: Object, setting: Object });

const status = ref(props.setting.delivery_fee_status == 0 ? false : true);

const onChangeSwitch = () => {
    router.post(route("admin.setting.update-delivery-status"), {
        status: status.value,
    });
};
</script>

<style lang="scss" scoped></style>
