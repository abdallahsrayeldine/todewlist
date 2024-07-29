<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
    url: {
        type: String,
        required: true,
    }
});

// Generate a unique pattern ID
const uniqueId = ref(`pattern${Math.random().toString(36)}`);

const patternId = computed(() => `url(#${uniqueId.value})`);
</script>

<template>
    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="33"
        viewBox="0 0 32 33" fill="none">
        <path
            d="M0.578051 6.51246C0.327347 14.678 -0.289544 22.8823 0.159092 31.0852C0.33639 32.497 4.75403 32.4968 5.79801 32.4968L5.81504 32.4968L17.4761 32.4968C21.8841 32.4968 25.6275 32.6076 29.9467 31.5296C31.5552 31.1281 32 19.2547 32 17.7009C32 12.7576 31.6937 8.02701 30.8179 3.21867C30.381 0.819615 30.0959 0.5 27.9783 0.5L6.88572 0.5C2.30166 0.5 0.750363 0.900211 0.578051 6.51246Z"
            :fill="patternId" />
        <defs>
            <pattern :id="uniqueId" patternContentUnits="objectBoundingBox" width="1" height="1">
                <use xlink:href="#image" transform="matrix(0 0.00160256 -0.00160256 0 1.16667 0)" />
            </pattern>
            <image id="image" width="624" height="832" :xlink:href="url" />
        </defs>
    </svg>
</template>
