<script setup>
import { onMounted, ref } from "vue";

const model = defineModel({
    required: false,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute("autofocus")) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input class="form-control" v-model="model" ref="input" />
</template>
