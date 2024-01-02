<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'

defineProps<{
  canResetPassword?: boolean
  status?: string
}>()

defineOptions({
  layout: GuestLayout,
})

const form = useForm({
  email: '',
  password: '',
  remember: false,
})

function submit() {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
  })
}
</script>

<template>
  <Head title="Log in" />

  <div class="flex items-center justify-between py-4 mb-4 border-b rounded-t dark:border-gray-600">
    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
      Sign in to our platform
    </h3>
  </div>

  <form
    class="space-y-4"
    @submit.prevent="submit"
  >
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
        autofocus
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

    <div class="flex justify-between">
      <div class="flex items-center gap-2">
        <div class="flex items-center h-6">
          <input
            id="remember"
            v-model="form.remember"
            type="checkbox"
            class="w-5 h-5 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-600 dark:border-gray-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800"
          >
        </div>

        <label
          for="remember"
          class="text-sm font-medium text-gray-900 ms-2 dark:text-gray-300"
        >
          Remember me
        </label>
      </div>

      <Link
        v-if="canResetPassword"
        :href="route('password.request')"
        class="text-sm text-blue-700 hover:underline dark:text-blue-500"
      >
        Forgot password?
      </Link>
    </div>

    <PrimaryButton type="submit" class="w-full">
      Login
    </PrimaryButton>

    <div class="text-sm font-medium text-gray-500 dark:text-gray-300">
      Not registered? <Link :href="route('register')" class="text-blue-700 hover:underline dark:text-blue-500">
        Create account
      </Link>
    </div>
  </form>
</template>
