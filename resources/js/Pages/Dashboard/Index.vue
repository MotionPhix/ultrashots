<script setup>
import AuthLayout from '@/Layouts/AuthLayout.vue';
import SentEmailChart from '@/Components/SentEmailChart.vue';
import {Head} from '@inertiajs/vue3';

defineProps({
  brand: Object
});

// Sample email data
const sentEmailData = [
  {date: '2024-10-01', count: 20},
  {date: '2024-10-05', count: 55},
  {date: '2024-10-10', count: 120},
  {date: '2024-10-15', count: 90},
  {date: '2024-10-20', count: 200},
];

defineOptions({
  layout: AuthLayout
})
</script>

<template>

  <Head title="Dashboard"/>

  <div class="py-10 dark:text-neutral-300">

    <h2 class="text-2xl font-semibold mb-6">Welcome</h2>

    <!-- Analytics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">

      <div class="bg-blue-100 p-4 rounded-lg shadow-md text-center">
        Hello, {{ $page.props.auth.user.name }}
      </div>

    </div>

  </div>

</template>
