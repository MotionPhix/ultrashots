<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useNotificationStore } from '@/Stores/notificationStore';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const notifications = useNotificationStore()

const { notify } = notifications

const form = useForm({
  password: '',
});

const confirmUserDeletion = () => {

  confirmingUserDeletion.value = true;

  nextTick(() => passwordInput.value.focus());

};

const deleteUser = () => {
  form.delete(route('settings.profile.destroy'), {
    preserveScroll: true,
    onSuccess: () => {

      closeModal()

      notify({
        message: 'Your account was permanently deleted.',
        title: 'Goodbyes are hard!', type: 'danger'
      })

    },
    onError: () => passwordInput.value.focus(),
    onFinish: () => form.reset(),
  });
};

const closeModal = () => {
  confirmingUserDeletion.value = false;

  form.reset();
};
</script>

<template>
  <section
    class="flex flex-col space-y-6 lg:flex-row lg:gap-6">

    <header class="flex-1">
      <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Delete Account</h2>

      <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 text-pretty">
        Once your account is deleted, all of its resources and data will be permanently deleted.
      </p>
    </header>

    <div class="flex-1">
      <DangerButton @click="confirmUserDeletion">Delete Account</DangerButton>
    </div>

    <Modal
      :show="confirmingUserDeletion"
      @close="closeModal"
      max-width="md">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 text-balance">
          Are you sure you want to delete your account?
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
          Once your account is deleted, all of its resources and data will be permanently deleted. Please
          enter your password to confirm you would like to permanently delete your account.
        </p>

        <div class="mt-6">
          <InputLabel for="password" value="Password" class="sr-only" />

          <TextInput id="password" ref="passwordInput" v-model="form.password" type="password" class="block w-full mt-1"
            placeholder="Password" @keyup.enter="deleteUser" />

          <InputError :message="form.errors.password" class="mt-2" />
        </div>

        <div class="flex justify-end mt-6">
          <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

          <DangerButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
            @click="deleteUser">
            Delete
          </DangerButton>
        </div>
      </div>
    </Modal>
  </section>
</template>
