<script setup lang="ts">
import ActionMenu from '@/Components/ActionMenu.vue';
import ContactCard from '@/Components/ContactCard.vue';
import NoContactFound from '@/Components/NoContactFound.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import type { ContactsData } from '@/types/index';
import { Head } from '@inertiajs/vue3';

interface Props {
  baseGroup: ContactsData;
}

const props = defineProps<Props>()

defineOptions({ layout: AuthenticatedLayout })
</script>

<template>
  <Head title="Explore Contacts" />

  <ActionMenu :contactBase="baseGroup" />

  <div class="py-12">
    <div class="flex px-6 mx-auto max-w-7xl">

      <template v-if="Object.keys(baseGroup).length">
        <section>
          <div
            v-for="(contactsArray, group) in baseGroup"
            :key="group" class="pt-10 space-y-4">
            <span
              class="flex items-center justify-center w-8 h-8 p-1 mb-4 ml-16 font-bold text-white bg-gray-600 rounded dark:bg-gray-200 dark:text-gray-900">
              {{ group }}
            </span>

            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-500">
              <ContactCard
                v-for="(contact) in contactsArray"
                :contact="contact"
                :key="contact.id" />
            </ul>
          </div>
        </section>
      </template>

      <article v-else class="py-12 sm:rounded-lg">
        <NoContactFound />
      </article>
    </div>
  </div>
</template>
