<template>
    <form @submit.prevent="handleSubmit">
        <h4 class="text-xl font-bold mb-6">
            {{ isCreate ? "Create" : "Edit" }} Brand
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
import { Uploader } from "vant";
import { computed, onMounted, watch, ref } from "vue";
import { showSuccessToast } from "vant";
import { useFormSubmit } from "@/composables/useFormSubmit.js";

const props = defineProps({
    categories: Array,
    message: String,
    editValue: {
        type: Object,
        default: null,
    },
});

const emits = defineEmits(["success"]);

const fileList = ref([]);

const form = useForm({
    name: "",
    image: "",
});

const isCreate = computed(() => {
    return !props.editValue ? true : false;
});

const { onFormSubmit } = useFormSubmit(form, "brands", true);

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

<style lang="scss" scoped></style>
