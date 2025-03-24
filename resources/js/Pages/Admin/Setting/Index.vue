<template>
    <Head title="Setting" />
    <AuthenticatedLayout>
        <div class="mb-5">
            <h2 class="mb-5 font-bold">Setting</h2>
            <form @submit.prevent="handleSubmit" method="post">
                <div class="">
                    <div class="flex gap-5">
                        <div class="mb-5">
                            <InputLabel
                                for="exchange_rate"
                                value="Exchange rate (Ks)"
                            />
                            <TextInput
                                id="exchange_rate"
                                v-model="form.exchange_rate"
                                class="w-full"
                                type="number"
                            />
                            <InputError :message="form.errors.exchange_rate" />
                        </div>
                        <div class="mb-5">
                            <InputLabel for="tax" value="tax" />
                            <TextInput
                                id="tax"
                                v-model="form.tax"
                                class="w-full"
                                type="number"
                            />
                            <InputError :message="form.errors.tax" />
                        </div>
                    </div>
                </div>
                <div>
                    <PrimaryButton
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        type="submit"
                    >
                        Save Changes
                    </PrimaryButton>
                </div>
            </form>
        </div>
        <h6 class="mb-3">Setting action logs</h6>
        <ActivityLog :logs="logs?.data" />
        <Pagination :links="logs?.links" />
    </AuthenticatedLayout>
</template>

<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import { onMounted } from "vue";
import { showSuccessToast } from "vant";
import ActivityLog from "./Partials/ActivityLog.vue";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({ setting: Object, logs: Object });

const form = useForm({
    exchange_rate: "",
    tax: "",
});

const handleSubmit = () => {
    const options = {
        onSuccess: () => {
            showSuccessToast("Success!");
        },
    };

    form.post(route(`admin.settings.update`), options);
};

onMounted(() => {
    form.exchange_rate = props.setting.exchange_rate;
    form.tax = props.setting.tax;
});
</script>

<style lang="scss" scoped></style>
