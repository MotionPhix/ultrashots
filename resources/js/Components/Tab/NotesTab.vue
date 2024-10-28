<script lang="ts" setup>
import type { Contact } from '@/types/index';
import { ModalLink } from '@inertiaui/modal-vue'
import { IconNote, IconNotes } from '@tabler/icons-vue';

defineProps<{
  contact: Contact
}>()
</script>

<template>
  <section
    class="flex flex-col mt-10">

    <div class="mb-4 flex gap-6 items-center">

      <IconNote class="shrink-0" />

      <h3 class="text-lg font-semibold">Notes</h3>

    </div>

    <div class="w-full">

      <section
        v-html="contact.bio"
        class="prose prose-sm dark:prose-invert empty:hidden"
        v-if="contact.bio"  />

      <div class="flex flex-col items-center gap-3 text-gray-500 empty:hidden" v-else>
        <IconNote class="w-48 h-48 text-gray-400" stroke-width="1" />

        <h2 class="mt-6 text-xl font-semibold leading-none text-center">
          No notes found!
        </h2>

        <p class="text-sm text-center">
          Add <strong>{{ contact.first_name }}</strong>'s notes here.
        </p>

        <div>
          <ModalLink
            as="button"
            :close-button="false"
            :close-explicitly="true"
            class="flex gap-2 items-center text-gray-500 border-gray-500 border hover:border-gray-900 rounded-lg dark:border-slate-600 dark:text-gray-500 font-semibold my-4 px-3 py-1.5 dark:hover:text-gray-400 dark:hover:border-gray-400 hover:text-gray-900 transition duration-300"
            :href="route('contacts.edit', { contact: contact.cid, modal: true })" preserve-scroll>

            <IconNotes class="w-5 h-5" />

            <span>Add notes</span>

          </ModalLink>
        </div>
      </div>
    </div>
  </section>
</template>
