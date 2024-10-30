<script setup lang="ts">
import Divider from '@/Components/Divider.vue';
import SectionHeader from '@/Components/SectionHeader.vue';
import AuthenticatedLayout from '@/Layouts/AuthLayout.vue';
import { Head } from '@inertiajs/vue3';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';

const props = defineProps<{
  mustVerifyEmail: boolean;
  user: Object;
}>()

defineOptions({
  layout: AuthenticatedLayout
})
</script>

<template>

  <Head title="Profile Settings" />

  <div class="max-w-full min-h-screen py-12">

    <h1
      class="py-6 mx-6 text-4xl text-gray-900 sm:mx-8 sm:text-5xl dark:text-white">
      Settings
    </h1>

    <div class="pt-4">

      <article class="px-4 overflow-hidden bg-white dark:bg-neutral-950 md:rounded-xl sm:px-8 sm:shadow">

        <SectionHeader>

          <template #title>
            Profile settings
          </template>

          <template #description>
            Change information related to your profile data on
            <strong>Ultrashots<sup>&REG;</sup></strong>
          </template>

        </SectionHeader>

        <!-- profile start -->

        <div class="py-12">

          <div class="w-full space-y-6">

            <UpdateProfileInformationForm
              :must-verify-email="props.mustVerifyEmail"
              :user="user"
              class="max-w-full" />


            <Divider />

            <UpdatePasswordForm class="max-w-full" />

            <Divider />

            <DeleteUserForm class="max-w-full" />

          </div>

        </div>

        <!-- profile end -->

      </article>

    </div>

  </div>

</template>
