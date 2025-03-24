<template>
    <form @submit.prevent="handleSubmit">
        <h4 class="text-xl font-bold mb-6">
            {{ isCreate ? "Create" : "Edit" }} Township
        </h4>
        <div class="mb-5">
            <InputLabel for="name" value="Name" />
            <TextInput id="name" v-model="form.name" class="w-full" />
            <InputError :message="form.errors.name" />
        </div>

        <div class="mb-5">
            <InputLabel for="city" value="Cities" />
            <select
                id="city"
                v-model="form.city_id"
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
            >
                <option value="">Select city</option>
                <option v-for="city in cities" :key="city.id" :value="city.id">
                    {{ city.name }}
                </option>
            </select>
        </div>

        <div class="mb-5">
            <InputLabel for="delivery_fee" value="Delivery fee" />
            <TextInput
                id="delivery_fee"
                v-model="form.delivery_fee"
                class="w-full"
                type="number"
            />
            <InputError :message="form.errors.delivery_fee" />
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
import { useForm, router } from "@inertiajs/vue3";
import { computed, onMounted, watch, ref } from "vue";
import { showSuccessToast } from "vant";
import { useFormSubmit } from "@/composables/useFormSubmit.js";

const props = defineProps({
    message: String,
    editValue: {
        type: Object,
        default: null,
    },
    cities: Array,
});

const emits = defineEmits(["success"]);

const form = useForm({
    name: "",
    city_id: "",
    delivery_fee: "",
});

const isCreate = computed(() => {
    return !props.editValue ? true : false;
});

const { onFormSubmit } = useFormSubmit(form, "townships");

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
        form.city_id = props.editValue.city_id;
        form.delivery_fee = props.editValue.delivery_fee;
    }
});
</script>

<style lang="scss" scoped></style>
