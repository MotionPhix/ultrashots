<script setup lang="ts">
import Divider from '@/Components/Divider.vue';
import SectionHeader from '@/Components/SectionHeader.vue';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import { Head } from '@inertiajs/vue3';
import UpdateAccountForm from './Partials/UpdateAccountForm.vue';
import UpdateNotificationForm from './Partials/UpdateNotificationForm.vue';

defineProps<{
  mustVerifyEmail: boolean;
  settings: Object
}>();

defineOptions({
  layout: AuthLayout
})
</script>

<template>

  <Head title="Account Settings" />

  <div class="max-w-full min-h-screen py-12">

    <h1
      class="py-6 mx-6 text-4xl sm:text-5xl text-gray-900 sm:mx-8 dark:text-white">
      Settings
    </h1>

    <div class="pt-4">

      <article class="px-4 overflow-hidden bg-white dark:bg-neutral-950 md:rounded-xl sm:px-8 sm:shadow">

        <SectionHeader>

          <template #title>
            Account settings
          </template>

          <template #description>
            Update information related to your company. This information will be
            used on all emails you send on <strong>Ultrashots<sup>&REG;</sup></strong>
          </template>

        </SectionHeader>

        <!-- account start -->

        <div class="w-full space-y-6 pb-12">

          <UpdateAccountForm
            :must-verify-email="mustVerifyEmail"
            :settings="settings"
            class="max-w-full" />

          <Divider />

          <UpdateNotificationForm class="max-w-full" />

        </div>

        <!-- account end -->

      </article>

    </div>

  </div>

</template>
