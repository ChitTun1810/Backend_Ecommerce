<template>
    <form @submit.prevent="handleSubmit">
        <h4 class="text-xl font-bold mb-6">
            {{ isCreate ? "Create" : "Edit" }} Category
        </h4>
        <div class="mb-5 flex justify-center">
            <Uploader
                preview-size="150"
                :preview-options="{ closeable: true }"
                v-model="fileList"
                :max-count="1"
            />
        </div>
        <div class="mb-5">
            <InputLabel for="name" value="Name" />
            <TextInput id="name" v-model="form.name" class="w-full" />
            <InputError :message="form.errors.name" />
        </div>
        <div class="mb-5">
            <InputLabel for="category" value="Parent Category (optional)" />
            <select
                id="category"
                v-model="form.parent_id"
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
            >
                <option value="">Select parent category</option>
                <option
                    v-for="category in categories"
                    :key="category.id"
                    :value="category.id"
                >
                    {{ category.name }}
                </option>
            </select>
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
import { Uploader } from "vant";
import { watch } from "vue";
import { showSuccessToast } from "vant";
import { computed, onMounted, ref } from "vue";
import { useFormSubmit } from "@/composables/useFormSubmit";

const fileList = ref([]);

const props = defineProps({
    categories: Array,
    message: String,
    editValue: {
        type: Object,
        default: null,
    },
});

const emits = defineEmits(["success"]);

const form = useForm({
    name: "",
    parent_id: "",
    image: null,
});

const isCreate = computed(() => {
    return !props.editValue ? true : false;
});

const { onFormSubmit } = useFormSubmit(form, "categories", true);

const handleSubmit = () => {
    const options = {
        onSuccess: () => {
            showSuccessToast("Success!");
            form.reset();
        },
        onError: (errors) => {
            form.errors = errors;
        },
    };

    onFormSubmit(options, props.editValue);
};

onMounted(() => {
    if (props.editValue != null) {
        form.name = props.editValue.name;
        form.parent_id = props.editValue.parent_id ?? "";
        form.image = props.editValue.image;

        fileList.value = [
            {
                url: form.image,
            },
        ];
    }
});

watch(fileList, () => {
    form.image = fileList.value[0]?.file;
});
</script>

<style lang="" scoped></style>
