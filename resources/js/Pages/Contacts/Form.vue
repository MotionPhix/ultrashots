<script setup lang="ts">
import AddressRepeater from '@/Components/AddressRepeater.vue'
import EmailRepeater from '@/Components/EmailRepeater.vue'
import InputError from '@/Components/InputError.vue'
import PhoneRepeater from '@/Components/PhoneRepeater.vue'
import AuthenticatedLayout from '@/Layouts/AuthLayout.vue'
import {useFieldStore} from '@/Stores/fieldStore'
import type {Company, Contact, Email, Phone} from '@/types'
import {Menu, MenuButton, MenuItem, MenuItems} from '@headlessui/vue'
import {Head, Link, router, useForm} from '@inertiajs/vue3'
import {IconBriefcase, IconArrowLeft, IconPlus, IconLink, IconMap2, IconFileDescription} from '@tabler/icons-vue'
import axios from 'axios'
import {debounce} from 'lodash'
import {storeToRefs} from 'pinia'
import {onMounted, ref} from 'vue'
import InputLabel from "@/Components/InputLabel.vue";
import IconContactAdd from "@/Components/Icon/IconContactAdd.vue";
import H3 from "@/Components/Icon/H3.vue";
import AddCompanyForm from "@/Pages/Companies/AddCompanyForm.vue";

interface FormData {
  first_name: string;
  last_name?: string;
  middle_name?: string;
  job_title?: string;
  phones?: Phone[];
  emails?: Email[];
  office?: Company;
}

const props = defineProps<{
  contact: Contact
}>()

const message = ref()

const fieldStore = useFieldStore()

const {
  hasMiddleName,
  hasJobTitle,
  hasAddress,
  hasSlogan,
  hasUrl,
} = storeToRefs(fieldStore)

const {toggleField} = fieldStore

const icons = {
  IconBriefcase,
  IconFileDescription,
  IconLink,
  IconMap2,
}

const form = useForm({
  first_name: props.contact.first_name,
  last_name: props.contact.last_name,
  middle_name: props.contact.middle_name,
  job_title: props.contact.job_title,
  emails: props.contact.emails,
  phones: props.contact.phones,
  office_id: props.contact.office?.id,
  office_address: props.contact.office?.address,
  office_name: props.contact.office?.name,
  office_slogan: props.contact.office?.slogan,
  office_url: props.contact.office?.url,
})

const companyOptions = ref()

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

  if (form.office_id) {

    formData.office = {
      id: form.office_id,
    }

    if (hasSlogan.value || !!form.office_slogan)
      formData.office.slogan = form.office_slogan

    if (hasUrl.value || !!form.office_url)
      formData.office.url = form.office_url

    if (hasAddress.value || !!form.office_address)
      formData.office.address = form.office_address

  }

  if (props.contact.cid) {

    if (props.contact.office?.address?.id)
      formData.office.address[0].id = props.contact.office?.address?.id

    return router.patch(route('contacts.update', props.contact.cid), formData as any, {preserveScroll: true})

  } else {

    router.post(route('contacts.store'), formData as any, {preserveScroll: true})

  }

}

const fetchCompanies = debounce((q?: string) => {

  axios.get(q ? `/companies/${q}` : '/companies')
    .then((resp) => {

      companyOptions.value = resp.data.map((company: Company) => company)

    })

}, 500)

function handleCompany(id: number) {

  console.log('New company ID received:', id);

  fetchCompanies()

  setTimeout(() => {

    form.office_id = id

  }, 100)

}

onMounted(() => {

  fetchCompanies()

})

defineOptions({
  layout: AuthenticatedLayout,
})
</script>

<template>
  <Head
    :title="contact.cid ? `Edit ${contact.first_name} ${contact.last_name}` : 'New contact'"/>

  <Link
    as="button"
    class="fixed top-[1.6rem] left-2 z-40"
    :href="contact.cid ? route('contacts.show', contact.cid) : route('contacts.index')"
    preserve-scroll>

    <IconArrowLeft class="size-5"/>

  </Link>

  <form
    class="flex flex-col max-w-2xl gap-6 px-4 pb-16 my-16 sm:px-8 md:mx-auto"
    @submit.prevent="onSubmit">

    <section class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">

      <div class="flex-1">
        <InputLabel
          for="name"
          class="mb-2">
          First name
        </InputLabel>

        <UltraInput
          id="name"
          v-model="form.first_name" type="text"
          placeholder="Enter first name"
          rounded-size="md"
          size="md"
          block
        />

        <InputError :message="$page.props.errors.first_name"/>
      </div>

      <div v-if="hasMiddleName || !!form.middle_name">
        <InputLabel
          for="middle_name"
          class="mb-2">
          Middle name
        </InputLabel>

        <UltraInput
          id="middle_name" v-model="form.middle_name" type="text"
          placeholder="Enter middle name"
          rounded-size="md"
          block
        />

        <InputError :message="$page.props.errors.middle_name"/>
      </div>

      <div>
        <InputLabel
          for="last_name"
          class="mb-2">
          Surname
        </InputLabel>

        <UltraInput
          id="last_name" v-model="form.last_name" type="text"
          placeholder="Type surname"
          rounded-size="md"
          block
        />

        <InputError :message="$page.props.errors.last_name"/>
      </div>

    </section>

    <div>
      <Menu as="div" class="relative z-10 inline-flex">
        <MenuButton
          class="flex items-center gap-2 font-bold text-blue-300 transition duration-300 dark:text-lime-300 hover:text-blue-500">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" stroke-width="2"
               stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M12 5l0 14"/>
            <path d="M5 12l14 0"/>
          </svg>
          <span>Add field</span>
        </MenuButton>

        <transition
          enter-active-class="transition duration-100 ease-out transform" enter-from-class="scale-90 opacity-0"
          enter-to-class="scale-100 opacity-100" leave-active-class="transition duration-100 ease-in transform"
          leave-from-class="scale-100 opacity-100" leave-to-class="scale-90 opacity-0">
          <MenuItems
            class="absolute left-0 w-48 mt-2 overflow-hidden origin-top-left bg-white border rounded-md shadow-lg focus:outline-none">

            <MenuItem v-slot="{ active }" @click="toggleField('hasMiddleName')">
              <span :class="{ 'bg-gray-100': active }" class="block px-4 py-2 text-sm text-gray-700">Middle name</span>
            </MenuItem>

          </MenuItems>
        </transition>
      </Menu>
    </div>

    <div>

      <InputLabel
        class="mb-2">
        Email address<span v-if="form.emails?.length > 1">es</span>
      </InputLabel>

      <EmailRepeater v-model="form.emails"/>

    </div>

    <div>

      <InputLabel
        class="mb-2">
        Phone number<span v-if="form.phones?.length > 1">s</span>
      </InputLabel>

      <PhoneRepeater v-model="form.phones"/>
    </div>

    <section class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">

      <div>
        <InputLabel
          class="mb-2">
          Company name
        </InputLabel>

        <UltraSelect
          search-placeholder="Search companies"
          placeholder="Pick a company"
          v-model="form.office_id"
          :options="companyOptions"
          rounded-size="md"
          minListWidth="100%"
          autocomplete
          no-chevron
          search
          block>
          <template #default="{ option }">
            <div class="flex items-center" style="width: 100%; gap: 1rem">
              <strong>
                {{ option.label }}
              </strong>
            </div>
          </template>

          <template #no-results>
            <div class="p-4 space-y-4">
              <h3 class="font-serif text-xl">
                Company not found.
              </h3>

              <AddCompanyForm @companyCreated="handleCompany"/>
            </div>
          </template>

        </UltraSelect>

        <InputError :message="$page.props.errors['company.id']"/>
      </div>

      <div v-if="hasUrl || !!form.office_url">
        <InputLabel
          for="company_website"
          class="mb-2">
          Website
        </InputLabel>

        <UltraInput
          id="company_website"
          v-model="form.office_url" type="text"
          placeholder="E.g. https://www.example.com"
          rounded-size="md"
          block
        />

        <InputError :message="$page.props.errors['company.url']"/>
      </div>

      <div v-if="hasSlogan || !!form.office_slogan">
        <InputLabel
          for="company_slogan"
          class="mb-2">
          Motto/Slogan
        </InputLabel>

        <UltraInput
          id="company_slogan"
          v-model="form.office_slogan" type="text"
          placeholder="Enter slogan"
          rounded-size="md"
          block
        />

        <InputError :message="$page.props.errors['company.slogan']"/>
      </div>

      <div v-if="hasJobTitle || !!form.job_title">
        <InputLabel
          for="job_title" class="mb-2">
          Job title
        </InputLabel>

        <UltraInput
          id="job_title" v-model="form.job_title" type="text"
          placeholder="Enter job title"
          rounded-size="md"
          block
        />

        <InputError :message="$page.props.errors['job_title']"/>
      </div>

    </section>

    <div v-if="hasAddress || !!form.office_address">

      <AddressRepeater
        :add-more="false"
        v-model="form.office_address"/>

    </div>

    <div class="col-span-2">
      <UltraDropdown
        :items="[
          {
            label: 'Office address',
            action: () => hasAddress = !hasAddress,
            icon: 'IconMap2'
          },
          {
            label: 'Job title',
            action: () => hasJobTitle = !hasJobTitle,
            icon: 'IconBriefcase'
           },
          {
            label: 'Website',
            action: () => hasUrl = !hasUrl,
            icon: 'IconLink'
          },
          {
            label: 'Slogan',
            action: () => hasSlogan = !hasSlogan,
            icon: 'IconFileDescription'
          },
        ]"
        no-chevron
        trigger="click"
        no-padding>
        <template #default>
          <span
            class="flex items-center gap-2 font-bold text-blue-300 transition duration-300 dark:text-lime-300 hover:text-blue-500">

            <IconPlus/> <span>Add company field</span>

          </span>
        </template>

        <template #menuitem-label="{ item }">
          <div class="maz-flex maz-items-center maz-gap-2">

            <component :is="icons[item.icon]" class="size-5"/>

            <span>
              {{ item.label }}
            </span>
          </div>
        </template>
      </UltraDropdown>
    </div>

    <div class="flex items-center justify-end col-span-4 gap-4 pt-4">
      <UltraBtn
        type="submit"
        :disabled="form.processing"
        rounded-size="md"
        color="success">
        <template #left-icon>

          <IconContactAdd
            class="w-6 h-6 mr-1 -ml-1"/>

        </template>

        {{ contact.id ? 'Update ' : 'Save ' }}
      </UltraBtn>

      <UltraBtn
        type="button"
        @click="router.visit(contact.cid ? route('contacts.show', contact.cid) : route('contacts.index'))"
        rounded-size="md"
        color="theme"
      >
        Cancel
      </UltraBtn>
    </div>
  </form>
</template>
