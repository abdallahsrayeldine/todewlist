<script setup>
import { computed } from 'vue';

// Use defineProps to get props directly
const props = defineProps({
    index: {
        type: Number,
        required: true,
    },
    activeIndex: {
        type: Number,
        required: true,
        default: 0
    },
});

// Compute the color based on the index and activeIndex props
const color = computed(() => (props.index <= props.activeIndex ? '#00992C' : '#DED295'));
</script>

<template>
    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="17" viewBox="0 0 13 17" :fill="color">
        <path
            d="M6.97019 0.250446C6.95875 0.235268 6.9435 0.223884 6.93587 0.2125L6.93206 0.208705C6.79476 0.0796875 6.60789 0 6.40196 0C6.1922 0 6.00533 0.0796875 5.87185 0.208705L5.86804 0.2125C5.8566 0.223884 5.84516 0.235268 5.83372 0.250446C5.60108 0.489509 5.30743 0.796875 4.97945 1.16496C4.31587 1.9125 3.50736 2.91049 2.74844 4.07924C1.47467 6.04487 0.349627 8.48482 0.303862 11.0272C0.303862 11.0766 0.300049 11.1297 0.300049 11.179C0.300049 11.9266 0.448783 12.64 0.715741 13.2964C0.872103 13.6759 1.0666 14.0326 1.29542 14.3665C2.38232 15.9527 4.26247 17 6.39814 17C9.76944 17 12.5 14.3931 12.5 11.179C12.5 6.32567 8.48804 1.79107 6.97019 0.250446ZM6.39814 14.875C5.79558 14.875 5.22734 14.7346 4.72393 14.4917C7.23715 13.9453 9.23934 12.0366 9.90292 9.57768C10.1012 10.0368 10.2156 10.5453 10.2156 11.0804C10.2118 13.175 8.5033 14.875 6.39814 14.875Z" />
    </svg>
</template>
