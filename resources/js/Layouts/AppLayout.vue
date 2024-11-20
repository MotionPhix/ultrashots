<script setup lang="ts">
import { useDark } from '@vueuse/core';
import { onMounted } from 'vue';
import AppFooter from "@/Components/AppFooter.vue";

const isDark = useDark()
</script>

<template>
  <div class="flex flex-col items-center w-full min-h-screen bg-gray-100 dark:bg-gray-900">
    <slot />

    <AppFooter />
  </div>
</template>
