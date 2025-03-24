<template>
    <form @submit.prevent="handleSubmit">
        <h4 class="text-xl font-bold mb-6">
            {{ isCreate ? "Create" : "Edit" }} Product Type
        </h4>
        <div class="mb-5">
            <InputLabel for="name" value="Name" />
            <TextInput id="name" v-model="form.name" class="w-full" />
            <InputError :message="form.errors.name" />
        </div>
        <div class="mb-5">
            <InputLabel for="category" value="Category" />
            <select
                id="brand"
                v-model="form.category_id"
                class="form-control w-full"
            >
                <option value="">Select category</option>
                <option
                    v-for="item in categories"
                    :key="item.id"
                    :value="item.id"
                >
                    {{ item.name }}
                </option>
            </select>
            <!-- <Dropdown
                filter
                v-model="form.category_id"
                :options="categories"
                optionLabel="name"
                placeholder="Select category"
                class="form-control w-full border"
            /> -->
        </div>
        <div class="text-end">
            <PrimaryButton
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                Save
            </PrimaryButton>
        </div>
    </form>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import { computed, onMounted, watch } from "vue";
import { showSuccessToast } from "vant";
import { useFormSubmit } from "@/composables/useFormSubmit.js";

import Dropdown from "primevue/dropdown";

const props = defineProps({
    editValue: {
        type: Object,
        default: null,
    },
    categories: Array,
});

const emits = defineEmits(["success"]);

const form = useForm({
    name: "",
    category_id: "",
});

const isCreate = computed(() => {
    return !props.editValue ? true : false;
});

const { onFormSubmit } = useFormSubmit(form, "product-types");

const handleSubmit = () => {
    const options = {
        onSuccess: () => {
            showSuccessToast("Success!");
            form.reset();
        },
    };

    onFormSubmit(options, props.editValue);
};

onMounted(() => {
    if (props.editValue != null) {
        form.name = props.editValue.name;
        form.category_id = props.editValue.category_id;
    }
});
</script>

<style lang="scss" scoped></style>
