<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'
import InputLabel from "@/Components/InputLabel.vue"
import InputError from "@/Components/InputError.vue"

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

function onSubmit() {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
  })
}
</script>

<template>
  <Head title="Log in" />

  <div class="flex items-center justify-between py-4 mb-4 border-b rounded-t dark:border-gray-600">
    <h3 class="text-xl font-thin text-gray-900 dark:text-white">
      Sign in to our platform
    </h3>
  </div>

  <form
    class="space-y-4"
    @submit.prevent="onSubmit"
  >
    <div>
      <InputLabel
        for="email"
        class="mb-2"
      >
        Your email
      </InputLabel>

      <UltraInput
        id="email"
        v-model="form.email"
        type="email"
        placeholder="Enter your email address"
        rounded-size="md"
        color="success"
        autofocus
        size="lg"
        block
      />

      <InputError
        class="mt-2"
        :message="form.errors.email"
      />
    </div>

    <div>
      <InputLabel
        for="password"
        class="mb-2"
      >
        Your password
      </InputLabel>

      <UltraInput
        id="password"
        type="password"
        v-model="form.password"
        placeholder="Enter your password"
        rounded-size="md"
        color="success"
        size="lg"
        block
      />

      <InputError
        class="mt-2"
        :message="form.errors.password"
      />
    </div>

    <div class="flex justify-between">
      <div class="flex items-center gap-2">

        <UltraCheckbox
          id="remember"
          v-model="form.remember"
          class="dark:text-neutral-400"
          color="success">
          Remember me
        </UltraCheckbox>

      </div>

      <Link
        v-if="canResetPassword"
        :href="route('password.request')"
        class="text-sm text-blue-700 hover:underline dark:text-blue-500"
      >
        Forgot password?
      </Link>
    </div>

    <UltraBtn
      type="submit"
      color="success"
      rounded-size="md"
      :loading="form.processing"
      size="md"
      block>
      Login
    </UltraBtn>

    <div class="text-sm font-medium text-gray-500 dark:text-gray-300">
      Not registered? <Link :href="route('register')" class="text-blue-700 hover:underline dark:text-blue-500">
        Create account
      </Link>
    </div>
  </form>
</template>
