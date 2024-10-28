<script setup lang="ts">
import {
Combobox,
ComboboxButton,
ComboboxInput,
ComboboxOption,
ComboboxOptions,
TransitionRoot,
} from '@headlessui/vue';
import {
IconCheck as CheckIcon,
IconSelector as ChevronUpDownIcon
} from '@tabler/icons-vue';
import { computed, reactive, ref, watch } from 'vue';

const props = defineProps({
  modelValue: [String, Object],
  loadOptions: Function,
  createOption: Function,
})

const emit = defineEmits(['update:modelValue'])

let options = reactive<any[]>([])
const isLoading = ref(false)
const query = ref('')

const queryOption = computed(() => {
  return query.value === ''
    ? null
    : {
        missing: true,
        label: query.value,
      }
})

watch(
  query,
  (q) => {
    if (props.loadOptions) {

      isLoading.value = true

      props.loadOptions(q, (results: any) => {

        options = results

        if (
          props.modelValue?.value !== ''
          && !options.some((o) => {
            return o.value === props.modelValue?.value
          })
        )
          options.unshift(props.modelValue)

        isLoading.value = false
      })
    }
  },
  { immediate: true },
)

const filteredOptions = computed(() =>
  query.value === ''
    ? options
    : options.filter(option =>
      option.label
        .toLowerCase()
        .replace(/\s+/g, '')
        .includes(query.value.toLowerCase().replace(/\s+/g, '')),
    ),
)

function handleUpdateModelValue(selected) {
  emit('update:modelValue', selected)

  if (props.createOption && selected?.missing) {
    isLoading.value = true

    props.createOption(selected, (option) => {
      emit('update:modelValue', option)
      isLoading.value = false
    })
  }
}
</script>

<template>
  <Combobox
    by="value"
    :model-value="props.modelValue"
    @update:model-value="handleUpdateModelValue"
  >
    <div class="relative mt-1">
      <div
        class="relative block w-full overflow-hidden text-sm text-gray-900 border border-gray-300 rounded-lg cursor-default bg-gray-50 focus:ring-lime-600 focus:border-lime-600 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-lime-500 dark:focus:border-lime-500"
      >
        <ComboboxInput
          class="w-full py-3 placeholder-gray-600 border-gray-300 rounded-md shadow-sm dark:placeholder-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-lime-500 dark:focus:border-lime-600 focus:ring-lime-500 dark:focus:ring-lime-600"
          :display-value="option => option.label"
          placeholder="Pick contacts to assign to the group"
          @change="query = $event.target.value"
        />
        <ComboboxButton
          class="absolute inset-y-0 right-0 flex items-center pr-2"
        >
          <ChevronUpDownIcon
            class="w-5 h-5 text-gray-400"
            aria-hidden="true"
          />
        </ComboboxButton>
      </div>

      <TransitionRoot
        leave="transition ease-in duration-100"
        leave-from="opacity-100"
        leave-to="opacity-0"
        @after-leave="query = ''"
      >
        <ComboboxOptions
          class="absolute z-50 w-full py-1 mt-1 overflow-auto text-base bg-white rounded-md shadow-lg max-h-60 ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
        >
          <div
            v-if="
              filteredOptions.length === 0
                && !isLoading
                && !queryOption
                && !props.createOption
            "
            class="relative px-4 py-2 text-gray-700 cursor-default select-none"
          >
            Nothing found.
          </div>

          <div
            v-if="isLoading"
            class="relative px-4 py-2 text-gray-700 cursor-default select-none"
          >
            Loading...
          </div>

          <template v-if="!isLoading">

            <ComboboxOption
              v-for="option in filteredOptions"
              v-slot="{ selected, active }"
              :key="option.value"
              :value="option"
              as="ul"
            >
              <li
                class="relative py-2 pl-10 pr-4 cursor-default select-none"
                v-if="option.length !== 0"
                :class="{
                  'bg-gray-500 text-white': active,
                  'text-gray-900': !active,
                }"
              >
                <span
                  class="block truncate"
                  :class="{ 'font-medium': selected, 'font-normal': !selected }"
                >
                  {{ option.label }}
                </span>

                <span
                  v-if="selected"
                  class="absolute inset-y-0 left-0 flex items-center pl-3"
                  :class="{ 'text-white': active, 'text-gray-500': !active }"
                >
                  <CheckIcon
                    class="w-5 h-5"
                    aria-hidden="true"
                  />
                </span>
              </li>
            </ComboboxOption>

          </template>
        </ComboboxOptions>
      </TransitionRoot>
    </div>
  </Combobox>
</template>
