<script setup lang="ts">
import Checkbox from '@/Components/Checkbox.vue';
import { useGroupStore } from '@/Stores/groupStore';
import type { Group } from '@/types';
import { Link, router } from '@inertiajs/vue3';
import { storeToRefs } from 'pinia';
import { computed } from 'vue';

const props = defineProps<{
  group: Group,
}>()

const groupStore = useGroupStore()

const param: any = computed(() => route().params)

const {
  groups,
  selectedGroups,
} = storeToRefs(groupStore)

const { setActiveGroup, resetActiveGroup, addToSelectedGroups, resetSelectedGroups, removeFromSelectedGroups } = groupStore

function isSelected(groupId?: string) {
  return (selectedGroups.value.includes(groupId));
}

function onGroupSelect(groupId?: string) {

  if (isSelected(groupId)) {
    removeFromSelectedGroups(groupId)
  } else {
    addToSelectedGroups(groupId)
  }

  if (selectedGroups.value.length === 1) {
    const localGroup = groups.value.find(group => group.gid === groupId);
    setActiveGroup(localGroup)
  } else {
    resetActiveGroup()
  }
}

router.on('navigate', (e) => {

  if (e.detail.page.component !== 'Component/Compose' && selectedGroups.value.length > 0) {
    resetSelectedGroups()
  }

})
</script>

<template>
  <li
    class="relative px-4 py-3 transition duration-300 ease-in-out hover:rounded-md sm:py-4 hover:bg-gray-200 dark:hover:bg-gray-600"
    :class="{ 'bg-gray-300 dark:bg-gray-700': props.group.gid === param.group }">
    <div
      class="absolute top-auto bottom-auto z-20 flex items-start justify-center flex-shrink-0 w-10 h-10 font-semibold transition duration-300 rounded-full cursor-pointer hover:bg-transparent group">

      <Checkbox
        @click="onGroupSelect(props.group.gid)"
        :checked="isSelected(props.group.gid)"
        class="w-6 h-6" />

    </div>

    <Link
      class="flex items-center w-full gap-6 pl-16 text-left"
      :href="route('groups.show', props.group.gid)" as="button"
      preserve-scroll>

      <section>

        <p class="font-semibold text-gray-900 capitalize dark:text-white">
          {{ props.group.name }}
        </p>

        <div class="text-sm text-gray-500 dark:text-gray-400">
          {{ props.group.contacts_count ?? 0 }} contact{{ props.group.contacts_count === 1 ? '' : 's' }}
        </div>

      </section>

    </Link>
  </li>
</template>
