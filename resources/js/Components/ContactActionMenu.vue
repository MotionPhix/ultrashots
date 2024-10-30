<script setup lang="ts">
import IconContactAdd from '@/Components/Icon/IconContactAdd.vue';
import IconContactRemove from '@/Components/Icon/IconContactRemove.vue';
import {useContactStore} from '@/Stores/contactStore';
import {Link, usePage} from '@inertiajs/vue3';
import {
  IconArrowCapsule,
  IconHeartMinus,
  IconHeartPlus,
  IconMailForward,
  IconPencil,
  IconTrash
} from '@tabler/icons-vue';
import {storeToRefs} from 'pinia';
import {ref} from 'vue';

interface Props {
  contactBase: Object
}

const props = defineProps<Props>()

const url = ref(usePage().url)

const contactStore = useContactStore()

const {expungeSelectedContacts} = contactStore

const {
  selectedContacts
} = storeToRefs(contactStore)

if (!url.value.startsWith('/m/compose') && selectedContacts.value.length) {
  expungeSelectedContacts()
}
</script>

<template>
  <section
    class="sticky top-0 z-10 flex items-center w-full h-16 gap-6 p-6 pl-8 dark:bg-neutral-900 border-b bg-neutral-100 dark:text-white dark:border-gray-500"
    v-if="!selectedContacts.length">

    <Link
      as="button"
      :href="route('contacts.create')"
      class="flex items-center gap-2 transition duration-300 hover:opacity-70 hover:text-neutral-700 dark:hover:text-neutral-300">
      <IconContactAdd class="size-5 stroke-current"/>
      <span>New</span> <span class="hidden inline-flex"> contact</span>
    </Link>

    <UltraLink
      position="top"
      href="#upload-contact-file"
      class="flex gap-2 items-center transition duration-300 hover:opacity-70 hover:text-neutral-700 dark:hover:text-neutral-300"
      as="button">

      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" class="size-5"
           color="currentColor" fill="none">
        <path
          d="M11.1002 3C7.45057 3.00657 5.53942 3.09617 4.31806 4.31754C3 5.63559 3 7.75698 3 11.9997C3 16.2425 3 18.3639 4.31806 19.6819C5.63611 21 7.7575 21 12.0003 21C16.243 21 18.3644 21 19.6825 19.6819C20.9038 18.4606 20.9934 16.5494 21 12.8998"
          stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        <path
          d="M20.9995 6.02511L20 6.02258C16.2634 6.01313 14.3951 6.0084 13.0817 6.95247C12.6452 7.2662 12.2622 7.64826 11.9474 8.08394C11 9.39497 11 11.2633 11 14.9998M20.9995 6.02511C21.0062 5.86248 20.9481 5.69887 20.8251 5.55315C20.0599 4.64668 18.0711 2.99982 18.0711 2.99982M20.9995 6.02511C20.9934 6.17094 20.9352 6.31598 20.8249 6.44663C20.0596 7.35292 18.0711 8.99982 18.0711 8.99982"
          stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>

      <span>Import</span> <span class="hidden sm:inline-flex"> contacts</span>

    </UltraLink>

  </section>

  <section
    class="fixed top-0 z-20 flex items-center w-full h-16 gap-6 p-6 pl-8 bg-gray-100 border-b dark:bg-gray-800 dark:text-white dark:border-gray-500"
    v-if="selectedContacts.length && Object.keys(contactBase).length">
    <Link
      as="button"
      :href="route('contacts.edit', selectedContacts[0])"
      v-if="selectedContacts.length === 1 && $page.url === '/contacts'"
      class="flex items-center gap-2 font-semibold transition duration-300 hover:opacity-70">
      <IconPencil class="w-5 h-5 stroke-current"/>
      <span class="hidden md:inline-flex">Edit</span>
    </Link>

    <Link
      as="button"
      method="patch"
      v-if="Object.keys(contactBase).length && (!$page.url.startsWith('/contacts/deleted') && !$page.url.startsWith('/contacts/favourites'))"
      :href="route('contacts.favourite', { ids: selectedContacts } as any)"
      class="flex items-center gap-2 font-semibold transition duration-300 hover:opacity-70">
      <IconHeartPlus class="w-5 h-5 stroke-current"/>
      <span class="hidden md:inline-flex">Add to favourites</span>
    </Link>

    <Link
      as="button"
      method="patch"
      v-if="Object.keys(contactBase).length && $page.url.startsWith('/contacts/favourites')"
      :href="route('contacts.favourite', { ids: selectedContacts } as any)"
      class="flex items-center gap-2 font-semibold transition duration-300 hover:opacity-70">
      <IconHeartMinus class="w-5 h-5 stroke-current"/>
      <span class="hidden md:inline-flex">Remove from favourites</span>
    </Link>

    <Link
      as="button"
      method="delete"
      v-if="$page.url.startsWith('/contacts/deleted')"
      :href="route('contacts.destroy', { ids: selectedContacts } as any)"
      class="flex items-center gap-2 font-semibold transition duration-300 hover:opacity-70">
      <IconContactRemove class="w-5 h-5 stroke-current text-rose-500"/>
      <span class="hidden md:inline-flex">Delete</span>
    </Link>

    <Link
      as="button"
      method="put"
      v-if="$page.url.startsWith('/contacts/deleted')"
      :href="route('contacts.restore', { ids: selectedContacts } as any)"
      class="flex items-center gap-2 font-semibold transition duration-300 hover:opacity-70"
      preserve-scroll>

      <IconArrowCapsule class="w-5 h-5 stroke-current"/>
      <span class="hidden md:inline-flex">
        Restore
      </span>

    </Link>

    <Link
      :href="route('mail.compose')"
      class="flex items-center gap-2 px-1.5 font-semibold rounded-md"
      v-if="!$page.url.startsWith('/contacts/deleted')"
      preserve-scroll
      as="button">

      <IconMailForward class="w-5 h-5"/>
      <span class="hidden md:inline-flex">Send email</span>

    </Link>

    <Link
      as="button"
      method="delete"
      v-if="$page.url === '/contacts' || $page.url.startsWith('/tags')"
      :href="route('contacts.destroy', { ids: selectedContacts } as any)"
      class="flex items-center gap-2 font-semibold transition duration-300 hover:opacity-70">
      <IconTrash class="w-5 h-5 stroke-current"/>
      <span class="hidden md:inline-flex">Delete</span>
    </Link>

  </section>

  <UltraModal
    name="upload-contact-file" v-slot="{ close }"
    panel-classes="dark:bg-neutral-700 rounded-xl dark:text-neutral-100"
    :close-button="false">

    <h2 class="text-2xl font-semibold mb-6">Import contacts</h2>

    <article class="grid sm:grid-cols-2 grid-cols-1 gap-6 sm:gap-16">

      <div>

        <p class="mb-2">
          You can import contacts from other email apps using a comma separated values file (CSV).
          For best results, make sure that the file has UTF-8 encoding.
        </p>

        <p class="mb-6">
          The contacts you import will not overwrite any of your existing contacts.
        </p>

      </div>

      <div>

        <form class="space-y-4">
          <label class="block">
            <span class="font-medium">Upload your CSV file</span>
            <input
              type="file"
              class="mt-2 block w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
          </label>

          <div class="flex justify-end space-x-2">
            <button
              type="button"
              @click="close"
              class="px-4 py-2 dark:bg-transparent hover:text-opacity-40">
              Cancel
            </button>

            <button
              type="submit" class="px-4 py-2 text-white bg-lime-600 rounded hover:bg-lime-700">
              Import
            </button>
          </div>
        </form>

      </div>

    </article>

  </UltraModal>
</template>
