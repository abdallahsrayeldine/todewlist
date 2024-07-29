<script setup>
const props = defineProps({
    imageurl: {
        type: String,
        required: true,
    }
});
</script>

<template>
    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="50" height="53"
        viewBox="0 0 50 53" fill="none">
        <path
            d="M6.52098 43.1459C15.6204 54.1947 31.7444 55.5945 42.5291 46.2655C47.9332 41.5909 49.9366 36.0001 49.4221 30.1903C48.91 24.4087 45.9107 18.4585 41.4122 12.9964C36.9147 7.53536 31.6923 3.50156 26.2086 2.01093C20.693 0.511642 14.9698 1.60228 9.56495 6.27753C-1.21254 15.6003 -2.57253 32.1043 6.52098 43.1459Z"
            fill="url(#pattern0_31_960)" stroke="#E8FF5B" />
        <defs>
            <pattern id="pattern0_31_960" patternContentUnits="objectBoundingBox" width="1" height="1">
                <use xlink:href="#image0_31_960" transform="translate(-0.452691 -0.000670331) scale(0.00276861)" />
            </pattern>
            <image id="image0_31_960" width="700" height="370" :href="imageurl" />

        </defs>
    </svg>
</template>
