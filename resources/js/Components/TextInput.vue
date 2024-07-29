<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        class="bg-biege rounded-xl border-transparent outline-none focus:ring-0 focus:border-transparent font-IrishGrover w-full h-12 py-2 px-4 placeholder:text-biege-dark cursor-none"
        v-model="model" ref="input" />
</template>
