<template>
    <Head title="Show Order" />
    <AuthenticatedLayout>
        <div class="border p-4 rounded-lg">
            <p class="font-semibold mb-5 text-lg">Order Detail</p>
            <div class="w-1/2">
                <div class="flex justify-between items-center mb-4">
                    <div class="font-medium">Order no</div>
                    <div class="text-end">{{ order?.order_number }}</div>
                </div>
                <div class="flex justify-between items-center mb-4">
                    <div class="font-medium">Delivery status</div>
                    <div class="tex-end">
                        <select
                            v-if="order?.delivery_status != 'refund'"
                            v-model="delivery.status"
                            class="form-control capitalize text-sm"
                            @change.prevent="onChangeStatus(false)"
                        >
                            <option
                                v-for="(status, index) in deliveryStatus"
                                :value="status"
                                :key="index"
                            >
                                {{ status }}
                            </option>
                        </select>
                        <p v-else class="text-red-500">
                            {{ order?.delivery_status }}
                        </p>
                    </div>
                </div>
                <div class="flex justify-between items-center mb-4">
                    <div class="font-medium">Payment status</div>
                    <div
                        class="text-end"
                        v-if="!order.is_cod || order.payment_status == 'paid'"
                    >
                        <span
                            class="uppercase text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300"
                            :class="
                                order.payment_status != 'paid'
                                    ? 'bg-yellow-100 text-yellow-800'
                                    : 'bg-blue-100 text-blue-800'
                            "
                        >
                            {{ order.payment_status }}
                        </span>
                    </div>
                    <div class="text-end" v-else>
                        <select
                            v-model="delivery.payment_status"
                            class="form-control capitalize text-sm"
                            @change.prevent="onChangeStatus(true)"
                        >
                            <option value="unpaid">Unpaid</option>
                            <option value="paid">Paid</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-between items-center mb-4">
                    <div class="font-medium">Cash On Delivery</div>
                    <div class="text-end">
                        <span
                            class="uppercase text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300"
                            :class="
                                !order.is_cod
                                    ? 'bg-yellow-100 text-yellow-800'
                                    : 'bg-blue-100 text-blue-800'
                            "
                        >
                            {{ order.is_cod ? "Yes" : "No" }}
                        </span>
                    </div>
                </div>

                <div v-if="order.payment_log?.payment_channel" class="flex justify-between items-center mb-4">
                    <div class="font-medium">Payment Type</div>
                    <div class="text-end">
                        <span
                            class="uppercase text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300"
                        >
                            {{ order.payment_log?.payment_channel }}
                        </span>
                    </div>
                </div>

                <div class="flex justify-between items-center mb-4">
                    <div class="font-medium">Sub Total</div>
                    <div class="text-end">{{ order?.total }} Ks</div>
                </div>
                <div class="flex justify-between items-center mb-4">
                    <div class="font-medium">Delivery Fee</div>
                    <div class="text-end">{{ order?.delivery_fee }} Ks</div>
                </div>
                <div class="flex justify-between items-center mb-4">
                    <div class="font-medium">Exchange rate</div>
                    <div class="text-end">{{ order?.exchange_rate }} Ks</div>
                </div>
                <div class="flex justify-between items-center mb-4">
                    <div class="font-medium">USD Total</div>
                    <div class="text-end">USD {{ order?.usd_total }}</div>
                </div>
                <div class="flex justify-between items-center mb-4">
                    <div class="font-bold">Grand Total</div>
                    <div class="text-end font-bold">
                        {{ order?.grand_total }} Ks
                    </div>
                </div>
                <div class="mt-10">
                    <div class="mb-1">Customer Note :</div>
                    <p>
                        {{ order?.order_customer?.note }}
                    </p>
                </div>
            </div>
        </div>
        <!-- <h2 class="font-bold text-2xl">Order no : 302384</h2> -->
        <div class="flex flex-wrap gap-4 mt-10">
            <div class="lg:w-auto min-h-[100px] flex-auto">
                <div class="border rounded-lg p-4">
                    <p class="font-semibold mb-5 text-lg">Products</p>
                    <div
                        v-for="orderProduct in order.order_products"
                        class="flex justify-between mb-5"
                    >
                        <div class="w-[60%] flex-auto">
                            <div class="flex items-center">
                                <div class="w-[55px] h-[55px]">
                                    <img
                                        v-if="orderProduct.product.images[0]"
                                        class="max-w-full rounded object-contain"
                                        :src="
                                            orderProduct.product.images[0]
                                                ? orderProduct.product.images[0]
                                                      .image
                                                : ''
                                        "
                                        alt="product_image"
                                    />
                                    <div
                                        class="bg-slate-300 w-[55px] h-[55px] flex justify-center items-center rounded"
                                        v-else
                                    >
                                        <i class="pi pi-images"></i>
                                    </div>
                                </div>
                                <div class="ms-3">
                                    <p>
                                        {{ orderProduct.product.name }}
                                    </p>
                                    <p>{{ orderProduct.product.sku }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex-auto mt-2 text-end">
                            USD {{ orderProduct.price }}
                        </div>
                        <div class="flex-auto mt-2 text-end">
                            Quantity {{ orderProduct.quantity }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="lg:w-auto min-h-[100px] flex-auto">
                <div class="border rounded-lg p-4">
                    <p class="font-semibold mb-5 text-lg">Customer Info</p>
                    <div class="mb-3 flex justify-between">
                        <div>Name:</div>
                        <div>{{ order?.order_customer.customer.name }}</div>
                    </div>

                    <div class="mb-3 flex justify-between">
                        <div>Phone</div>
                        <div>{{ order?.order_customer?.phone }}</div>
                    </div>

                    <div class="mb-3 flex justify-between">
                        <div>City</div>
                        <div>{{ order?.order_customer?.city_name }}</div>
                    </div>

                    <div class="mb-3 flex justify-between">
                        <div>Township</div>
                        <div>{{ order?.order_customer?.township_name }}</div>
                    </div>

                    <div class="mb-3 flex justify-between gap-5">
                        <div class="flex-auto">Address</div>
                        <div class="w-[50%] flex-auto text-end">
                            {{ order?.order_customer?.address_detail }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grand Total Section -->
        <!-- <div class="w-[97%] m-auto">
            <div class="border rounded-lg p-8 mt-6">
                <div class="flex justify-between">
                    <div class="w-[40%] flex-auto">Notes:</div>
                    <div class="flex-auto">
                        <div class="flex justify-between items-center mb-4">
                            <div class="font-medium">Sub Total</div>
                            <div class="text-end">{{ order?.total }} Ks</div>
                        </div>
                        <div class="flex justify-between items-center mb-4">
                            <div class="font-medium">Delivery Fee</div>
                            <div class="text-end">
                                {{ order?.delivery_fee }} Ks
                            </div>
                        </div>
                        <div class="flex justify-between items-center mb-4">
                            <div class="font-medium">Exchange rate</div>
                            <div class="text-end">
                                {{ order?.exchange_rate }} Ks
                            </div>
                        </div>
                        <div class="flex justify-between items-center mb-4">
                            <div class="font-medium">USD Total</div>
                            <div class="text-end">
                                USD {{ order?.usd_total }}
                            </div>
                        </div>
                        <div class="flex justify-between items-center mb-4">
                            <div class="font-bold">Grand Total</div>
                            <div class="text-end font-bold">
                                {{ order?.grand_total }} Ks
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <button
            v-if="
                order?.payment_status == 'paid' &&
                order?.delivery_status != 'refund'
            "
            class="border px-10 py-2 bg-red-600 text-white rounded-md"
            @click="refundHandler(order.id)"
        >
            Refund
        </button>
    </AuthenticatedLayout>
</template>
<script setup>
import { Head, router, useForm } from "@inertiajs/vue3";
import { useFormSubmit } from "@/composables/useFormSubmit";
import { showToast, showSuccessToast } from "vant";

const props = defineProps({
    order: Object,
    deliveryStatus: Object,
});

const delivery = useForm({
    status: props.order.delivery_status,
    payment_status: props.order.payment_status,
});

const { onFormSubmit } = useFormSubmit(delivery, "orders");

function onChangeStatus(bool) {
    let message;
    if (!bool) {
        message = `Success Change Delivery Status to ${delivery.status}`;
    } else {
        message = `Success Change Payment Status to ${delivery.payment_status}`;
    }
    const options = {
        onSuccess: () => {
            showToast(message);
        },
    };
    onFormSubmit(options, props.order);
}

const refundHandler = (id) => {
    let x = confirm("Are u sure you want to refund");
    if (x) {
        router.post(
            route("admin.orders.refund", id),
            {},
            {
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => {
                    showSuccessToast("Success!");
                },
            }
        );
    }
};
</script>
