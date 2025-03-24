<template>
    <div class="my-3">
        <DangerButton @click.prevent="$emit('is-delete')">
            Delete all
        </DangerButton>
    </div>
    <div class="grid grid-cols-6 space-x-3 justify-center items-center">
        <div class="col-auto">
            <InputLabel value="Name or SKU" />
            <TextInput
                class="font-normal w-full"
                v-model="name"
                @input="onChangeInput"
            />
        </div>
        <div class="col-auto">
            <InputLabel value="Brand" />
            <select
                id="brand"
                v-model="brand"
                @change="onChangeInput"
                class="form-control w-full font-normal"
            >
                <option value="">Select</option>
                <option v-for="item in brands" :key="item.id" :value="item.id">
                    {{ item.name }}
                </option>
            </select>
        </div>
        <div class="col-auto">
            <InputLabel value="Category" />
            <select
                name="parent"
                v-model="category"
                @change="onChangeInput"
                class="form-control w-full font-normal"
            >
                <option value="">Select</option>
                <option
                    v-for="item in categories"
                    :key="item.id"
                    :value="item.id"
                >
                    {{ item.name }}
                </option>
            </select>
        </div>
        <div class="col-auto">
            <InputLabel value="Sub Category" />
            <select
                name="sub_child"
                v-model="sub_category"
                @change="onChangeInput"
                class="form-control w-full font-normal"
            >
                <option value="">Select</option>
                <option
                    v-for="item in subCategories"
                    :key="item.id"
                    :value="item.id"
                >
                    {{ item.name }}
                </option>
            </select>
        </div>
        <div class="col-auto">
            <InputLabel value="Sub Child" />
            <select
                v-model="sub_child"
                @change="onChangeInput"
                class="form-control w-full font-normal"
            >
                <option value="">Select</option>
                <option
                    v-for="item in subChildCategories"
                    :key="item.id"
                    :value="item.id"
                >
                    {{ item.name }}
                </option>
            </select>
        </div>
        <div class="col-auto">
            <InputLabel value="Stocks" />
            <TextInput
                type="number"
                class="font-normal w-full"
                v-model="stock"
                @input="onChangeInput"
            />
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useSearch } from "@/composables/useSearch";
import { useCategorySelect } from "@/composables/useCategorySelect";
import DangerButton from "@/Components/DangerButton.vue";

const props = defineProps({
    brands: Array,
    categories: Array,
    params: Object,
});

const subCategories = ref([]);
const subChildCategories = ref([]);

const name = ref(props?.params?.name ?? "");
const stock = ref(props?.params?.stock ?? "");
const category = ref(props.params?.category ?? "");
const brand = ref(props.params?.brand ?? "");
const sub_category = ref("");
const sub_child = ref("");

const { onListingFilter } = useSearch("products");
const { getSelectedByParent } = useCategorySelect();

const onChangeInput = async (event) => {
    let select = event?.target?.name;
    const result = await getSelectedByParent(event);
    if (select == "parent") {
        subCategories.value = result.value;
        subChildCategories.value = [];
        sub_category.value = "";
        sub_child.value = "";
    }

    if (select == "sub_child") {
        subChildCategories.value = result.value;
        sub_child.value = "";
    }

    onListingFilter({
        name: name.value,
        brand: brand.value,
        stock: stock.value,
        category: category.value,
        sub_category: sub_category.value,
        sub_child: sub_child.value,
    });
};
</script>

<style lang="scss" scoped></style>
