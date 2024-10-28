<script setup lang="ts">
import GroupActionMenu from '@/Components/GroupActionMenu.vue';
import GroupCard from '@/Components/GroupCard.vue';
import LoadingState from '@/Components/LoadingState.vue';
import Modal from '@/Components/Modal.vue';
import NoContactFound from '@/Components/NoContactFound.vue';
import AuthenticatedLayout from '@/Layouts/AuthLayout.vue';
import GroupCreationForm from '@/Pages/Groups/GroupCreationForm.vue';
import GroupUpdatingForm from '@/Pages/Groups/GroupUpdatingForm.vue';
import { useGroupStore } from '@/Stores/groupStore';
import { Group } from '@/types';
import { Head } from '@inertiajs/vue3';
import { IconPlus } from '@tabler/icons-vue';
import { storeToRefs } from 'pinia';
import { onMounted } from 'vue';

interface Props {
  groupList: Group[]
}

const props = defineProps<Props>()

const groupStore = useGroupStore()

const {
  isEditing,
  isCreating,
  groups,
} = storeToRefs(groupStore)

const { toggleIsEditing, toggleIsCreating, setGroups } = groupStore

onMounted(() => {
  setGroups(props.groupList)
})

defineOptions({ layout: AuthenticatedLayout })
</script>

<template>
  <Head title="Contact Groups" />

  <GroupActionMenu />

  <div class="py-12">
    <div class="flex flex-col px-6 pt-10 mx-auto max-w-7xl ">
      <template v-if="props.groupList.length">

        <ul class="w-full max-w-md divide-y divide-gray-200 dark:divide-gray-700">
          <template v-if="groups?.length">
            <GroupCard :group="group" v-for="group in groups" :key="group.id" />
          </template>

          <template v-else>
            <LoadingState />
          </template>
        </ul>

      </template>

      <article v-else class="w-full py-12 mt-12">
        <NoContactFound>

          <div>

            <button
              class="flex gap-2 items-center text-gray-500 border-gray-500 border hover:border-gray-900 rounded-lg dark:border-slate-600 dark:text-gray-500 font-semibold my-4 px-3 py-1.5 dark:hover:text-gray-400 dark:hover:border-gray-400 hover:text-gray-900 transition duration-300"
              @click="toggleIsCreating">

              <IconPlus class="w-5 h-5" stroke-width="3.5" />

              <span>Add group</span>

            </button>

          </div>

        </NoContactFound>
      </article>
    </div>
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
    max-width="md"
    @close="toggleIsEditing"
    v-if="isEditing">
    <div class="p-6">

      <GroupUpdatingForm />

    </div>
  </Modal>
</template>
