<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";

const form = useForm({
  first_name: '',
  last_name: '',
  email: '',
  company_name: '',
  password: '',
  password_confirmation: '',
})

function onSubmit() {

  form.post(route('register'), {

    preserveScroll: true,

    onSuccess: () => form.reset(),

  })

}

defineOptions({
  layout: GuestLayout,
})
</script>

<template>
  <Head title="Sign up" />

  <div class="flex items-center justify-between py-4 mb-4 border-b rounded-t dark:border-gray-600">
    <h3 class="text-xl font-thin text-gray-900 dark:text-white">
      Start managing your contacts
    </h3>
  </div>

  <form
    class="flex flex-col gap-6"
    @submit.prevent="onSubmit"
  >
    <div>
      <InputLabel
        for="first_name"
        class="mb-2">
        Your first name
      </InputLabel>

      <UltraInput
        id="first_name"
        v-model="form.first_name"
        type="text" placeholder="Enter your legal first name"
        rounded-size="md"
        color="success"
        autofocus
        size="lg"
        block
      />

      <InputError
        class="mt-2"
        :message="form.errors.first_name"
      />
    </div>

    <div>
      <InputLabel
        for="last_name"
        class="mb-2"
      >
        Your last name
      </InputLabel>

      <UltraInput
        id="last_name"
        v-model="form.last_name"
        type="text" placeholder="Enter your legal last name"
        rounded-size="md"
        color="success"
        size="lg"
        block
      />

      <InputError
        class="mt-2"
        :message="form.errors.last_name"
      />
    </div>

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
        v-model="form.password"
        type="password"
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

    <div>
      <InputLabel
        for="company_name"
        class="mb-2"
      >
        Company
      </InputLabel>

      <UltraInput
        id="company_name"
        v-model="form.company_name"
        type="text"
        placeholder="Enter your company name"
        rounded-size="md"
        color="success"
        size="lg"
        block
      />

      <InputError
        class="mt-2"
        :message="form.errors.company_name"
      />
    </div>

    <UltraBtn
      class="w-full"
      type="submit"
      color="success"
      rounded-size="md"
      :loading="form.processing">
      Register
    </UltraBtn>

    <div class="text-sm font-medium text-gray-500 dark:text-gray-300">
      Already registered? <Link :href="route('login')" class="text-blue-700 hover:underline dark:text-blue-500">
        Log in
      </Link>
    </div>
  </form>
</template>
