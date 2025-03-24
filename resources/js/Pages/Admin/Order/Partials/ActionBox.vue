<template>
    <div class="flex space-x-3 items-end justify-start">
        <div>
            <InputLabel value="Order number" />
            <TextInput
                class="font-normal"
                v-model="name"
                @input="onChangeInput"
            />
        </div>
        <div>
            <InputLabel value="Delivery Status" />
            <select
                v-model="delivery"
                @change="onChangeInput"
                class="form-control w-full font-normal capitalize"
            >
                <option value="">Select one</option>
                <option
                    v-for="(item, index) in deliveryStatus"
                    :key="index"
                    :value="index"
                >
                    {{ item }}
                </option>
            </select>
        </div>
        <div>
            <InputLabel value="Payment Status" />
            <select
                v-model="payment"
                @change="onChangeInput"
                class="form-control w-full font-normal capitalize"
            >
                <option value="">Select one</option>
                <option
                    v-for="(item, index) in paymentStatus"
                    :key="index"
                    :value="index"
                >
                    {{ item }}
                </option>
            </select>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useSearch } from "@/composables/useSearch";

const props = defineProps({
    deliveryStatus: Object,
    paymentStatus: Object,
    params: Object,
});

console.log(props.params);

const name = ref(props?.params.order_no ?? "");
const delivery = ref(props?.params.delivery ?? "");
const payment = ref(props?.params.payment ?? "");

const { onListingFilter } = useSearch("orders");

const onChangeInput = () => {
    onListingFilter({
        order_no: name.value,
        delivery: delivery.value,
        payment: payment.value,
    });
};
</script>

<style lang="scss" scoped></style>
