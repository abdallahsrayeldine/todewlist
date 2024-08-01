<script setup>
import { onMounted, onBeforeUnmount } from 'vue';
const cursorPositionKey = 'cursorPosition';

onMounted(() => {
    const cursor = document.getElementById("cursor");
    const storedPosition = localStorage.getItem(cursorPositionKey);
    if (storedPosition) {
        const { x, y } = JSON.parse(storedPosition);
        if (cursor) {
            cursor.style.left = `${x}px`;
            cursor.style.top = `${y}px`;
        }
    }
    document.addEventListener("mousemove", moveCursor);
});

onBeforeUnmount(() => {
    document.removeEventListener("mousemove", moveCursor);
});

function moveCursor(e) {
    const cursor = document.getElementById("cursor");
    if (cursor) {
        const x = e.clientX;
        const y = e.clientY;
        cursor.style.left = `${x}px`;
        cursor.style.top = `${y}px`;
        localStorage.setItem(cursorPositionKey, JSON.stringify({ x, y }));
    }
}
</script>
<template>
    <img src="pictures/cursor.svg" id="cursor"
        class="fixed -translate-x-5 -translate-y-0 w-[4%] h-[4%] pointer-events-none z-10" />
</template>
