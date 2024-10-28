<script setup lang="ts">
import { useContactStore } from '@/Stores/contactStore';
import { useGroupStore } from '@/Stores/groupStore';
import { useNotificationStore } from '@/Stores/notificationStore';
import { Group } from '@/types';
import { router, usePage } from '@inertiajs/vue3';
import { IconMailForward, IconPencil, IconPlus, IconTrash } from '@tabler/icons-vue';
import { storeToRefs } from 'pinia';
import { ref, watch } from 'vue';

const url = ref(usePage().url)
const groupId = route().params.group;

const groupStore = useGroupStore()
const alertStore = useNotificationStore()

const {
  groups,
  activeGroup,
  selectedGroups,
} = storeToRefs(groupStore)

const contactStore = useContactStore()

const { setSelectedContacts } = contactStore

const {
  setGroups,
  toggleIsEditing,
  toggleIsCreating,
  setActiveGroup,
  resetActiveGroup,
  resetSelectedGroups,
} = groupStore

const { notify } = alertStore

const displayingGroup = ref<Group>(activeGroup.value);

const sendMail = () => {
  activeGroup.value.contacts.map((contact) => {
    setSelectedContacts(contact.cid)
  })

  setTimeout(() => {
    router.get(route('mail.compose'), {}, {
      replace: true,
      preserveScroll: true,
    })
  }, 150)
}

const create = () => {
  toggleIsCreating()
}

const edit = () => {

  setTimeout(() => {

    toggleIsEditing()

  }, 50)

  if (activeGroup.value?.gid) {
    return setActiveGroup(activeGroup.value)
  }

  setActiveGroup(displayingGroup.value)

}

const remove = () => {

  router.delete(route('groups.destroy'), {

    data: {
      ids: selectedGroups.value as any,
    },

    onSuccess: (resp) => {

      setGroups(resp.props.groupList as Group[])

      notify({
        message: `Group${selectedGroups.value.length > 1 ? 's were' : ' was'} deleted.`,
        title: true
      })

      resetSelectedGroups()

      if (route().params.group) {
        setActiveGroup(resp.props.group)
      }

    },

    onError: (errors) => {

      const errorMessages = Object.values(errors).flatMap(value => {
        if (typeof value === 'object') {
          return Object.values(value);
        }
        return value;
      });

      errorMessages.forEach((error: string) => {
        notify({
          message: error,
          title: 'An error occurred!',
          type: 'danger'
        })
      });

    }

  })

}

watch(activeGroup, (newGroup, oldGroup) => {

  if (newGroup) {

    setTimeout(() => {

      displayingGroup.value = newGroup.name === '' ? oldGroup : newGroup;

    }, 150);

  }

  if (groupId && selectedGroups.value.length === 0) {
    const foundGroup = groups.value.find((group: Group) => groupId === group.gid);

    if (foundGroup) {
      setActiveGroup(foundGroup)
    }
  }

}, { immediate: true })


if (!url.value.startsWith('/g/')) {
  resetSelectedGroups()
}

if (!url.value.startsWith('/g/s/')) {
  resetActiveGroup()
}
</script>

<template>
  <section
    class="fixed top-0 z-30 flex items-center w-full h-16 gap-6 p-6 pl-8 overflow-y-hidden bg-gray-100 border-b dark:bg-gray-800 dark:text-white dark:border-gray-700">
    <h3 class="hidden capitalize lg:inline-flex" v-if="activeGroup?.name">
      {{ displayingGroup?.name }}
    </h3>

    <div class="hidden w-px h-8 bg-lime-500 lg:inline-flex" v-if="activeGroup?.name" />

    <button
      @click="create"
      v-if="!selectedGroups.length"
      class="flex items-center gap-2 font-semibold transition duration-300 hover:opacity-70">
      <IconPlus class="w-5 h-5 stroke-current" stroke-width="3.5" />
      <span>New group</span>
    </button>

    <button
      @click="edit"
      v-if="activeGroup?.gid && selectedGroups.length === 1"
      class="flex items-center gap-2 font-semibold transition duration-300 hover:opacity-70">
      <IconPencil class="w-5 h-5 stroke-current" />
      <span class="hidden md:inline-flex">Edit</span>
    </button>

    <button
      type="button"
      @click="remove"
      v-if="selectedGroups.length"
      class="flex items-center gap-2 font-semibold transition duration-300 hover:opacity-70">
      <IconTrash class="w-5 h-5 stroke-current" />
      <span class="hidden md:inline-flex">Delete</span>
    </button>

    <button
      class="flex items-center gap-2 font-semibold transition duration-300 hover:opacity-70"
      v-if="selectedGroups.length === 1"
      @click="sendMail">

      <IconMailForward class="w-5 h-5" />
      <span class="hidden md:inline-flex">Send Email</span>

    </button>
  </section>
</template>
