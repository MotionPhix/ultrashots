<script lang="ts" setup>
import InputError from '@/Components/InputError.vue';
import TipTap from '@/Components/TipTap.vue';
import AuthenticatedLayout from '@/Layouts/Keep.AuthenticatedLayout.bak.txt';
import { useContactStore } from '@/Stores/contactStore';
import { Link, router, useForm, usePage } from '@inertiajs/vue3';
import { IconMailFast } from '@tabler/icons-vue';
import { storeToRefs } from 'pinia';
import TurndownService from 'turndown';
import { onMounted } from 'vue';

const contactStore = useContactStore()

const {
  selectedContacts
} = storeToRefs(contactStore)

const turndownService = new TurndownService()

const form = useForm({
  subject: '',
  body: '',
  recipients: selectedContacts,
})

function send() {
  form.body = turndownService.turndown(form.body)

  form.post(route('mail.send', { contacts: selectedContacts.value } as any),{
    preserveScroll: true,
  })
}

defineOptions({
  layout: AuthenticatedLayout
})

onMounted(() => {

  if (usePage().url.startsWith('/compose') && !selectedContacts.value.length) {
    router.get(route('contacts.index'), {}, {
      preserveScroll: true
    })
  }

})
</script>

<template>

  <form
    @submit.prevent="send"
    class="max-w-2xl px-6 mx-auto mt-16 space-y-10 sm:mt-8">

    <div>
      <label
        for="subject"
        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
        Email subject
      </label>

      <input
        id="subject"
        v-model="form.subject"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-600 focus:border-lime-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-lime-500 dark:focus:border-lime-500"
        placeholder="Enter email subject"
        type="text">

      <InputError :message="form.errors.subject" />
    </div>

    <div class="mt-4">
      <label
        for="message"
        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
        Email content
      </label>

      <section>
        <TipTap v-model="form.body" placeholder="Write your email" />
      </section>

      <InputError :message="form.errors.body" />
    </div>

    <div
      class="flex items-center justify-end col-span-4 gap-4 pt-4">
      <button
        type="submit"
        :disabled="form.processing"
        class="text-white inline-flex gap-2 transition duration-300 items-center bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-semibold rounded-lg px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
        <IconMailFast class="w-6 h-6" />

        <span>Send mail</span>
      </button>

      <Link
        as="button"
        :href="route('contacts.index')"
        class="py-2.5 text-gray-800 font-semibold dark:text-white hover:text-opacity-40 transition duration-300 inline-flex items-center border-gray-700 hover:border-opacity-40 focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-lg px-5 text-center border dark:border-gray-600 dark:hover:border-gray-700 dark:focus:ring-gray-800">
        Cancel
      </Link>
    </div>

  </form>

</template>
