<script setup>
import { useErrorStore } from './stores/error';
import ServerError from './views/ServerError.vue';

const errorStore = useErrorStore();

</script>

<template>
  <router-view v-if="!errorStore.showServerError" />
  <ServerError v-else />
</template>

<style scoped></style>
