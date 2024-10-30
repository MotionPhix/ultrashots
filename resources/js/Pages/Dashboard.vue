<script setup>
import AuthLayout from '@/Layouts/AuthLayout.vue';
import SentEmailChart from '@/Components/SentEmailChart.vue';
import {Head} from '@inertiajs/vue3';

const props = defineProps({
  analytics: Object
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

  <Head title="Analytics"/>

  <div class="py-10 dark:text-neutral-300">

    <h2 class="text-2xl font-semibold mb-6">Analytics</h2>

    <!-- Analytics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">

      <div class="bg-blue-100 p-4 rounded-lg shadow-md text-center">
        <h3 class="text-xl font-bold">{{ analytics.user_count }}</h3>
        <p class="text-gray-600">Users</p>
      </div>

      <div class="bg-green-100 p-4 rounded-lg shadow-md text-center">
        <h3 class="text-xl font-bold">{{ analytics.contact_count }}</h3>
        <p class="text-gray-600">Contacts</p>
      </div>

      <div class="bg-yellow-100 p-4 rounded-lg shadow-md text-center">
        <h3 class="text-xl font-bold">{{ analytics.contact_group_count }}</h3>
        <p class="text-gray-600">Contact Groups</p>
      </div>

      <div class="bg-red-100 p-4 rounded-lg shadow-md text-center">
        <h3 class="text-xl font-bold">{{ analytics.sent_email_count }}</h3>
        <p class="text-gray-600">Sent Emails</p>
      </div>

    </div>

    <!-- Graph for Sent Emails -->
    <div class="bg-white rounded-lg shadow-md p-6">

      <h4 class="text-xl font-semibold mb-4">Sent Emails Over Time</h4>

      <SentEmailChart :data="sentEmailData"/>

    </div>

  </div>

</template>
