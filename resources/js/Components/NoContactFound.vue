<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

import IconContactAdd from './icons/IconContactAdd.vue';
import IconContacts from './icons/IconContacts.vue';

const { url } = usePage()

const context = computed(() => {
  if (url.startsWith('/favourites')) {
    return {
      title: 'favourites',
      description: 'You haven\'t added anyone to your favourites yet'
    }
  }

  if (url.startsWith('/deleted')) {
    return {
      title: 'deleted contacts',
      description: 'All good! You haven\'t deleted any contacts yet'
    }
  }

  return {
    title: 'contacts',
    description: 'You haven\'t added any contacts yet.'
  }

})
</script>

<template>
  <div class="flex flex-col items-center gap-3">
    <IconContacts class="text-gray-400 h-48 w-48" stroke-width="1" />

    <h2 class="text-xl font-semibold leading-none text-center text-gray-500 mt-6">
      No {{ context.title }} found!
    </h2>

    <p class="text-sm text-center text-gray-500">
      {{ context.description }}
    </p>

    <div v-if="$page.url === '/'">
      <Link as="button"
        class="flex gap-2 items-center text-gray-500 border-gray-500 border hover:border-gray-900 rounded-lg dark:border-slate-600 dark:text-gray-500 font-semibold my-4 px-3 py-1.5 dark:hover:text-gray-400 dark:hover:border-gray-400 hover:text-gray-900 transition duration-300"
        :href="route('contacts.create')" preserve-scroll>

      <IconContactAdd class="w-5 h-5" />
      <span>Add contact</span>

      </Link>
    </div>
  </div>
</template>
