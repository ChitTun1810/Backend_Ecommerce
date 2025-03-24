import axios from "axios";
import { ref } from "vue";

export function useCategorySelect() {
    const categories = ref([]);
    const productTypes = ref([]);

    const getSelectedData = async (id) => {
        const result = await axios.get(route("admin.categories.by-parent"), {
            params: {
                id: id,
            },
        });
        return result?.data;
    };

    const getSelectedByParent = async (event) => {
        let id = event?.target?.value;
        const result = await getSelectedData(id);
        if (result?.success) {
            categories.value = result.data;
            return categories;
        }
    };

    const getProductTypeSelectedByCat = async (id) => {
        const result = await axios.get(
            route("admin.product-types.by-category"),
            {
                params: {
                    id: id,
                },
            }
        );

        productTypes.value = result.data.data;
        return productTypes.value;
    };

    return {
        getSelectedData,
        getSelectedByParent,
        getProductTypeSelectedByCat,
    };
}
