<script setup>
import BreezeInputError from '@/Components/InputError.vue';
import BreezeLabel from '@/Components/InputLabel.vue';
import BreezeButton from '@/Components/PrimaryButton.vue';
// import Spinner from '@/Components/Spinner.vue';
import BreezeInput from '@/Components/TextInput.vue';
import TipTap from '@/Components/TipTap.vue';
import { Head } from '@inertiajs/vue3';
import { useForm } from 'laravel-precognition-vue-inertia';

const props = defineProps({
  interaction: {
    type: Object,
    default: () => {}
  },
  contact: {
    type: Object,
    default: () => {}
  }
})

const form = useForm(
  props.interaction?.id ? 'patch' : 'post',
  props.interaction?.id ? route('interactions.update', props.interaction?.id) : route('interactions.store', props.contact), {
  type: props.interaction?.type ?? '',
  notes: props.interaction?.notes ?? '',
});

const submit = () => form.submit({
  preserveScroll: true,
  onSuccess: () => form.reset()
});
</script>

<template>
  <Head title="Contact" />

  <div class="flex relative justify-center min-h-screen bg-gray-100 items-top dark:bg-gray-900 sm:items-center sm:pt-0">
    <form class="w-full max-w-lg" @submit.prevent="submit">
      <div>
        <BreezeLabel for="name" value="Interaction type" />
        <BreezeInput
          v-model="form.type"
          placeholder="Enter an interction type, e.g, 'Phone call with Kingsley'"
          class="block mt-1 w-full" type="text"
          @change="form.validate('type')"
          autocomplete="name"
          id="name"  />
        <BreezeInputError :message="form.errors.type" />
      </div>

      <div class="mt-4">
        <BreezeLabel for="notes" value="Notes" />
        <TipTap
          v-model="form.notes"
          placeholder="Write something to expand more on the interaction type" />
        <BreezeInputError :message="form.errors.notes" />
      </div>

      <div class="flex justify-end items-center mt-4">
        <BreezeButton
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing" class="flex gap-2">
          <!-- <Spinner
            class="la-sm text-lime-500 dark:text-gray-600"
            v-if="form.processing" /> -->

          <span v-if="!form.processing">
            Create
          </span>

          <span v-if="form.progress">
            {{ form.progress.percentage }}%
          </span>
        </BreezeButton>
      </div>
    </form>
  </div>
</template>
