<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Spinner from '@/Components/Spinner.vue';
import TextInput from '@/Components/TextInput.vue';
import { useGroupStore } from '@/Stores/groupStore';
import { useNotificationStore } from '@/Stores/notificationStore';
import { Group } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { storeToRefs } from 'pinia';
import { ref } from 'vue';
import { ColorPicker } from "vue3-colorpicker";
import "vue3-colorpicker/style.css";

const groupStore = useGroupStore()

const {selectedGroups, activeGroup} = storeToRefs(groupStore)

const { resetSelectedGroups, setGroups, toggleIsEditing } = groupStore

const nameInput = ref(null);

const args = ref({
  pickerType: 'chrome',
  useType: 'pure',
  shape: 'circle',
  isWidget: false,
  disableHistory: true,
  disableAlpha: true,
  format: 'hex'
})

const notifications = useNotificationStore()

const { notify } = notifications

const form = useForm({
  id: activeGroup.value?.id,
  name: activeGroup.value?.name,
  color: activeGroup.value?.color,
  description: activeGroup.value?.description,
  contacts: activeGroup.value?.contacts,
});

const createOrUpdate = () => {

  form.patch(route('groups.update', { group: activeGroup.value.gid }), {
    preserveScroll: true,
    onSuccess: (response) => {

      closeModal()

      notify({
        message: 'Group was updated',
        title: true,
        type: 'info'
      })

      setGroups(response.props.groupList as Group[])

    },
    onError: () => nameInput.value.focus(),
    onFinish: () => form.reset(),
  });

};

const closeModal = () => {
  toggleIsEditing()

  if (selectedGroups.value.length) {
    resetSelectedGroups()
  }

  form.reset();
};
</script>

<template>
  <section>

    <header>
      <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        Update group
      </h2>

      <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
        Ensure you are only adding unique group names.
      </p>
    </header>

    <form @submit.prevent="createOrUpdate" class="mt-6 space-y-6">
      <div>
        <InputLabel for="name" value="Group name" />

        <TextInput id="name" ref="nameInput" v-model="form.name"
          placeholder="Enter group name" class="block w-full mt-1" autocomplete="group_name" type="text" />

        <InputError :message="form.errors.name" class="mt-2" />
      </div>

      <div>
        <InputLabel for="description" value="Description" />

        <textarea id="description" ref="passwordInput" v-model="form.description" placeholder="Enter your new password"
          class="block w-full mt-1" autocomplete="off" type="password" />

        <InputError :message="form.errors.description" class="mt-2" />
      </div>

      <div>
        <InputLabel for="color" value="Group color" />

        <div class="flex items-center gap-2 mt-2">
          <color-picker
            v-model:pureColor="form.color"
            v-bind="args"/>

          <span class="text-sm text-gray-700 dark:text-gray-300">Pick a color for the group</span>
        </div>

        <InputError :message="form.errors.color" class="mt-2" />
      </div>

      <div class="flex items-center justify-end gap-4">
        <PrimaryButton
          :disabled="form.processing"
          class="flex justify-center gap-2 h-8.5"
          :class="{ 'py-3': !form.processing }">

          <span>
            Update
          </span>

          <Spinner v-if="form.processing" />

        </PrimaryButton>

        <SecondaryButton
          @click="closeModal"
          class="flex justify-center gap-2 py-3">
          Cancel
        </SecondaryButton>
      </div>
    </form>
  </section>
</template>
