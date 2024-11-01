<script lang="ts" setup>
import InputError from '@/Components/InputError.vue';
import AuthenticatedLayout from '@/Layouts/AuthLayout.vue';
import { useContactStore } from '@/Stores/contactStore';
import { Link, router, useForm, usePage } from '@inertiajs/vue3';
import { IconMailFast } from '@tabler/icons-vue';
import { storeToRefs } from 'pinia';
import TurndownService from 'turndown';
import { onMounted } from 'vue';
import InputLabel from "@/Components/InputLabel.vue";
import EmailBuilder from "@/Components/EmailBuilderAdvanced.vue";

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
      <InputLabel
        for="subject"
        class="mb-2">
        Email subject
      </InputLabel>

      <UltraInput
        id="subject"
        v-model="form.subject"
        placeholder="Enter email subject"
        rounded-size="md"
        type="text"
        block />

      <InputError :message="form.errors.subject" />
    </div>

    <div class="mt-4">
      <label
        for="message"
        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
        Email content
      </label>

      <section>
        <!-- Email content here -->

        <EmailBuilder v-model="form.body" />

      </section>

      <InputError :message="form.errors.body" />
    </div>

    <div
      class="flex items-center justify-end col-span-4 gap-4 pt-4">

      <Link
        as="button"
        :href="route('contacts.index')"
        class="py-2.5 text-gray-800 dark:text-white hover:text-opacity-40 transition duration-300">
        Cancel
      </Link>

      <UltraBtn
        type="submit"
        :disabled="form.processing"
        rounded-size="md"
        color="success"
        size="sm">

        <template #left-icon>

          <IconMailFast class="size-6" />

        </template>

        <span>Send</span>

      </UltraBtn>

    </div>

  </form>

</template>
