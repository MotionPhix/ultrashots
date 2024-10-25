<script setup lang="ts">
import AddressRepeater from '@/Components/AddressRepeater.vue'
import Combobox from '@/Components/Combobox.vue'
import EmailRepeater from '@/Components/EmailRepeater.vue'
import InputError from '@/Components/InputError.vue'
import PhoneRepeater from '@/Components/PhoneRepeater.vue'
import TipTap from '@/Components/TipTap.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { useFieldStore } from '@/Stores/fieldStore'
import type { Address, Company, Contact, Email, Phone } from '@/types'
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { Head, Link, router, useForm } from '@inertiajs/vue3'
import MazInput from "maz-ui/components/MazInput"
import { IconPlus } from '@tabler/icons-vue'
import axios from 'axios'
import { debounce } from 'lodash'
import { storeToRefs } from 'pinia'
import { ref } from 'vue'

interface FormData {
  first_name: string;
  last_name?: string;
  middle_name?: string;
  bio?: string;
  job_title?: string;
  phones?: Phone[];
  emails?: Email[];
  company?: Company;
}

const props = defineProps<{
  contact: Contact
}>()

defineOptions({
  layout: AuthenticatedLayout,
})

const message = ref()

const fieldStore = useFieldStore()

const {
  hasMiddleName,
  hasJobTitle,
  hasAddress,
  hasSlogan,
  hasUrl,
} = storeToRefs(fieldStore)

const { toggleField } = fieldStore

const form = useForm({
  first_name: props.contact.first_name,
  last_name: props.contact.last_name,
  bio: props.contact.bio ?? '',
  middle_name: props.contact.middle_name,
  job_title: props.contact.job_title,
  emails: props.contact.emails,
  phones: props.contact.phones,
  company_id: props.contact.company?.id,
  company_address: props.contact.company?.address,
  company_name: props.contact.company?.name,
  company_slogan: props.contact.company?.slogan,
  company_url: props.contact.company?.url,
})

const loadCompanies = debounce((query: string, setOptions: any) => {
  axios.get(query ? `/companies/${query}` : '/companies')
    .then((resp) => {
      setOptions(
        resp.data.map((company: Company) => company),
      )
    })
}, 500)

function createCompany(option: Partial<{ label?: string }>, setSelected: Function) {
  axios.post('/companies', {
    name: option.label,
  }, {
    headers: {
      'Content-Type': 'application/json',
    },
  })
    .then((resp) => {
      setSelected({
        value: resp.data.id,
        label: resp.data.name,
      })
    })
    .catch((err) => {
      message.value = err.response.data.message
    }).finally(() => message.value = null)
}

function onSubmit() {

  const formData: FormData = {
    first_name: form.first_name,
    last_name: form.last_name,
    phones: form.phones,
    emails: form.emails
  }

  // Include optional fields only if they are filled
  if (hasJobTitle.value || !!form.job_title)
    formData.job_title = form.job_title

  if (hasMiddleName.value || !!form.middle_name)
    formData.middle_name = form.middle_name

  if (form.bio?.length || !!form.bio?.charAt(5))
    formData.bio = form.bio

  if (form.company_id?.value) {
    formData.company = {
      id: form.company_id.value,
    }

    if (hasSlogan.value || !!form.company_slogan)
      formData.company.slogan = form.company_slogan

    if (hasUrl.value || !!form.company_url)
      formData.company.url = form.company_url

    if (hasAddress.value || !!form.company_address)
      formData.company.address = form.company_address
  }

  if (props.contact.cid) {
    router.patch(route('contacts.update', props.contact.cid), formData as any, { preserveScroll: true })
    return
  }

  router.post(route('contacts.store'), formData as any, { preserveScroll: true })
}
</script>

<template>
  <Head :title="contact.cid ? `Edit ${contact.first_name} ${contact.last_name}` : 'Create new contact'" />

  <form
    class="flex flex-col max-w-2xl gap-6 px-4 pb-16 my-16 mb-4 sm:pb-0 sm:px-8 md:mx-auto"
    @submit.prevent="onSubmit"
  >
    <section class="flex gap-6">

      <div class="flex-1">
        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
          First name
        </label>

        <MazInput
          id="name"
          v-model="form.first_name" type="text"
          placeholder="Enter first name"
          rounded-size="md"
          size="lg"
          block
        />

        <InputError :message="$page.props.errors.first_name" />
      </div>

    </section>

    <div v-if="hasMiddleName || !!form.middle_name">
      <label for="middle_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
        Middle name
      </label>

      <MazInput
        id="middle_name" v-model="form.middle_name" type="text"
        placeholder="Enter middle name"
        rounded-size="md"
        size="lg"
        block
      />

      <InputError :message="$page.props.errors.middle_name" />
    </div>

    <div>
      <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
        Surname
      </label>

      <MazInput
        id="last_name" v-model="form.last_name" type="text"
        placeholder="Type surname"
        rounded-size="md"
        size="lg"
        block
      />

      <InputError :message="$page.props.errors.last_name" />
    </div>

    <div v-if="hasJobTitle || !!form.job_title">
      <label for="job_title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
        Job title
      </label>

      <MazInput
        id="job_title" v-model="form.job_title" type="text"
        placeholder="Enter job title"
        rounded-size="md"
        size="lg"
        block
      />

      <InputError :message="$page.props.errors['job_title']" />
    </div>

    <div>
      <EmailRepeater v-model="form.emails" />
    </div>

    <div>
      <PhoneRepeater v-model="form.phones" />
    </div>

    <div>
      <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
        Company
      </label>

      <Combobox v-model="form.company_id" :create-option="createCompany" :load-options="loadCompanies" />

      <InputError :message="message" />

      <InputError :message="$page.props.errors['company.id']" />
    </div>

    <div v-if="hasAddress || !!form.company_address">

      <label for="company_address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
        Address
      </label>

      <AddressRepeater v-model="form.company_address" />

      <InputError :message="$page.props.errors['company.address']" />
    </div>

    <div v-if="hasUrl || !!form.company_url">
      <label for="company_website" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
        Website
      </label>

      <input
        id="company_website"
        v-model="form.company_url" type="text"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-600 focus:border-lime-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-lime-500 dark:focus:border-lime-500"
        placeholder="Enter office website e.g. https://www.example.com"
      >

      <InputError :message="$page.props.errors['company.url']" />
    </div>

    <div v-if="hasSlogan || !!form.company_slogan">
      <label for="company_slogan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
        Motto/Slogan
      </label>

      <input
        id="company_slogan" v-model="form.company_slogan" type="text"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-600 focus:border-lime-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-lime-500 dark:focus:border-lime-500"
        placeholder="Enter slogan"
      >

      <InputError :message="$page.props.errors['company.slogan']" />
    </div>

    <div class="col-span-2">
      <Menu as="div" class="relative">
        <MenuButton
          class="flex items-center gap-2 font-bold text-blue-300 transition duration-300 dark:text-lime-300 hover:text-blue-500"
        >
          <IconPlus /> <span>Add work field</span>
        </MenuButton>

        <transition
          enter-active-class="transition duration-100 ease-out transform" enter-from-class="scale-90 opacity-0"
          enter-to-class="scale-100 opacity-100" leave-active-class="transition duration-100 ease-in transform"
          leave-from-class="scale-100 opacity-100" leave-to-class="scale-90 opacity-0"
        >
          <MenuItems
            class="absolute left-0 z-10 w-48 mt-2 overflow-hidden origin-top-left bg-white border rounded-md shadow-lg -top-44 focus:outline-none"
          >
            <MenuItem v-slot="{ active }" @click="hasJobTitle = !hasJobTitle">
              <span :class="{ 'bg-gray-100': active }" class="block px-4 py-2 text-sm text-gray-700">Job title</span>
            </MenuItem>

            <MenuItem v-slot="{ active }" @click="hasAddress = !hasAddress">
              <span :class="{ 'bg-gray-100': active }" class="block px-4 py-2 text-sm text-gray-700">Office location</span>
            </MenuItem>

            <MenuItem v-slot="{ active }" @click="hasUrl = !hasUrl">
              <span :class="{ 'bg-gray-100': active }" class="block px-4 py-2 text-sm text-gray-700">Office website</span>
            </MenuItem>

            <MenuItem v-slot="{ active }" @click="hasSlogan = !hasSlogan">
              <span :class="{ 'bg-gray-100': active }" class="block px-4 py-2 text-sm text-gray-700">Motto</span>
            </MenuItem>
          </MenuItems>
        </transition>
      </Menu>
    </div>

    <div class="mt-4">
      <label
        for="bio"
        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
      >
        Notes
      </label>

      <section>
        <TipTap v-model="form.bio" placeholder="Write down some notes" />
      </section>

      <InputError :message="$page.props.errors.bio" />
    </div>

    <div class="flex items-center justify-end col-span-4 gap-4 pt-4">
      <button
        type="submit" :disabled="form.processing"
        class="text-white inline-flex transition duration-300 items-center bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-semibold rounded-lg px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800"
      >
        <svg class="w-6 h-6 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
          <path
            fill-rule="evenodd"
            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
            clip-rule="evenodd"
          />
        </svg>

        {{ contact.id ? 'Update ' : 'Save ' }}
      </button>

      <Link
        as="button" :href="route('contacts.index')"
        class="py-2.5 text-gray-800 font-semibold dark:text-white hover:text-opacity-40 transition duration-300 inline-flex items-center border-gray-700 hover:border-opacity-40 focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-lg px-5 text-center border dark:border-gray-600 dark:hover:border-gray-700 dark:focus:ring-gray-800"
      >
        Cancel
      </Link>
    </div>
  </form>
</template>
