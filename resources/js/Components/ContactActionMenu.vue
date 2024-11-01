<script setup lang="ts">
import IconContactAdd from '@/Components/Icon/IconContactAdd.vue';
import IconContactRemove from '@/Components/Icon/IconContactRemove.vue';
import {useContactStore} from '@/Stores/contactStore';
import {Link, useForm, usePage} from '@inertiajs/vue3';
import {
  IconArrowCapsule,
  IconHeartMinus,
  IconPencil,
  IconTrash
} from '@tabler/icons-vue';
import {storeToRefs} from 'pinia';
import {ref} from 'vue';
import IconContactFavourite from "@/Components/Icon/IconContactFavourite.vue";
import vueFilePond from "vue-filepond";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import type { FilePond } from "filepond";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";

defineProps<{
  contactBase: object;
}>()

const FilePondInput = vueFilePond(
  FilePondPluginFileValidateType,
  FilePondPluginFileValidateSize,
  FilePondPluginImagePreview
);

const csvPond = ref<FilePond | null>(null)
const csvUploader = ref()

const url = ref(usePage().url)

const contactStore = useContactStore()

const {expungeSelectedContacts} = contactStore

const {
  selectedContacts
} = storeToRefs(contactStore)

const form = useForm({
  csv: null
})

if (!url.value.startsWith('/m/compose') && selectedContacts.value.length) {
  expungeSelectedContacts()
}

const handleFilePond = (file: FilePond) => {

  form.csv = file as any

};

function onSubmit() {

  form
    .transform((data) => {

      const formData: Partial<any> = {
        ...data,
        csv: csvPond.value?.getFile()?.file
      };

      return formData;

    }).post(route('add-contacts-from-file'), {

    preserveScroll: true,

    onSuccess: () => {
      form.reset()
      csvPond.value?.removeFiles();
      csvUploader.value.close()
    },

  });

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
      <span>New</span> <span class="hidden sm:inline-flex"> contact</span>
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
    class="sticky top-0 z-10 flex items-center w-full h-16 gap-6 p-6 pl-8 dark:bg-neutral-900 border-b bg-neutral-100 dark:text-white dark:border-gray-500"
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
      class="flex items-center gap-2 transition duration-300 hover:opacity-70">
      <IconContactFavourite class="size-5 stroke-current"/>
      <span class="hidden sm:inline-flex">Add to </span>
      <span class="capitalize inline-flex sm:lowercase">favourite</span>
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
      class="flex items-center gap-2 transition duration-300 hover:opacity-70"
      preserve-scroll>

      <IconArrowCapsule class="w-5 h-5 stroke-current"/>
      <span class="hidden md:inline-flex">
        Restore
      </span>

    </Link>

    <Link
      :href="route('mail.compose')"
      class="flex items-center gap-2 px-1.5 rounded-md"
      v-if="!$page.url.startsWith('/contacts/deleted')"
      preserve-scroll
      as="button">

      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" class="size-5" color="currentColor" fill="none">
        <path d="M2 5L8.91302 8.92462C11.4387 10.3585 12.5613 10.3585 15.087 8.92462L22 5" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
        <path d="M10.5 19.5C10.0337 19.4939 9.56682 19.485 9.09883 19.4732C5.95033 19.3941 4.37608 19.3545 3.24496 18.2184C2.11383 17.0823 2.08114 15.5487 2.01577 12.4814C1.99475 11.4951 1.99474 10.5147 2.01576 9.52843C2.08114 6.46113 2.11382 4.92748 3.24495 3.79139C4.37608 2.6553 5.95033 2.61573 9.09882 2.53658C11.0393 2.4878 12.9607 2.48781 14.9012 2.53659C18.0497 2.61574 19.6239 2.65532 20.755 3.79141C21.8862 4.92749 21.9189 6.46114 21.9842 9.52844C21.9939 9.98251 21.9991 10.1965 21.9999 10.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        <path d="M19 17C19 17.8284 18.3284 18.5 17.5 18.5C16.6716 18.5 16 17.8284 16 17C16 16.1716 16.6716 15.5 17.5 15.5C18.3284 15.5 19 16.1716 19 17ZM19 17V17.5C19 18.3284 19.6716 19 20.5 19C21.3284 19 22 18.3284 22 17.5V17C22 14.5147 19.9853 12.5 17.5 12.5C15.0147 12.5 13 14.5147 13 17C13 19.4853 15.0147 21.5 17.5 21.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
      </svg>

      <span class="hidden sm:inline-flex">Send </span>
      <span class="capitalize sm:lowercase">Mail</span>

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
    :close-button="false"
    ref="csvUploader">

    <h2 class="text-2xl font-semibold mb-6">Import contacts</h2>

    <article class="grid md:grid-cols-2 grid-cols-1 gap-6 md:gap-16">

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

        <form class="space-y-4" @submit.prevent="onSubmit">
          <div class="mb-4">
            <InputLabel
              class="mb-2">
              Upload your CSV file
            </InputLabel>

            <FilePondInput
              name="Client logo"
              ref="logoFile"
              max-file-size="2MB"
              credits="false"
              accepted-file-types="image/*"
              label-idle="Drop your logo image here..."
              :allow-multiple="false"
              :allow-mage-preview="true"
              :image-preview-max-height="150"
              @updatefiles="handleFilePond" />

            <InputError :message="form.errors.csv" />
          </div>

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
