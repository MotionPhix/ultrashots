<script lang="ts" setup>
import { Head, Link } from '@inertiajs/vue3';
import { IconArrowLeft } from '@tabler/icons-vue';
import AppLayout from '../../Layouts/AppLayout.vue';

defineOptions({
  layout: AppLayout
})
</script>

<template>

  <Head title="Email Templates"/>

  <section class="flex flex-col justify-center mx-12 text-gray-800 h-svh dark:text-white">

    <p class="text-xl">Email templates</p>

    <h3 class="text-5xl font-semibold">
      Coming soon.
    </h3>

    <div class="mt-10 text-xl font-semibold">
      <Link
        :href="route('contacts.index')"
        class="flex items-center gap-2 transition duration-300 group hover:underline text-lime-700 hover:text-lime-500 hover:underline-offset-2"
        as="button">
        <IconArrowLeft class="hidden transition duration-200 group-hover:inline-block" />
        <span>Go back</span>
      </Link>
    </div>

  </section>

</template>
