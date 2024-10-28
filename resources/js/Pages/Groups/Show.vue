<script setup lang="ts">
import GroupActionMenu from '@/Components/GroupActionMenu.vue';
import GroupCard from '@/Components/GroupCard.vue';
import LoadingState from '@/Components/LoadingState.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButtonLink from '@/Components/PrimaryButtonLink.vue';
import AuthenticatedLayout from '@/Layouts/AuthLayout.vue';
import AddContactsForm from '@/Pages/Groups/AddContactsForm.vue';
import GroupCreationForm from '@/Pages/Groups/GroupCreationForm.vue';
import GroupUpdatingForm from '@/Pages/Groups/GroupUpdatingForm.vue';
import { useGroupStore } from '@/Stores/groupStore';
import type { Group } from '@/types/index';
import { Head, Link, router } from '@inertiajs/vue3';
import { IconMailFast, IconPencil, IconTrash, IconUserMinus, IconUserPlus } from '@tabler/icons-vue';
import { storeToRefs } from 'pinia';
import { computed, onMounted, ref } from 'vue';

interface Props {
  group: Group
}

const props = defineProps<Props>()

const groupStore = useGroupStore()
const isAdding = ref(false)

const {
  groups,
  isEditing,
  isCreating,
  selectedGroups,
} = storeToRefs(groupStore)

const { fetchGroups, setGroups, setActiveGroup, addToSelectedGroups, toggleIsEditing, toggleIsCreating } = groupStore

function onCheckSelection() {

  if (!selectedGroups.value.length) addToSelectedGroups(props.group.gid)

}

const emailCount = computed(() => props.group.contacts.reduce((totalEmails, contact) => totalEmails + contact.emails.length, 0))

onMounted(async () => {
  await fetchGroups()
  setActiveGroup(props.group)
})

const removeContact = (id: number) => {
  router.post(route('groups.remove', { group: props.group.gid }), {
    contactId: id
  }, {
    onSuccess: (resp) => {
      setGroups(resp.props.groups as Group[])
    }
  })
}

function toggleIsAdding () {
  isAdding.value = !isAdding.value
}

defineOptions({ layout: AuthenticatedLayout })
</script>

<template>
  <Head :title="props.group.name" />

  <GroupActionMenu />

  <div class="flex h-screen gap-6 pt-12 mx-auto mb-10 lg:mb-0 lg:h-screen max-w-7xl sm:px-6 lg:px-8">

    <section
      class="hidden w-full pt-10 space-y-4 overflow-y-auto md:max-w-xs lg:block scrollbar-thin">

      <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-500">
        <template v-if="groups?.length">
          <GroupCard
            :group="group"
            :key="group.id"
            v-for="group in groups" />
        </template>

        <template v-else>
          <LoadingState />
        </template>
      </ul>

    </section>

    <section
      class="w-full h-full px-6 py-12 mx-2 space-y-4 text-sm text-gray-900 lg:border-l dark:border-gray-700 scrollbar-thin sm:mx-0 lg:overflow-y-auto dark:text-white">
      <section class="sticky top-0 flex items-center gap-6 pb-5">
        <div
          class="items-center justify-center hidden text-3xl font-bold prose prose-lg rounded-full prose-invert w-28 h-28 sm:flex shrink-0"
          :style="`background-color: ${props.group.color}`">
          <span class="uppercase">
            {{ props.group.name[0] }}
          </span>
        </div>

        <div class="flex flex-col w-full gap-1">
          <h3 class="text-4xl capitalize">
            {{ props.group.name }}
          </h3>

          <div class="flex items-center gap-2">
            <span>Contact group</span>
            <span class="flex w-2 h-2 rounded-full bg-lime-500"></span>
            <span>
              {{ emailCount }} email{{ emailCount === 1 ? '' : 's' }} | {{ props.group.contacts_count }} contact{{ props.group.contacts_count > 1 ? 's' : '' }}
            </span>
          </div>

          <div class="flex items-center w-full gap-2 font-semibold sm:gap-6">
            <PrimaryButtonLink
              :href="route('mail.compose')"
              @click="onCheckSelection">
              <IconMailFast />
              <span>Email</span>
            </PrimaryButtonLink>

            <button
              type="button"
              class="transition duration-300 hover:opacity-70"
              @click="toggleIsEditing">
              <IconPencil />
            </button>

            <button
              type="button"
              class="transition duration-300 hover:opacity-70"
              @click="toggleIsAdding">
              <IconUserPlus />
            </button>

            <Link
              as="button"
              class="transition duration-300 text-rose-500 hover:opacity-70"
              :href="route('groups.destroy', { ids: [props.group.gid] } as any)"
              method="delete">
              <IconTrash />
            </Link>
          </div>
        </div>
      </section>

      <div class="p-2 border-t dark:border-gray-500 sm:p-6 empty:hidden">
        <div class="w-full pb-5 mb-2">
          <h3 class="text-lg font-semibold leading-6 text-gray-900 dark:text-white">
            Contact List
          </h3>
          <p class="max-w-2xl mt-1 text-sm text-gray-500 dark:text-gray-200">
            Brief details about contacts in <strong class="capitalize">{{ props.group.name }}</strong> group.
          </p>
        </div>

        <ul class="grid grid-cols-1 gap-4 mt-5 xl:grid-cols-2">

          <!-- card start -->

          <li class="relative flex w-full mb-2 border-gray-400" v-for="contact in props.group.contacts">
            <div class="flex items-center flex-1 p-4 transition duration-500 ease-in-out transform bg-white rounded-md shadow select-none hover:-translate-y-1 hover:shadow-lg dark:bg-gray-800">
              <div class="flex flex-col items-center justify-center w-10 h-10 mr-4 font-semibold text-gray-800 bg-gray-300 rounded-md">
                {{ `${contact.first_name[0]}${contact.last_name[0]}` }}
              </div>

              <div class="flex-1 pl-1">
                <div class="font-semibold dark:text-white">
                  {{ `${contact.first_name} ${contact.last_name}` }}
                </div>

                <div class="text-sm text-gray-600 dark:text-gray-200">
                  {{ contact.last_email.email }}
                </div>
              </div>

              <button
                class="absolute flex items-center justify-end w-8 h-8 gap-2 py-2 pr-2 text-sm font-semibold text-right text-gray-700 rounded-lg bg-lime-200 top-3 right-3"
                v-if="props.group.contacts.length > 1"
                @click="removeContact(contact.id)">
                <IconUserMinus />
              </button>
            </div>
          </li>

          <!-- card end -->

        </ul>

      </div>

    </section>

  </div>

  <!-- form for creating groups -->
  <Modal
    :show="isCreating"
    @close="toggleIsCreating"
    v-if="isCreating"
    max-width="md">
    <div class="p-6">

      <GroupCreationForm />

    </div>
  </Modal>

  <!-- form for updating groups -->
  <Modal
    :show="isEditing"
    @close="toggleIsEditing"
    v-if="isEditing"
    max-width="md">
    <div class="p-6">

      <GroupUpdatingForm />

    </div>
  </Modal>

  <!-- form for adding contacts to groups -->
  <Modal
    :show="isAdding"
    @close="toggleIsAdding"
    v-if="isAdding"
    max-width="md">
    <div class="p-6">

      <AddContactsForm :close="toggleIsAdding" />

    </div>
  </Modal>
</template>
