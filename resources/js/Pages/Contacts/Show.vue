<script setup lang="ts">
import ActionMenu from '@/Components/ActionMenu.vue';
import ContactCard from '@/Components/ContactCard.vue';
import IconContacts from '@/Components/Icons/IconContacts.vue';
import NavTabs from '@/Components/NavTabs.vue';
import PrimaryButtonLink from '@/Components/PrimaryButtonLink.vue';
import InteractionsTab from '@/Components/tabs/InteractionsTab.vue';
import OverviewTab from '@/Components/tabs/OverviewTab.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import type { Contact, ContactsData } from '@/types/index';
import { Head, Link } from '@inertiajs/vue3';
import { IconMailFast, IconUserMinus } from '@tabler/icons-vue';
import { computed, ref } from 'vue';

interface Props {
  baseGroup: ContactsData
  contact: Contact
}

const props = defineProps<Props>()

const selectedContactIds = ref<string[]>([])

const selectedEmails = computed(() => {
  if(selectedContactIds.value.length) return selectedContactIds.value

  return [props.contact.cid]
})

function isSelected(contactId: string) {
  return (selectedContactIds.value.includes(contactId));
}

function onContactSelect(contactId: string) {

  if (isSelected(contactId)) {
    selectedContactIds.value = selectedContactIds.value.filter((selectedId) => {
      return (selectedId !== contactId);
    });

  } else {
    selectedContactIds.value.push(contactId);
  }
}

defineOptions({ layout: AuthenticatedLayout })
</script>

<template>
  <Head :title="contact.first_name + ' ' + contact.last_name" />

  <ActionMenu :contactBase="baseGroup" />

  <div class="pt-12 mb-10 lg:mb-0 lg:h-screen mx-auto flex gap-6 max-w-7xl sm:px-6 lg:px-8">

    <section
      class="pt-10 max-w-sm w-full space-y-4 overflow-y-auto scrollbar-thin hidden lg:block">
      <div
        v-for="(contactsArray, group) in baseGroup"
        :key="group"
        class="pt-2 mr-4 pb-6">
        <span
          class="flex items-center justify-center w-8 h-8 p-1 mb-4 ml-16 font-bold text-white bg-gray-600 rounded dark:bg-gray-200 dark:text-gray-900">
          {{ group }}
        </span>

        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-500">
          <ContactCard
            v-for="(contact) in contactsArray"
            :onContactSelect="onContactSelect"
            :selected="selectedContactIds"
            :contact="contact"
            :key="contact.id" />
        </ul>
      </div>
    </section>

    <section class="scrollbar-thin lg:overflow-y-auto mt-12 space-y-4 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
      <div
        class="empty:hidden h-full flex flex-col justify-center items-center"
        v-if="selectedContactIds.length > 1">
        <div class="flex flex-col items-center gap-3 text-gray-500">
          <IconContacts class="text-gray-400 h-48 w-48" stroke-width="1" />

          <h2 class="text-xl font-semibold leading-none text-center mt-6">
            {{ selectedContactIds.length }} contacts selected
          </h2>

          <span class="mt-4 mb-1 h-px bg-rose-500 block w-full"></span>

          <div class="flex gap-6">
            <Link
              as="button"
              class="flex gap-2 items-center text-gray-500 border-gray-500 border hover:border-gray-900 rounded-lg dark:border-slate-600 dark:text-gray-500 font-semibold my-4 px-3 py-1.5 dark:hover:text-gray-400 dark:hover:border-gray-400 hover:text-gray-900 transition duration-300"
              :href="route('mail.compose', selectedEmails)"
              preserve-scroll>

              <IconMailFast class="w-5 h-5" />
              <span>Send mail</span>

            </Link>

            <Link
              as="button"
              class="flex gap-2 items-center text-gray-500 border-gray-500 border hover:border-gray-900 rounded-lg dark:border-slate-600 dark:text-gray-500 font-semibold my-4 px-3 py-1.5 dark:hover:text-gray-400 dark:hover:border-gray-400 hover:text-gray-900 transition duration-300"
              :href="route('contacts.destroy', selectedContactIds)" preserve-scroll>

            <IconUserMinus class="w-5 h-5" />
            <span>Delete</span>

            </Link>
          </div>
        </div>
      </div>

      <div v-else class="empty:hidden p-6">
        <section class="flex items-center gap-6">
          <div
            class="w-24 h-24 shrink-0 text-3xl rounded-full items-center justify-center flex font-bold"
            :class="contact.is_favorite ? 'bg-blue-500 text-blue-50' : 'bg-lime-500 text-lime-900'">
            <span>
              {{ contact.first_name[0] }}{{ contact.last_name[0] }}
            </span>
          </div>

          <div class="flex flex-col gap-1">
            <h3 class="text-3xl">
              {{ contact.first_name + ' ' + contact.last_name }}
            </h3>

            <span>{{ contact.last_company?.pivot.job_title }}</span>

            <div class="flex items-center gap-6 font-semibold">
              <PrimaryButtonLink
                :href="route('mail.compose', { emails: selectedEmails })">
                <IconMailFast />
                <span>Email</span>
              </PrimaryButtonLink>

              <button>Call</button>

              <Link
                as="button"
                class="hover:opacity-70 transition duration-300"
                :href="route('contacts.edit', contact.cid)">
                Edit
              </Link>

              <Link
                as="button"
                class="text-rose-500 hover:opacity-70 transition duration-300"
                :href="route('contacts.destroy', {ids: [contact.cid]})"
                method="delete">
                Delete
              </Link>
            </div>
          </div>
        </section>

        <NavTabs>

          <template #tab_1>

            <OverviewTab :contact="contact" />

          </template>

          <template #tab_2>

            <InteractionsTab :contact="contact" />

          </template>

        </NavTabs>

      </div>
    </section>

  </div>
</template>
