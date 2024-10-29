<script setup lang="ts">
import type {Phone} from '@/types'
import {Menu, MenuButton, MenuItem, MenuItems} from '@headlessui/vue'
import {usePage} from '@inertiajs/vue3'
import {IconPhoneCheck, IconTrash} from '@tabler/icons-vue'
import MazPhoneNumberInput from 'maz-ui/components/MazPhoneNumberInput'
import {onMounted} from 'vue'
import InputError from './InputError.vue'
import InputLabel from "@/Components/InputLabel.vue";

interface InputProps {
  modelValue: Phone[]
}

const props = withDefaults(defineProps<InputProps>(), {
  modelValue: () => [],
})

const emit = defineEmits(['update:modelValue'])

const page = usePage()

function onPhoneAdd(phone: string) {
  emit('update:modelValue', [...props.modelValue, {
    number: '',
    type: phone,
    country_code: 'MW',
    is_primary_phone: false,
  }])
}

function onPhoneRemove(index: Number) {
  const updatedEmails = props.modelValue.filter((_, i) => i !== index)
  emit('update:modelValue', updatedEmails)
}

function togglePrimaryPhone(index: number) {
  for (let i = 0; i < props.modelValue.length; i++) {
    if (i === index) {
      // Set the current phone as the primary phone
      props.modelValue[i].is_primary_phone = true;
    } else {
      // Set all other phones as non-primary
      props.modelValue[i].is_primary_phone = false;
    }
  }
}

onMounted(() => {
  if (props.modelValue.length <= 0) {
    emit('update:modelValue', [...props.modelValue, {
      number: '', type: 'mobile', country_code: 'MW', is_primary_phone: true,
    }])
  }
})
</script>

<template>
  <section class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
    <div v-for="(phone, idx) in modelValue" :key="idx" class="relative space-y-2 group first-letter:uppercase">
      <MazPhoneNumberInput
        v-model:country-code="phone.country_code"
        v-model="phone.number"
        no-example
        :only-countries="['MW', 'ZA', 'ZM', 'ZW']"
        rounded-size="md"
        show-code-on-list
        no-country-selector
        no-search
        fetch-country
        placeholder="Enter a phone number"
        :class="{
          'border-r-4 rounded-xl border-r-indigo-600 dark:border-r-yellow-500': phone.is_primary_phone
        }"
        color="success"
        no-flags
        block
      />

      <InputError :message="page.props.errors[`phones.${idx}.type`]"/>
      <InputError :message="page.props.errors[`phones.${idx}.number`]"/>
      <InputError :message="page.props.errors[`phones.${idx}.country_code`]"/>

      <section
        class="absolute z-30 items-center hidden h-8 gap-2 py-1 rounded-lg top-0 group-hover:inline-flex bottom-10 right-4">
        <button
          type="button"
          @click="togglePrimaryPhone(idx)"
          class="text-gray-500 dark:text-gray-300 hover:text-gray-900 hover:bg-opacity-10">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" class="size-5 stroke-current stroke-2 hover:text-lime-500" fill="none">
            <path d="M5.5 9C5.5 5.70017 5.5 4.05025 6.4519 3.02513C7.40381 2 8.93587 2 12 2C15.0641 2 16.5962 2 17.5481 3.02513C18.5 4.05025 18.5 5.70017 18.5 9V15C18.5 18.2998 18.5 19.9497 17.5481 20.9749C16.5962 22 15.0641 22 12 22C8.93587 22 7.40381 22 6.4519 20.9749C5.5 19.9497 5.5 18.2998 5.5 15V9Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
            <path d="M12 19H12.009" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M11 5H13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M22 8.5C22 8.5 21 8.846 21 9.8125C21 10.779 22 11.0335 22 12C22 12.9665 21 13.221 21 14.1875C21 15.154 22 15.5 22 15.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M2 8.5C2 8.5 3 8.846 3 9.8125C3 10.779 2 11.0335 2 12C2 12.9665 3 13.221 3 14.1875C3 15.154 2 15.5 2 15.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </button>

        <button
          v-if="props.modelValue.length > 1" type="button"
          class="text-gray-500 dark:text-gray-300 group-hover:inline-flex"
          @click="onPhoneRemove(idx)">

          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
               class="stroke-current size-5 stroke-2 hover:text-rose-500" fill="none">
            <path
              d="M19.5 5.5L18.8803 15.5251C18.7219 18.0864 18.6428 19.3671 18.0008 20.2879C17.6833 20.7431 17.2747 21.1273 16.8007 21.416C15.8421 22 14.559 22 11.9927 22C9.42312 22 8.1383 22 7.17905 21.4149C6.7048 21.1257 6.296 20.7408 5.97868 20.2848C5.33688 19.3626 5.25945 18.0801 5.10461 15.5152L4.5 5.5"
              stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            <path
              d="M3 5.5H21M16.0557 5.5L15.3731 4.09173C14.9196 3.15626 14.6928 2.68852 14.3017 2.39681C14.215 2.3321 14.1231 2.27454 14.027 2.2247C13.5939 2 13.0741 2 12.0345 2C10.9688 2 10.436 2 9.99568 2.23412C9.8981 2.28601 9.80498 2.3459 9.71729 2.41317C9.32164 2.7167 9.10063 3.20155 8.65861 4.17126L8.05292 5.5"
              stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            <path d="M9.5 16.5L9.5 10.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            <path d="M14.5 16.5L14.5 10.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
          </svg>

        </button>
      </section>

    </div>
  </section>

  <div class="mt-4">
    <Menu as="div" class="relative inline-flex">
      <MenuButton
        class="flex items-center gap-2 font-bold text-blue-300 transition duration-300 dark:text-lime-300 hover:text-blue-500"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
          fill="none" stroke-linecap="round" stroke-linejoin="round"
        >
          <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
          <path d="M12 5l0 14"/>
          <path d="M5 12l14 0"/>
        </svg>
        <span>Add phone</span>
      </MenuButton>

      <transition
        enter-active-class="transition duration-100 ease-out transform" enter-from-class="scale-90 opacity-0"
        enter-to-class="scale-100 opacity-100" leave-active-class="transition duration-100 ease-in transform"
        leave-from-class="scale-100 opacity-100" leave-to-class="scale-90 opacity-0"
      >
        <MenuItems
          class="absolute left-0 z-20 w-48 mt-2 overflow-hidden origin-top-left bg-white border rounded-md shadow-lg focus:outline-none"
        >
          <MenuItem v-slot="{ active }" @click="onPhoneAdd('home')">
            <span :class="{ 'bg-gray-100': active }" class="block px-4 py-2 text-sm text-gray-700">Home</span>
          </MenuItem>

          <MenuItem v-slot="{ active }" @click="onPhoneAdd('work')">
            <span :class="{ 'bg-gray-100': active }" class="block px-4 py-2 text-sm text-gray-700">Work</span>
          </MenuItem>

          <MenuItem v-slot="{ active }" @click="onPhoneAdd('mobile')">
            <span :class="{ 'bg-gray-100': active }" class="block px-4 py-2 text-sm text-gray-700">Mobile</span>
          </MenuItem>

          <MenuItem v-slot="{ active }" @click="onPhoneAdd('fax')">
            <span :class="{ 'bg-gray-100': active }" class="block px-4 py-2 text-sm text-gray-700">Fax</span>
          </MenuItem>
        </MenuItems>
      </transition>
    </Menu>
  </div>
</template>
