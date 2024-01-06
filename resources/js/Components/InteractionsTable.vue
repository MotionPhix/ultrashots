<script setup lang="ts">
import type { Contact, Interaction } from '@/types';

const props = defineProps<{
  interactions: Interaction[]
  contact: Contact
}>()
</script>

<template>
  <div class="relative mx-2 overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
      <caption class="p-5 text-lg font-semibold text-left text-gray-900 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        Interactions
        <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">
          <!-- Shows timeframe of conversations <strong>{{ $page.props.auth.user.id === contact.user.id ? 'you' : contact.user.first_name }}</strong> have had with <strong>{{ `${contact.full_name}` }}</strong> -->
        </p>
      </caption>

      <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
        <tr>
          <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
            Topic
          </th>
          <th scope="col" class="px-6 py-3">
            Type
          </th>
          <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
            Interacted
          </th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="interact in interactions" :key="interact.id" class="border-b border-gray-200 dark:border-gray-700">
          <th scope="row" class="px-6 py-4 font-medium text-gray-900 bg-gray-50 dark:text-white dark:bg-gray-800">
            {{ interact.topic }}
          </th>
          <td class="px-6 py-4">
            {{ interact.type }}
          </td>
          <td class="w-1/5 px-6 py-4 bg-gray-50 dark:bg-gray-800">
            <span class="block leading-none">{{ interact.interacted_on }}</span>
            <span class="block font-semibold text-xxs">on {{ interact.interaction_date }}</span>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
