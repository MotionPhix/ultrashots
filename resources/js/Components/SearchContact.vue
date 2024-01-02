<script setup>
import { inject } from 'vue';

defineProps({
  result: {
    type: Object,
    required: true,
  },
})

const Splade = inject('$splade')

function detail(contact) {
  Splade.visit(`/contacts/${contact.id}`)
}
</script>

<template>
  <div class="flex items-start justify-between p-6 bg-white border border-gray-200 shadow dark:bg-gray-800 dark:border-gray-700">
    <p class="font-normal text-gray-500 dark:text-gray-400 linecramp-2">
      <span class="text-2xl text-thin">
        {{ `${result.first_name} ${result.last_name}` }}
      </span>

      <span>
        <h5 class="font-semibold tracking-tight text-gray-900 dark:text-white">
          {{ result.company?.name ? result.company.name + ' | ' : '' + result.email }}
        </h5>
      </span>
    </p>

    <button type="button" class="inline-flex items-center text-green-600" @click="detail(result)">
      See contact
      <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z" /><path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z" /></svg>
    </button>
  </div>
</template>
