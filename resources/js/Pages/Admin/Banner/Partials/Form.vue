<template>
    <form @submit.prevent="handleSubmit">
        <h4 class="text-xl font-bold mb-6">
            {{ isCreate ? "Create" : "Edit" }} Banner
        </h4>
        <div class="mb-5 flex justify-center">
            <Uploader
                preview-size="150"
                :preview-options="{ closeable: true }"
                v-model="fileList"
                :max-count="1"
            />
        </div>
        <div class="flex justify-center">
            <InputError :message="form.errors.image" />
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
    image: "",
});

const isCreate = computed(() => {
    return !props.editValue ? true : false;
});

const { onFormSubmit } = useFormSubmit(form, "banners", true);

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
