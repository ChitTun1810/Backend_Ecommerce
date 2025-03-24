<template>
    <form @submit.prevent="handleSubmit">
        <h4 class="text-xl font-bold mb-6">
            {{ isCreate ? "Create" : "Edit" }} Role
        </h4>
        <div class="mb-5">
            <InputLabel for="name" value="Name" />
            <TextInput id="name" v-model="form.name" class="w-full" />
            <InputError :message="form.errors.name" />
        </div>
        <div class="mb-5">
            <InputLabel for="permission" value="Select permissions" />
            <!-- <MultiSelect
                id="permission"
                v-model="form.permissions"
                :options="permissions"
                optionLabel="name"
                class="border form-control w-full"
                optionValue="id"
                :maxSelectedLabels="7"
            >
            </MultiSelect> -->
            <div class="flex flex-wrap justify-content-center gap-5">
                <div
                    v-for="permission in permissions"
                    class="flex items-center"
                >
                    <input
                        v-model="form.permissions"
                        :id="`checkbox${permission.id}`"
                        type="checkbox"
                        :value="permission.id"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                    />
                    <label
                        :for="`checkbox${permission.id}`"
                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                    >
                        {{ permission.name }}
                    </label>
                </div>
            </div>
            <InputError :message="form.errors.permissions" />
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
import { computed, onMounted } from "vue";
import { useFormSubmit } from "@/composables/useFormSubmit.js";
import { showSuccessToast } from "vant";

import MultiSelect from "primevue/multiselect";

const props = defineProps({
    permissions: Array,
    editValue: {
        type: Object,
        default: null,
    },
});

const form = useForm({
    name: "",
    permissions: [],
});

const isCreate = computed(() => {
    return !props.editValue ? true : false;
});

const { onFormSubmit } = useFormSubmit(form, "roles");

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
        form.permissions = props.editValue.permissions.map(function (el) {
            return el.id;
        });
    }
});
</script>

<style lang="scss" scoped></style>
