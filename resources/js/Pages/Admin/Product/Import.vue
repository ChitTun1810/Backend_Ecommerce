<template>
    <Head title="Import Products" />
    <AuthenticatedLayout>
        <h4 class="text-xl font-bold mb-6">Import Products</h4>
        <form method="post" @submit.prevent="handleFileSubmit">
            <div class="mb-3">
                <InputLabel for="name" value="Upload excel file" />
                <input
                    class="p-2 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                    id="file"
                    type="file"
                    accept=".xlsx"
                    @change="form.file = $event.target.files[0]"
                />
            </div>
            <div class="text-end mb-4">
                <a class="text-sm me-3 text-blue-500" href="/example.xlsx">
                    Download Sample
                </a>
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Upload
                </PrimaryButton>
            </div>
        </form>
        <h6 class="text-sm mb-2 uppercase">Error logs</h6>
        <div class="bg-slate-100 border p-2 h-60 max-h-60 overflow-y-auto">
            <div v-for="(error, index) in errors" :key="index">
                <InputError :message="error" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import { showSuccessToast } from "vant";

const form = useForm({
    file: "",
});

const props = defineProps({
    errors: Object,
});

const handleFileSubmit = () => {
    const options = {
        onSuccess: () => {
            showSuccessToast("Success!");
            form.file = "";
        },
    };

    form.post(route("admin.products.import"), options);
};
</script>

<style lang="scss" scoped></style>
