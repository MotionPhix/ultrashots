<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {Link, useForm, usePage} from '@inertiajs/vue3';
import {useNotificationStore} from "@/Stores/notificationStore";

const props = defineProps<{
  mustVerifyEmail: boolean;
  user: Object;
}>();

const toastSession = usePage()

const notifications = useNotificationStore()

const { notify } = notifications

function uploadProfile() {
  console.log('profile upload initiated!')
}

const form = useForm({
  first_name: props.user.first_name,
  last_name: props.user.last_name,
  email: props.user.email,
  avatar: null
});

const onSubmit = () => {
  form.transform((data) => {
    const modifiedPayload = {
      first_name: data.first_name,
      last_name: data.last_name,
      email: data.email,
    }

    if (data.avatar !== null) {
      modifiedPayload.avatar = data.avatar
    }

    return modifiedPayload
  });

  form.post(route('settings.profile.update'), {
    _method: 'patch',
    forceFormData: true,
    onSuccess: () => {

      notify({
        message: toastSession.props.toast.message,
        title: true,
        type: toastSession.props.toast.type
      })

      form.reset()
    }
  })
}
</script>

<template>

  <section
    class="grid grid-cols-1 sm:grid-cols-2 gap-6">

    <header
      class="flex-1">

      <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        Profile Information
      </h2>

      <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
        Update your account's profile information and email address.
      </p>
    </header>

    <form
      @submit.prevent="onSubmit"
      class="flex-1 mt-6 space-y-6 lg:mt-0">

      <div>

        <UltraAvatar
          :src="$page.props.auth.avatar"
          @click="uploadProfile"
          rounded-size="xl"
          size="1.5rem"
          clickable
        />

      </div>

      <div>
        <InputLabel for="first_name" value="First name" />

        <TextInput
          id="first_name"
          type="text"
          class="block w-full mt-1"
          v-model="form.first_name" autofocus
          placeholder="Enter your first name"
          autocomplete="first_name" />

        <InputError class="mt-2" :message="form.errors.first_name" />
      </div>

      <div>
        <InputLabel for="last_name" value="Surname" />

        <TextInput
          id="last_name"
          type="text" class="block w-full mt-1"
          placeholder="Enter your family name"
          v-model="form.last_name" />

        <InputError class="mt-2" :message="form.errors.last_name" />
      </div>

      <div>
        <InputLabel for="email" value="Email" />

        <TextInput
          id="email"
          type="email"
          class="block w-full mt-1"
          v-model="form.email" required
          placeholder="Enter your email address"
          autocomplete="username" />

        <InputError class="mt-2" :message="form.errors.email" />
      </div>

      <div v-if="mustVerifyEmail && user.email_verified_at === null">
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
        <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

        <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
          leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
          <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">Saved.</p>
        </Transition>
      </div>
    </form>

  </section>

</template>
