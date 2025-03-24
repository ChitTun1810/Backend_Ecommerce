<template>
    <Head title="Show Product Inquiry" />
    <AuthenticatedLayout>
        <h4 class="text-xl font-bold mb-6">Show Product Inquiry</h4>
        <div class="border p-3 rounded-md bg-gray-50 mb-4">
            <div class="mb-5">
                Name :
                {{ product.name }}
            </div>
            <div class="mb-5">
                Phone :
                {{ product.phone }}
            </div>

            <div class="mb-5">
                Email :
                {{ product.email }}
            </div>

            <div class="mb-5">
                Product Name :

                <Link :href="route('admin.products.show', product.product_id)">
                    {{ product.product.name }}
                </Link>
            </div>
            <h3 class="mb-2">Content</h3>
            <div v-html="product.content"></div>
        </div>
    </AuthenticatedLayout>
</template>
<script setup>
import { Head, Link } from "@inertiajs/vue3";

defineProps({
    product: Object,
});
</script>
