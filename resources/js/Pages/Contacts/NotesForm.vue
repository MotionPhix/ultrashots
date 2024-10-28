<script setup lang="ts">
import InputError from '@/Components/InputError.vue'
import TipTap from '@/Components/TipTap.vue'
import type { Contact } from '@/types'
import { useForm} from '@inertiajs/vue3'
import { IconMessageCheck } from "@tabler/icons-vue";
import { ref } from 'vue'

const props = defineProps<{
  contact: Contact
}>()

const bioModal = ref()

const form = useForm({
  first_name: props.contact.first_name,
  last_name: props.contact.last_name,
  bio: props.contact.bio ?? '',
})

function onSubmit() {

  form.patch(route('contacts.update', props.contact.cid), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset()
      bioModal.value.close()
    }
  })

}
</script>

<template>
  <UltraModal
    ref="bioModal">
    <form
      class="flex flex-col gap-6"
      @submit.prevent="onSubmit"
    >
      <div class="mt-4">
        <label
          for="bio"
          class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
        >
          Notes
        </label>

        <section>
          <TipTap v-model="form.bio" placeholder="Write down some notes"/>
        </section>

        <InputError :message="$page.props.errors.bio"/>
      </div>

      <div class="flex items-center justify-end col-span-4 gap-4 pt-4">
        <button
          type="submit" :disabled="form.processing"
          class="text-white inline-flex transition duration-300 items-center bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-semibold rounded-lg px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800"
        >
          <IconMessageCheck class="w-6 h-6 mr-1 -ml-1" />

          Save note
        </button>

        <button
          type="button"
          @click="bioModal.close()"
          class="py-2.5 text-gray-800 font-semibold dark:text-white hover:text-opacity-40 transition duration-300 inline-flex items-center border-gray-700 hover:border-opacity-40 focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-lg px-5 text-center border dark:border-gray-600 dark:hover:border-gray-700 dark:focus:ring-gray-800"
        >
          Cancel
        </button>
      </div>
    </form>
  </UltraModal>
</template>
