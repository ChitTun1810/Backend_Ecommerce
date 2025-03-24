<template>
    <form method="post" @submit.prevent="handleSubmit">
        <h4 class="text-xl font-bold mb-6">
            {{ isCreate ? "Create" : "Edit" }} Product
        </h4>
        <div class="mb-5 mt-5 flex justify-center">
            <Uploader
                preview-size="150"
                :preview-options="{ closeable: true }"
                v-model="fileList"
                multiple
                :max-count="10"
                @delete="deleteImages"
            />
        </div>
        <div class="mb-5">
            <InputLabel for="name" value="Name" />
            <TextInput id="name" v-model="form.name" class="w-full" />
            <InputError :message="form.errors.name" />
        </div>
        <div class="mb-5">
            <InputLabel for="price" value="Price" />
            <TextInput
                id="price"
                v-model="form.price"
                type="text"
                class="w-full"
            />
            <InputError :message="form.errors.price" />
        </div>
        <div class="mb-5">
            <InputLabel for="stock" value="Stocks (optional)" />
            <TextInput
                id="stock"
                v-model="form.stocks"
                type="number"
                class="w-full"
            />
            <InputError :message="form.errors.stocks" />
        </div>
        <div class="mb-5">
            <InputLabel for="sku" value="SKU" />
            <TextInput id="sku" v-model="form.sku" class="w-full" />
            <InputError :message="form.errors.sku" />
        </div>
        <div class="mb-5">
            <InputLabel for="description" value="Description (optional)" />
            <!-- <QuillEditor
                v-model:content="form.description"
                contentType="html"
                theme="snow"
            /> -->
            <ckeditor
                :editor="editor"
                v-model="form.description"
                :config="config"
            ></ckeditor>
        </div>
        <div class="mb-5">
            <InputLabel for="key" value="Key Information (optional)" />
            <!-- <QuillEditor
                v-model:content="form.key_information"
                contentType="html"
                theme="snow"
            /> -->
            <ckeditor
                :editor="editor"
                v-model="form.key_information"
                :config="config"
            ></ckeditor>
        </div>
        <div class="mb-5">
            <InputLabel value="Specification (optional)" />
            <!-- <QuillEditor
                v-model:content="form.specification"
                contentType="html"
                theme="snow"
            /> -->
            <ckeditor
                :editor="editor"
                v-model="form.specification"
                :config="config"
            ></ckeditor>
        </div>
        <div class="mb-5">
            <InputLabel for="brand" value="Brand" />
            <select
                id="brand"
                v-model="form.brand_id"
                class="form-control w-full"
            >
                <option value="">Select brand</option>
                <option v-for="item in brands" :key="item.id" :value="item.id">
                    {{ item.name }}
                </option>
            </select>
            <InputError :message="form.errors.brand_id" />
        </div>
        <div class="mb-5">
            <InputLabel for="parent" value="Parent Category" />
            <select
                id="parent"
                name="parent"
                v-model="form.category_id"
                @change.prevent="onSelectedByParent"
                class="form-control w-full"
            >
                <option value="">Select parent category</option>
                <option
                    v-for="item in categories"
                    :key="item.id"
                    :value="item.id"
                >
                    {{ item.name }}
                </option>
            </select>
            <InputError :message="form.errors.category_id" />
        </div>
        <div class="mb-5">
            <InputLabel for="sub_child" value="Sub Category (optional)" />
            <select
                id="sub_child"
                name="sub_child"
                v-model="form.sub_category_id"
                @change="onSelectedByParent"
                class="form-control w-full"
            >
                <option value="">Select sub category</option>
                <option
                    v-for="item in subCategories"
                    :key="item.id"
                    :value="item.id"
                >
                    {{ item.name }}
                </option>
            </select>
            <InputError :message="form.errors.sub_category_id" />
        </div>
        <div class="mb-5">
            <InputLabel for="child" value="Sub Child Category (optional)" />
            <select
                id="child"
                v-model="form.sub_child_id"
                @change="onSelectedByParent"
                class="form-control w-full"
            >
                <option value="">Select child category</option>
                <option
                    v-for="item in subChildCategories"
                    :key="item.id"
                    :value="item.id"
                >
                    {{ item.name }}
                </option>
            </select>
            <InputError :message="form.errors.sub_child_id" />
        </div>
        <div class="mb-5">
            <InputLabel for="product_type_id" value="Product Type (optional)" />
            <select
                id="product_type_id"
                v-model="form.product_type_id"
                class="form-control w-full"
            >
                <option value="">Select product type</option>
                <option
                    v-for="item in productTypes"
                    :key="item.id"
                    :value="item.id"
                >
                    {{ item.name }}
                </option>
            </select>
        </div>
        <div class="mb-5">
            <InputLabel for="country_id" value="Country (optional)" />
            <select
                id="country_id"
                v-model="form.country_id"
                class="form-control w-full"
            >
                <option value="">Select Country</option>
                <option
                    v-for="item in countries"
                    :key="item.id"
                    :value="item.id"
                >
                    {{ item.name }}
                </option>
            </select>
            <InputError :message="form.errors.country_id" />
        </div>
        <div class="mb-5">
            <div class="flex gap-x-2 mb-1">
                <InputLabel
                    for="download_link"
                    value="User Manual Link (optional)"
                />
                <i
                    @click="addNew"
                    class="cursor-pointer pi text-xl pi-plus-circle"
                ></i>
            </div>
            <div
                v-for="(link, index) in form.links"
                :key="index"
                class="mb-4 last:mb-0"
            >
                <div class="flex gap-x-4">
                    <div class="w-full">
                        <TextInput
                            placeholder="Title"
                            v-model="link.title"
                            class="w-full"
                        />
                        <InputError
                            :message="form.errors[`links.${index}.title`]"
                        />
                    </div>
                    <div class="w-full">
                        <TextInput
                            placeholder="Link"
                            v-model="link.link"
                            class="w-full"
                        />
                        <InputError
                            :message="form.errors[`links.${index}.link`]"
                        />
                    </div>
                </div>
                <div
                    v-if="form.links.length > 1 || link?.id"
                    class="flex justify-end mt-1"
                >
                    <button
                        @click.prevent="removeInput(index, link)"
                        class="text-red-500 flex items-center gap-1 text-sm"
                    >
                        <i
                            class="pi"
                            :class="!link.id ? 'pi-minus-circle' : 'pi-trash'"
                        ></i>
                        {{ !link.id ? "Remove" : "Delete" }}
                    </button>
                </div>
            </div>
        </div>
        <div class="mb-5">
            <InputLabel value="Created At" />
            <Calendar
                class="w-full"
                v-model="form.created_at"
                showTime
                hourFormat="12"
                input-class="form-control w-full"
                placeholder="MM/DD/YYYY"
                showButtonBar
            />
        </div>
        <div class="mb-5">
            <InputLabel value="Active" />
            <div class="flex">
                <div class="flex items-center me-4">
                    <input
                        id="inline-radio"
                        v-model="form.is_active"
                        type="radio"
                        value="1"
                        name="is_active"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300"
                        :checked="form.is_active == 1 ? true : false"
                    />
                    <label
                        for="inline-radio"
                        class="ms-2 text-sm font-medium text-gray-900"
                        >Yes</label
                    >
                </div>
                <div class="flex items-center me-4">
                    <input
                        id="inline-2-radio"
                        v-model="form.is_active"
                        type="radio"
                        value="0"
                        name="is_active"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300"
                        :checked="form.is_active != 1 ? true : false"
                    />
                    <label
                        for="inline-2-radio"
                        class="ms-2 text-sm font-medium text-gray-900"
                        >No</label
                    >
                </div>
            </div>
        </div>
        <div class="mb-5">
            <InputLabel value="Show Specification" />
            <div class="flex">
                <div class="flex items-center me-4">
                    <input
                        id="spec-radio"
                        v-model="form.is_specification"
                        type="radio"
                        value="1"
                        name="is_specification"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300"
                        :checked="form.is_specification == 1 ? true : false"
                    />
                    <label
                        for="spec-radio"
                        class="ms-2 text-sm font-medium text-gray-900"
                        >Yes</label
                    >
                </div>
                <div class="flex items-center me-4">
                    <input
                        id="spec-2-radio"
                        v-model="form.is_specification"
                        type="radio"
                        value="0"
                        name="is_specification"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300"
                        :checked="form.is_specification != 1 ? true : false"
                    />
                    <label
                        for="spec-2-radio"
                        class="ms-2 text-sm font-medium text-gray-900"
                        >No</label
                    >
                </div>
            </div>
        </div>
        <div class="text-end">
            <PrimaryButton
                v-if="!isCreate"
                class="me-3"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                @click="form.is_redirect = false"
            >
                Update
            </PrimaryButton>
            <PrimaryButton
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                @click="form.is_redirect = true"
            >
                {{ isCreate ? "Save" : "Save & Exit" }}
            </PrimaryButton>
        </div>
    </form>
</template>

<script setup>
import moment from "moment";
import { useForm, router } from "@inertiajs/vue3";
import { computed, ref, watch, onMounted } from "vue";
import { Uploader } from "vant";
import { showSuccessToast } from "vant";
import { useFormSubmit } from "@/composables/useFormSubmit.js";
import { useCategorySelect } from "@/composables/useCategorySelect";
import { showToast } from "vant";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import Calendar from "primevue/calendar";
import { findLastKey } from "lodash";
// import { QuillEditor } from "@vueup/vue-quill";
// import "@vueup/vue-quill/dist/vue-quill.snow.css";

const editor = ref(ClassicEditor);
const config = ref({
    toolbar: {
        items: [
            "heading",
            "|",
            "bold",
            "italic",
            "link",
            "|",
            "bulletedList",
            "numberedList",
            "|",
            "outdent",
            "indent",
            "|",
            "blockQuote",
            "insertTable",
            "|",
            "undo",
            "redo",
        ],
    },
});
const form = useForm({
    name: "",
    sku: "",
    stocks: "",
    price: "",
    description: "",
    key_information: "",
    specification: "",
    is_active: false,
    is_specification: false,
    brand_id: "",
    category_id: "",
    sub_category_id: "",
    sub_child_id: "",
    product_type_id: "",
    country_id: "",
    images: [],
    old: [],
    links: [
        {
            link: "",
            title: "",
        },
    ],
    is_redirect: true,
    created_at: "",
});

const subCategories = ref([]);
const subChildCategories = ref([]);
const fileList = ref([]);
const oldImages = ref([]);
// const productTypes = ref([]);

const props = defineProps({
    editValue: {
        type: Object,
        default: null,
    },
    categories: Array,
    brands: Array,
    countries: Array,
    productTypes: Array,
});

const isCreate = computed(() => {
    return !props.editValue ? true : false;
});

const { onFormSubmit } = useFormSubmit(form, "products", true);
const { getSelectedData, getSelectedByParent, getProductTypeSelectedByCat } =
    useCategorySelect();

const handleSubmit = () => {
    const options = {
        onSuccess: async () => {
            showSuccessToast("Success!");
            if (props.editValue) {
                await setEditValue();
            }
        },
        onError: (errors) => {
            form.errors = errors;
            if (errors.images) {
                showToast(errors.images);
            }
        },
    };

    onFormSubmit(options, props.editValue);
};

const onSelectedByParent = async (event) => {
    let name = event?.target?.name;

    const result = await getSelectedByParent(event);

    // productTypes.value = await getProductTypeSelectedByCat(event.target.value);
    // form.product_type_id = "";

    if (name == "parent") {
        subCategories.value = result.value;
        subChildCategories.value = [];
        form.sub_category_id = "";
        form.sub_child_id = "";
    }

    if (name == "sub_child") {
        subChildCategories.value = result.value;
        form.sub_child_id = "";
    }
};

const setEditValue = async () => {
    form.name = props.editValue.name;
    form.price = props.editValue.price;
    form.stocks = props.editValue.stocks;
    form.sku = props.editValue.sku;
    form.description = props.editValue.description;
    form.is_active = props.editValue.is_active;
    form.is_specification = props.editValue.is_specification;
    form.brand_id = props.editValue.brand_id ?? "";
    form.category_id = props.editValue.category_id ?? "";
    form.sub_category_id = props.editValue.sub_category_id ?? "";
    form.sub_child_id = props.editValue.sub_child_id ?? "";
    form.country_id = props.editValue.country_id ?? "";
    form.key_information = props.editValue.key_information ?? "";
    form.product_type_id = props.editValue.product_type_id ?? "";
    form.specification = props.editValue.specification ?? "";
    form.created_at = moment(props.editValue.created_at).format(
        "MM/DD/YYYY hh:mm a"
    );

    if (props.editValue.user_manual_links.length > 0) {
        form.links = props.editValue.user_manual_links;
    }

    // Category Add
    subCategories.value = (await getSelectedData(form.category_id))?.data;
    subChildCategories.value = (
        await getSelectedData(form.sub_category_id)
    )?.data;

    // productTypes.value = await getProductTypeSelectedByCat(form.category_id);

    // if (form.sub_category_id) {
    //     productTypes.value = await getProductTypeSelectedByCat(
    //         form.sub_category_id
    //     );
    // }

    // if (form.sub_child_id) {
    //     productTypes.value = await getProductTypeSelectedByCat(
    //         form.sub_child_id
    //     );
    // }

    fileList.value = props.editValue.images.map((img) => {
        return { url: img.image };
    });

    oldImages.value = props.editValue.images;
};

onMounted(async () => {
    if (props.editValue) {
        await setEditValue();
    }
});

watch(fileList, (value) => {
    form.images = value.map((v) => {
        return v.file;
    });
});

const deleteImages = async (value) => {
    const deleteImage = oldImages.value.find(($old) => {
        return $old?.image == value?.url;
    });

    form.old.push(deleteImage?.id);
};

const changeActiveState = (value) => {
    form.is_active = value;
};

function addNew() {
    form.links.push({ link: "", title: "" });
}

function removeInput(index, link) {
    if (link.id) {
        router.delete(route("admin.products.delete-link", link.id), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                showSuccessToast("Success!");
            },
        });
    }
    form.links.splice(index, 1);
    if (form.links.length == 0) {
        addNew();
    }
}
</script>

<style lang="css" scoped></style>
