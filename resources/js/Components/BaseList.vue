<script setup>
import {
Listbox,
ListboxButton,
ListboxOption,
ListboxOptions,
} from '@headlessui/vue';
import { IconCheck as CheckIcon, IconSelector as ChevronUpDownIcon } from '@tabler/icons-vue';
import { computed } from 'vue';

const props = defineProps({
  options: Array,

  modelValue: [String, Number, Array],

  multiple: Boolean,

  error: String,

  placeholder: {
    type: String,
    default: 'Select option',
  },
})

defineEmits(['update:modelValue'])

// const label = computed(() => props.options.find(option => option.value === props.modelValue)?.label)
const label = computed(() => props.options.filter((option) => {
  if (Array.isArray(props.modelValue))
    return props.modelValue.includes(option.value)

  return option.value === props.modelValue
}).map(option => option.label).join(', '),
)
</script>

<template>
  <Listbox
    :model-value="modelValue"
    :multiple="props.multiple"
    @update:model-value="value => $emit('update:modelValue', value)"
  >
    <div class="relative mt-1">
      <ListboxButton
        class="relative w-full py-3 pl-3 pr-10 text-left bg-white rounded-lg shadow-md cursor-default dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus-visible:border-indigo-500 focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75 focus-visible:ring-offset-2 focus-visible:ring-offset-orange-300 sm:text-sm"
      >
        <span v-if="label" class="block truncate">{{ label }}</span>
        <span v-else class="block text-gray-600 truncate dark:text-gray-400">
          {{ props.placeholder }}
        </span>
        <span
          class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none"
        >
          <ChevronUpDownIcon
            class="w-5 h-5 text-gray-400"
            aria-hidden="true"
          />
        </span>
      </ListboxButton>

      <transition
        leave-active-class="transition duration-100 ease-in"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
      >
        <ListboxOptions
          class="absolute z-10 w-full py-1 mt-1 overflow-auto text-base bg-white divide-y rounded-md shadow-lg max-h-40 dark:divide-gray-800 dark:bg-gray-700 ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
        >
          <ListboxOption
            v-for="option in options"
            v-slot="{ active, selected }"
            :key="option.label"
            :value="option.value"
            as="template"
          >
            <li
              class="relative py-2 pl-10 pr-4 cursor-default select-none" :class="[
                active ? 'bg-amber-100 text-amber-900' : 'text-gray-900 dark:text-gray-300',
              ]"
            >
              <span
                class="block truncate" :class="[
                  selected ? 'font-semibold' : 'font-normal',
                ]"
              >{{ option.label }}</span>
              <span
                v-if="selected"
                class="absolute inset-y-0 left-0 flex items-center pl-3 text-amber-600"
              >
                <CheckIcon class="w-5 h-5" aria-hidden="true" />
              </span>
            </li>
          </ListboxOption>
        </ListboxOptions>
      </transition>

      <div v-if="error" class="mt-1 text-sm text-red-500">
        {{ error }}
      </div>
    </div>
  </Listbox>
</template>
