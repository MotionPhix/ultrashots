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

  <div class="max-w-6xl min-h-screen py-12 mx-auto md:px-4">

    <h1 class="py-6 mx-4 text-4xl leading-none tracking-tight text-gray-900 sm:mx-8 md:text-5xl lg:text-6xl dark:text-white">Settings</h1>

    <div class="grid grid-cols-8 pt-3 sm:grid-cols-10">

      <article class="col-span-10 px-4 overflow-hidden bg-white dark:bg-gray-900 md:rounded-xl sm:px-8 sm:shadow">

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
