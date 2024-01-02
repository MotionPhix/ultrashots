<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'

defineOptions({
  layout: GuestLayout,
})

const form = useForm({
  first_name: '',
  last_name: '',
  email: '',
  password: '',
  password_confirmation: '',
})

function submit() {
  form.post(route('register'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  })
}
</script>

<template>
  <Head title="Register" />

  <div class="flex items-center justify-between py-4 mb-4 border-b rounded-t dark:border-gray-600">
    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
      Start managing your contacts
    </h3>
  </div>

  <form
    class="space-y-4"
    @submit.prevent="submit"
  >
    <div>
      <label
        for="first_name"
        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
      >
        Your first name
      </label>

      <input
        id="first_name"
        v-model="form.first_name"
        type="text"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
        placeholder="Chris"
        autofocus
      >

      <span
        class="block mt-2 text-sm font-medium text-rose-500 empty:hidden"
        v-text="form.errors.first_name"
      />
    </div>

    <div>
      <label
        for="last_name"
        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
      >
        Your last name
      </label>

      <input
        id="last_name"
        v-model="form.last_name"
        type="text"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
        placeholder="Jones"
      >

      <span
        class="block mt-2 text-sm font-medium text-rose-500 empty:hidden"
        v-text="form.errors.last_name"
      />
    </div>

    <div>
      <label
        for="email"
        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
      >
        Your email
      </label>

      <input
        id="email"
        v-model="form.email"
        type="email"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
        placeholder="name@company.com"
      >

      <span
        class="block mt-2 text-sm font-medium text-rose-500 empty:hidden"
        v-text="form.errors.email"
      />
    </div>

    <div>
      <label
        for="password"
        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
      >
        Your password
      </label>

      <input
        id="password"
        v-model="form.password"
        type="password"
        placeholder="••••••••"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
      >

      <span
        class="block mt-2 text-sm font-medium text-rose-500 empty:hidden"
        v-text="form.errors.password"
      />
    </div>

    <div>
      <label
        for="password_confirmation"
        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
      >
        Your password
      </label>

      <input
        id="password_confirmation"
        v-model="form.password_confirmation"
        type="password"
        placeholder="••••••••"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
      >
    </div>

    <PrimaryButton class="w-full">
      Register
    </PrimaryButton>

    <div class="text-sm font-medium text-gray-500 dark:text-gray-300">
      Already registered? <Link :href="route('login')" class="text-blue-700 hover:underline dark:text-blue-500">
        Log in
      </Link>
    </div>
  </form>
</template>
