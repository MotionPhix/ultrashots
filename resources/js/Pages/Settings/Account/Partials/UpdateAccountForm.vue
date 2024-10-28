<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useNotificationStore } from '@/Stores/notificationStore';
import {Link, useForm, usePage} from '@inertiajs/vue3';
import AddressRepeater from "@/Components/AddressRepeater.vue";

const props = defineProps<{
  mustVerifyEmail: boolean;
  settings: {};
}>();

const form = useForm({
  currency: props.settings.currency ?? 'MK',
  address: props.settings.address ?? '',
  url: props.settings.url ?? '',
  default_sender_email: props.settings.key ?? '',
  contact_group_default: props.settings.contact_group_default ?? '',
  logo: props.settings.logo
});

const notifications = useNotificationStore()

const { notify } = notifications

console.log(props.settings)

const onSubmit = () => {
  form.transform((data) => {
    const modifiedPayload = {
      contact_group_default: data.contact_group_default,
      default_sender_email: data.contact_group_default,
    }

    if (data.logo.size !== 0) {
      modifiedPayload.logo = data.logo
    }

    if (data.currency !== '') {
      modifiedPayload.currency = data.currency
    }

    if (data.url !== '') {
      modifiedPayload.url = data.url
    }

    if (data.address !== '') {
      modifiedPayload.address = data.address
    }

    return modifiedPayload
  });

  form.post(route('account.update', props.account.fid), {

    forceFormData: true,

    onSuccess: () => {
      form.reset()
    }

  })
}
</script>

<template>

  <section
    class="flex flex-col lg:flex-row lg:gap-6">

    <header
      class="flex-1">

      <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        Account Information
      </h2>

      <p class="mt-1 text-sm text-gray-500 dark:text-gray-200">
        Update your account's information including logo, website, email, address, and slogan.
        The information you provide here will be used to brand the emails you will be sending.
      </p>

    </header>

    <form
      @submit.prevent="onSubmit"
      class="flex-1 mt-6 space-y-6 lg:mt-0">

      <div class="inline-flex flex-col gap-2">

        <UltraAvatar
          :src="form.logo"
          class="size-36" />

        <InputError class="mt-2" :message="form.errors.logo" />

      </div>

      <div>
        <InputLabel for="name" value="Default email" />

        <UltraInput
          id="name"
          type="email"
          class="mt-1"
          v-model="form.default_sender_email"
          placeholder="Enter an email address to use in 'from' field"
          autocomplete="name"
          rounded-size="md"
          block
        />

        <InputError class="mt-2" :message="form.errors.name" />
      </div>

      <div>
        <InputLabel for="currency" value="Currency" />

        <UltraInput
          id="currency"
          type="text"
          class="block w-full mt-1"
          v-model="form.currency"
          placeholder="Enter your email address"
          rounded-size="md"
          block
        />

        <InputError class="mt-2" :message="form.errors.email" />
      </div>

      <div>

        <AddressRepeater
          v-model="form.address" />

      </div>

      <div>
        <InputLabel
          for="account_website" class="mb-2">
          Website
        </InputLabel>

        <UltraInput
          id="account_website"
          v-model="form.url" type="url"
          placeholder="Company website e.g. https://www.example.com"
          rounded-size="md"
          block />

        <InputError :message="form.errors.url" />
      </div>

      <div>
        <InputLabel for="account_slogan" class="mb-2">
          Motto/Slogan
        </InputLabel>

        <UltraInput
          id="account_slogan"
          v-model="form.slogan" type="text"
          placeholder="Enter your slogan"
          rounded-size="md"
          block />

        <InputError :message="form.errors.slogan" />
      </div>

      <div v-if="props.mustVerifyEmail && $page.props.auth.user.email_verified_at === null">
        <p class="mt-2 text-sm text-gray-800 dark:text-gray-200">
          Your email address is unverified.
          <Link :href="route('verification.send')" method="post" as="button"
            class="text-sm text-gray-600 underline rounded-md dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
          Click here to re-send the verification email.
          </Link>
        </p>

        <div v-show="status === 'verification-link-sent'"
          class="mt-2 text-sm font-medium text-green-600 dark:text-green-400">
          A new verification link has been sent to your email address.
        </div>
      </div>

      <div class="flex items-center gap-4">
        <UltraBtn
          :disabled="form.processing"
          :loading="form.processing"
          rounded-size="md"
          color="success"
          type="submit"
        >
          Save
        </UltraBtn>

        <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
          leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
          <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">Saved.</p>
        </Transition>
      </div>
    </form>

  </section>

</template>
