<script setup lang="ts">
import IconContactAdd from '@/Components/icons/IconContactAdd.vue';
import IconContactRemove from '@/Components/icons/IconContactRemove.vue';
import { useContactStore } from '@/Stores/contactStore';
import { Link, usePage } from '@inertiajs/vue3';
import { IconArrowCapsule, IconHeartPlus, IconMailForward, IconPencil, IconTrash } from '@tabler/icons-vue';
import { storeToRefs } from 'pinia';
import { ref } from 'vue';

interface Props {
  contactBase: Object
}

const props = defineProps<Props>()

const url = ref(usePage().url)

const contactStore = useContactStore()

const { expungeSelectedContacts } = contactStore

const {
  selectedContacts
} = storeToRefs(contactStore)

if (url.value.startsWith('/deleted') || url.value.startsWith('/favourites')) {
  expungeSelectedContacts()
}
</script>

<template>
  <section
    class="fixed top-0 z-30 flex items-center w-full gap-6 p-6 pl-8 bg-gray-100 border-b dark:bg-gray-800 dark:text-white dark:border-gray-500"
      v-if="!selectedContacts.length">

    <Link
      as="button"
      :href="route('contacts.create')"
      class="flex items-center gap-2 font-semibold transition duration-300 hover:opacity-70">
      <IconContactAdd class="w-5 h-5 stroke-current" /> <span>New contact</span>
    </Link>

  </section>

  <section
    class="fixed top-0 z-30 flex items-center w-full gap-6 p-6 pl-8 bg-gray-100 border-b dark:bg-gray-800 dark:text-white dark:border-gray-500"
    v-if="selectedContacts.length && Object.keys(contactBase).length">
    <Link
      as="button"
      :href="route('contacts.edit', selectedContacts[0])"
      v-if="selectedContacts.length === 1 && $page.url === '/'"
      class="flex items-center gap-2 font-semibold transition duration-300 hover:opacity-70">
      <IconPencil class="w-5 h-5 stroke-current" /> <span class="hidden md:inline-flex">Edit</span>
    </Link>

    <Link
      as="button"
      method="patch"
      v-if="Object.keys(contactBase).length && !$page.url.startsWith('/deleted')"
      :href="route('contacts.favourite', { ids: selectedContacts })"
      class="flex items-center gap-2 font-semibold transition duration-300 hover:opacity-70">
      <IconHeartPlus class="w-5 h-5 stroke-current" /> <span class="hidden md:inline-flex">Add to favourites</span>
    </Link>

    <Link
      as="button"
      method="delete"
      v-if="$page.url === '/' || $page.url.startsWith('/tags')"
      :href="route('contacts.destroy', { ids: selectedContacts })"
      class="flex items-center gap-2 font-semibold transition duration-300 hover:opacity-70">
      <IconTrash class="w-5 h-5 stroke-current" /> <span class="hidden md:inline-flex">Delete</span>
    </Link>

    <Link
      as="button"
      method="delete"
      v-if="$page.url.startsWith('/deleted')"
      :href="route('contacts.destroy', { ids: selectedContacts })"
      class="flex items-center gap-2 font-semibold transition duration-300 hover:opacity-70">
      <IconContactRemove class="w-5 h-5 stroke-current text-rose-500" /> <span class="hidden md:inline-flex">Delete</span>
    </Link>

    <Link
      as="button"
      method="put"
      v-if="$page.url.startsWith('/deleted')"
      :href="route('contacts.restore', { ids: selectedContacts })"
      class="flex items-center gap-2 font-semibold transition duration-300 hover:opacity-70"
      preserve-scroll>

      <IconArrowCapsule class="w-5 h-5 stroke-current" />
      <span class="hidden md:inline-flex">
        Restore
      </span>

    </Link>

    <touch-ripple>
      <Link
        :href="route('mail.compose')"
        class="flex items-center gap-2 px-1.5 py-1 font-semibold rounded-md"
        v-if="!$page.url.startsWith('/deleted')"
        preserve-scroll
        as="button">

        <IconMailForward class="w-5 h-5" />
        <span class="hidden md:inline-flex">Send mail</span>

      </Link>
    </touch-ripple>
  </section>
</template>
