<script setup>
import { useLinkStore } from '@/stores/link';
// const linkStore = useLinkStore();

useLinkStore().getLinks();
</script>

<template>
    <router-view />
</template>

<style scoped></style>
