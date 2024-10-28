<script setup>
import { Link } from '@inertiajs/vue3'
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
import {useDark} from '@vueuse/core'

const isDark = useDark()
</script>

<template>
  <div class="flex flex-col items-center min-h-screen py-10 bg-gray-100 sm:justify-center sm:pt-0 dark:bg-gray-900">

    <div class="w-full sm:max-w-md px-6">
      <Link href="/">
        <ApplicationLogo class="size-20 text-gray-500 fill-current" />
      </Link>
    </div>

    <div
      class="w-full px-6 py-4 mt-6 bg-white shadow-md sm:max-w-md dark:bg-gray-800 sm:rounded-lg"
    >
      <slot />
    </div>

  </div>
</template>
