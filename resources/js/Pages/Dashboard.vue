<script setup>
import AuthLayout from '@/Layouts/AuthLayout.vue';
import {Head} from '@inertiajs/vue3';

defineOptions({
  layout: AuthLayout
})
</script>

<template>
  <Head title="Dashboard"/>

  <div class="py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
    <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
      <div class="p-6 text-gray-900 dark:text-gray-100">
        Analytics will be shown here
      </div>
    </div>
  </div>
</template>
