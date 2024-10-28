<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useGroupStore } from '@/Stores/groupStore';
import { useNotificationStore } from '@/Stores/notificationStore';
import { Contact, Group } from '@/types';
import {
Combobox,
ComboboxButton,
ComboboxInput,
ComboboxLabel,
ComboboxOption,
ComboboxOptions,
TransitionRoot,
} from '@headlessui/vue';
import { useForm } from '@inertiajs/vue3';
import { IconCheck as CheckIcon, IconSelector as ChevronUpDownIcon } from '@tabler/icons-vue';
import axios from 'axios';
import { storeToRefs } from 'pinia';
import { computed, ref, watch } from 'vue';
import "vue3-colorpicker/style.css";

interface SlickContact {
  label: string
  value: string
}

const props = defineProps({
  close: Function
})

const contacts = ref<SlickContact[]>()

const query = ref('')

const filteredContacts = computed(() =>
  query.value === ''
    ? contacts.value
    : contacts.value.filter((contact) =>
      contact.label
        .toLowerCase()
        .replace(/\s+/g, '')
        .includes(query.value.toLowerCase().replace(/\s+/g, ''))
    )
)

const groupStore = useGroupStore()

const {
  activeGroup,
} = storeToRefs(groupStore)

const {setGroups} = groupStore

const notifications = useNotificationStore()

const { notify } = notifications

const form = useForm({
  contacts: activeGroup.value?.contacts ?? [],
});

const update = () => {
  form.patch(route('groups.update', { group: activeGroup.value.gid }), {
    preserveScroll: true,
    onSuccess: (resp) => {

      setGroups(resp.props.groups as Group[])

      closeModal()

      notify({
        message: 'Contacts were added!',
        title: true,
        type: 'info'
      })

    },

    onError: (error) => {
      console.log(error);
    },

    onFinish: () => form.reset(),
  });
};

const closeModal = () => {
  props.close()
  form.reset()
};

watch(query, () => {
  axios.get(query.value ? `/contacts/${query.value}` : '/contacts')
    .then((resp) => {
      contacts.value = resp.data.filter((contact: SlickContact) => !activeGroup.value.contacts.some((base: Contact) => base.cid === contact.value ))
    })
}, { immediate: true })
</script>

<template>
  <div class="flex items-center justify-between pb-4 mb-4 border-b rounded-t sm:mb-5 dark:border-gray-600">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
      Add contacts to <strong>{{ activeGroup?.name }}</strong>
    </h3>

    <button
      type="button"
      @click="closeModal"
      class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        <span class="sr-only">Close modal</span>
    </button>
  </div>

  <form @submit.prevent="update" class="space-y-5 min-h-56">
    <div>
      <Combobox v-model="form.contacts" multiple>
        <!-- <ul v-if="selected?.length > 0">
          <li v-for="person in selected" :key="person.value">
            {{ person.label }}
          </li>
        </ul> -->

        <div class="relative mt-1">
          <ComboboxLabel class="dark:text-white">
            Assigned contacts
          </ComboboxLabel>

          <div
            class="relative w-full mt-1 overflow-hidden text-left bg-white rounded-lg shadow-md cursor-default focus:outline-none focus-visible:ring-2 focus-visible:ring-white/75 focus-visible:ring-offset-2 focus-visible:ring-offset-blue-300 sm:text-sm">

            <ComboboxInput
              class="w-full py-3 pl-3 pr-10 text-sm leading-5 border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-lime-500 dark:focus:border-lime-600 focus:ring-lime-500 dark:focus:ring-lime-600"
              :displayValue="(contacts: (SlickContact|Contact)[]) => contacts.map((contact: SlickContact|Contact) => contact?.label ?? `${contact?.first_name} ${contact?.last_name}`).join(', ')" @change="query = $event.target.value"
              placeholder="Pick contacts to be assigned" />

            <ComboboxButton class="absolute inset-y-0 right-0 flex items-center pr-2">
              <ChevronUpDownIcon class="w-5 h-5 text-gray-400" aria-hidden="true" />
            </ComboboxButton>

          </div>

          <TransitionRoot leave="transition ease-in duration-100" leaveFrom="opacity-100" leaveTo="opacity-0"
            @after-leave="query = ''">
            <ComboboxOptions
              class="absolute w-full py-1 mt-1 overflow-auto text-base bg-white rounded-md shadow-lg max-h-60 ring-1 ring-black/5 focus:outline-none sm:text-sm">
              <div v-if="filteredContacts.length === 0 && query !== ''"
                class="relative px-4 py-2 text-gray-700 cursor-default select-none">
                Nothing found.
              </div>

              <ComboboxOption v-for="contact in filteredContacts" as="template" :key="contact.value" :value="contact"
                v-slot="{ selected, active }">
                <li class="relative py-2 pl-10 pr-4 cursor-default select-none" :class="{
                  'bg-blue-600 text-white': active,
                  'text-gray-900': !active,
                }">
                  <span class="block truncate" :class="{ 'font-medium': selected, 'font-normal': !selected }">
                    {{ contact.label }}
                  </span>
                  <span v-if="selected" class="absolute inset-y-0 left-0 flex items-center pl-3"
                    :class="{ 'text-white': active, 'text-blue-600': !active }">
                    <CheckIcon class="w-5 h-5" aria-hidden="true" />
                  </span>
                </li>
              </ComboboxOption>
            </ComboboxOptions>
          </TransitionRoot>
        </div>
      </Combobox>

      <InputError :message="form.errors.contacts" />
    </div>

   <section
    class="flex justify-end gap-4">
    <PrimaryButton type="submit">
      Add contacts
    </PrimaryButton>

    <SecondaryButton
      type="button"
      @click="closeModal">
      Cancel
    </SecondaryButton>
   </section>
  </form>
</template>
