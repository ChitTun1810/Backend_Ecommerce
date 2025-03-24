<template>
    <Head title="Show Category" />
    <AuthenticatedLayout>
        <h4 class="text-xl font-bold mb-6">Show Product</h4>
        <Link
            class="btn-primary mb-5"
            :href="route('admin.products.edit', product.id)"
        >
            Edit Product
        </Link>
        <div class="grid grid-cols-2">
            <div class="col-span-1">
                <div class="relative p-3 shadow-md sm:rounded-lg mb-5">
                    <table
                        class="w-full text-sm text-left rtl:text-right text-gray-500"
                    >
                        <tbody>
                            <tr class="bg-white">
                                <th
                                    scope="row"
                                    class="px-2 py-4 font-medium text-gray-900 whitespace-nowrap"
                                >
                                    Product Name
                                </th>
                                <td class="px-2 py-4">
                                    {{ product.name }}
                                </td>
                            </tr>
                            <tr class="bg-white">
                                <th
                                    scope="row"
                                    class="px-2 py-4 font-medium text-gray-900 whitespace-nowrap"
                                >
                                    SKU
                                </th>
                                <td class="px-2 py-4">
                                    {{ product.sku }}
                                </td>
                            </tr>
                            <tr class="bg-white">
                                <th
                                    scope="row"
                                    class="px-2 py-4 font-medium text-gray-900 whitespace-nowrap"
                                >
                                    Brand
                                </th>
                                <td class="px-2 py-4">
                                    {{ product?.brand.name }}
                                </td>
                            </tr>
                            <tr class="bg-white">
                                <th
                                    scope="row"
                                    class="px-2 py-4 font-medium text-gray-900 whitespace-nowrap"
                                >
                                    Category
                                </th>
                                <td class="px-2 py-4">
                                    {{ product.category.name }}
                                </td>
                            </tr>
                            <tr class="bg-white">
                                <th
                                    scope="row"
                                    class="px-2 py-4 font-medium text-gray-900 whitespace-nowrap"
                                >
                                    Sub Category
                                </th>
                                <td class="px-2 py-4">
                                    {{ product.sub_category?.name ?? "-" }}
                                </td>
                            </tr>
                            <tr class="bg-white">
                                <th
                                    scope="row"
                                    class="px-2 py-4 font-medium text-gray-900 whitespace-nowrap"
                                >
                                    Sub Child Category
                                </th>
                                <td class="px-2 py-4">
                                    {{ product.sub_child?.name ?? "-" }}
                                </td>
                            </tr>
                            <tr class="bg-white">
                                <th
                                    scope="row"
                                    class="px-2 py-4 font-medium text-gray-900 whitespace-nowrap"
                                >
                                    Product Type
                                </th>
                                <td class="px-2 py-4">
                                    {{ product.product_type?.name ?? "-" }}
                                </td>
                            </tr>
                            <tr class="bg-white">
                                <th
                                    scope="row"
                                    class="px-2 py-4 font-medium text-gray-900 whitespace-nowrap"
                                >
                                    Price
                                </th>
                                <td class="px-2 py-4">
                                    {{ product.price }}
                                </td>
                            </tr>
                            <tr class="bg-white">
                                <th
                                    scope="row"
                                    class="px-2 py-4 font-medium text-gray-900 whitespace-nowrap"
                                >
                                    Stocks
                                </th>
                                <td class="px-2 py-4">
                                    {{ product.stocks }}
                                </td>
                            </tr>
                            <tr class="bg-white">
                                <th
                                    scope="row"
                                    class="px-2 py-4 font-medium text-gray-900 whitespace-nowrap"
                                >
                                    Key Information
                                </th>
                                <td class="px-2 py-4">
                                    <div
                                        v-html="product?.key_information"
                                    ></div>
                                </td>
                            </tr>
                            <tr class="bg-white">
                                <th
                                    scope="row"
                                    class="px-2 py-4 font-medium text-gray-900 whitespace-nowrap"
                                >
                                    Description
                                </th>
                                <td class="px-2 py-4">
                                    <div v-html="product?.description"></div>
                                </td>
                            </tr>
                            <tr class="bg-white">
                                <th
                                    scope="row"
                                    class="px-2 py-4 font-medium text-gray-900 whitespace-nowrap"
                                >
                                    Specification
                                </th>
                                <td class="px-2 py-4">
                                    <div v-html="product?.specification"></div>
                                </td>
                            </tr>
                            <tr class="bg-white">
                                <th
                                    scope="row"
                                    class="px-2 py-4 font-medium text-gray-900 whitespace-nowrap"
                                >
                                    Country
                                </th>
                                <td class="px-2 py-4">
                                    {{ product.country?.name ?? "-" }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <template v-if="product.user_manual_links.length > 0">
                        <h6 class="ms-2 mb-2">Download Link</h6>
                        <div class="ps-8">
                            <ul class="list-disc">
                                <li v-for="link in product.user_manual_links">
                                    <a class="text-blue-500" :href="link.link">
                                        {{ link.title }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </template>
                </div>
            </div>
            <div class="col-span-1">
                <div class="px-5">
                    <div
                        v-for="image in product.images"
                        class="grid grid-cols-3 gap-3"
                    >
                        <div class="flex-auto">
                            <img
                                width="100"
                                height="100"
                                :src="image.image"
                                :alt="image.id"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head, Link } from "@inertiajs/vue3";

const props = defineProps({ product: Object });
</script>

<style lang="scss" scoped></style>
