<template>
    <form @submit.prevent="handleSubmit">
        <h4 class="text-xl font-bold mb-6">
            {{ isCreate ? "Create" : "Edit" }} User
        </h4>
        <div class="mb-5">
            <InputLabel for="name" value="Name" />
            <TextInput id="name" v-model="form.name" class="w-full" />
            <InputError :message="form.errors.name" />
        </div>
        <div class="mb-5">
            <InputLabel for="email" value="Email" />
            <TextInput id="email" v-model="form.email" class="w-full" />
            <InputError :message="form.errors.email" />
        </div>
        <div class="mb-5">
            <InputLabel for="password" value="Password" />
            <TextInput
                type="password"
                autocomplete="off"
                id="password"
                v-model="form.password"
                class="w-full"
            />
            <InputError :message="form.errors.password" />
        </div>

        <div class="mb-5">
            <InputLabel for="role" value="Role" />
            <select
                id="role"
                v-model="form.role"
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
            >
                <option value="">Select role</option>
                <option v-for="role in roles" :key="role.id" :value="role.name">
                    {{ role.name }}
                </option>
            </select>
            <InputError :message="form.errors.role" />
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
import { showSuccessToast } from "vant";
import { useFormSubmit } from "@/composables/useFormSubmit.js";

const props = defineProps({
    message: String,
    editValue: {
        type: Object,
        default: null,
    },
    roles: {
        type: Array,
    },
});

const emits = defineEmits(["success"]);

const form = useForm({
    name: "",
    email: "",
    password: "",
    role: "",
});

const isCreate = computed(() => {
    return !props.editValue ? true : false;
});

const { onFormSubmit } = useFormSubmit(form, "users");

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
        form.email = props.editValue.email;
        form.role = props.editValue.roles[0].name;
    }
});
</script>

<style lang="scss" scoped></style>
