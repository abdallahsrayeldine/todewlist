<script setup>
import { onMounted } from 'vue';
onMounted(() => {
    document.addEventListener("mousemove", moveCursor);
});

function moveCursor(e) {
    const cursor = document.getElementById("cursor");
    if (cursor) {
        const x = e.clientX;
        const y = e.clientY;
        cursor.style.left = `${x}px`;
        cursor.style.top = `${y}px`;
    }
}
</script>
<template>
    <img src="pictures/cursor.svg" id="cursor"
        class="fixed -translate-x-6 -translate-y-0.5 w-[4%] h-[4%] pointer-events-none z-10" />
</template>
