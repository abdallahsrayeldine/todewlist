<script setup>
const emits = defineEmits(['close']);
const props = defineProps({
    imgLink: String,
});
</script>
<template>
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-biege-light p-5 rounded-3xl w-[50%] h-[85%] relative mx-auto my-4">
            <p class="absolute text-black text-3xl ml-4" @click="$emit('close')">
                X
            </p>
            <img :src="imgLink" class="w-full h-full rounded-3xl mx-auto" />
        </div>
    </div>
</template>
