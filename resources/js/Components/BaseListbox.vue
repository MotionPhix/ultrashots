<script setup>
import {
  Listbox,
  ListboxButton,
  ListboxOption,
  ListboxOptions,
} from '@headlessui/vue';
import { computed } from 'vue';

const props = defineProps({
  options: Array,
  modelValue: [String, Number, Array],
  placeholder: {
    type: String,
    default: 'Select option',
  },
  multiple: Boolean,
  error: String,
})

const emit = defineEmits(['update:modelValue'])

const label = computed(() => {
  return props.options
    .filter((option) => {
      if (Array.isArray(props.modelValue))
        return props.modelValue.includes(option.value)

      return props.modelValue === option.value
    })
    .map(option => option.label)
    .join(', ')
})
</script>

<template>
  <Listbox :model-value="props.modelValue" :multiple="props.multiple"
    @update:model-value="value => emit('update:modelValue', value)">
    <div class="relative mt-1">
      <ListboxButton
        class="relative w-full py-2.5 pl-3 pr-10 text-left bg-white dark:bg-gray-700 rounded-lg shadow-md cursor-default focus:outline-none focus-visible:border-indigo-500 focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75 focus-visible:ring-offset-2 focus-visible:ring-offset-orange-300 sm:text-sm">
        <span v-if="label" class="block truncate dark:text-white">{{ label }}</span>
        <span v-else class="text-gray-500 dark:text-gray-400">{{ props.placeholder }}</span>
        <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 icon icon-tabler icon-tabler-selector" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 9l4 -4l4 4" /><path d="M16 15l-4 4l-4 -4" /></svg>
        </span>
      </ListboxButton>

      <transition leave-active-class="transition duration-100 ease-in" leave-from-class="opacity-100"
        leave-to-class="opacity-0">
        <ListboxOptions
          class="absolute z-10 w-full py-1 mt-1 overflow-auto text-base bg-white rounded-md shadow-lg dark:bg-gray-700 max-h-60 ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
          <ListboxOption v-for="option in props.options" :key="option.label" v-slot="{ active, selected }"
            :value="option.value" as="template">
            <li class="relative py-2 pl-10 pr-4 cursor-default select-none" :class="[
              active ? 'bg-amber-100 text-amber-900' : 'text-gray-900 dark:text-gray-200',
            ]">
              <span class="block truncate" :class="[
                selected ? 'font-medium' : 'font-normal',
              ]">{{ option.label }}</span>
              <span v-if="selected" class="absolute inset-y-0 left-0 flex items-center pl-3 text-amber-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
              </span>
            </li>
          </ListboxOption>
        </ListboxOptions>
      </transition>
      <div v-if="props.error" class="mt-1 text-xs text-red-400">
        {{ props.error }}
      </div>
    </div>
  </Listbox>
</template>
