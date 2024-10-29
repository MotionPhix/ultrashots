<script setup>
import InputError from '@/Components/InputError.vue';
import {usePage} from '@inertiajs/vue3';
import {IconMailHeart, IconTrash} from '@tabler/icons-vue';
import {onMounted} from 'vue';

const props = defineProps({
  modelValue: {
    type: [Array, String],
    default: () => [],
  },
})

const emit = defineEmits(['update:modelValue'])

const page = usePage()

onMounted(() => {
  if (props.modelValue.length <= 0) {
    emit('update:modelValue', [...props.modelValue, {email: '', is_primary_email: true}])
  }
})

function addEmail() {
  emit('update:modelValue', [...props.modelValue, {email: '', is_primary_email: false}])
}

function onRemoveEmail(index) {
  const updatedEmails = props.modelValue.filter((_, i) => i !== index)
  emit('update:modelValue', updatedEmails)
}

function togglePrimaryEmail(index) {
  for (let i = 0; i < props.modelValue.length; i++) {
    if (i === index) {
      props.modelValue[i].is_primary_email = true;
    } else {
      props.modelValue[i].is_primary_email = false;
    }
  }
}
</script>

<template>
  <section class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
    <div
      v-for="(mail, idx) in modelValue"
      :key="idx"
      class="relative space-y-2 group first-letter:uppercase"
    >
      <UltraInput
        v-model="mail.email"
        placeholder="Enter email address"
        :class="{
          'border-r-4 rounded-xl border-r-indigo-600 dark:border-r-yellow-500': mail.is_primary_email
        }"
        @input:model-value="value => $emit('update:modelValue', value)"
        rounded-size="md"
        type="email"
        block
      />

      <InputError :message="page.props.errors[`emails.${idx}.email`]"/>

      <section
        class="absolute z-10 items-center hidden h-8 gap-2 px-3 py-1 top-0 group-hover:inline-flex right-1">
        <button
          type="button"
          @click="togglePrimaryEmail(idx)"
          size="xs"
        >
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
               class="stroke-2 hover:text-lime-500 stroke-current size-5" fill="none">
            <path
              d="M5.00035 7L3.78154 7.81253C2.90783 8.39501 2.47097 8.68625 2.23422 9.13041C1.99747 9.57457 1.99923 10.0966 2.00273 11.1406C2.00696 12.3975 2.01864 13.6782 2.05099 14.9741C2.12773 18.0487 2.16611 19.586 3.29651 20.7164C4.42691 21.8469 5.98497 21.8858 9.10108 21.9637C11.0397 22.0121 12.9611 22.0121 14.8996 21.9637C18.0158 21.8858 19.5738 21.8469 20.7042 20.7164C21.8346 19.586 21.873 18.0487 21.9497 14.9741C21.9821 13.6782 21.9937 12.3975 21.998 11.1406C22.0015 10.0966 22.0032 9.57456 21.7665 9.13041C21.5297 8.68625 21.0929 8.39501 20.2191 7.81253L19.0003 7"
              stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
            <path
              d="M2 10L8.91302 14.1478C10.417 15.0502 11.169 15.5014 12 15.5014C12.831 15.5014 13.583 15.0502 15.087 14.1478L22 10"
              stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
            <path
              d="M4.99998 12V6C4.99998 4.11438 4.99998 3.17157 5.58577 2.58579C6.17156 2 7.11437 2 8.99998 2H15C16.8856 2 17.8284 2 18.4142 2.58579C19 3.17157 19 4.11438 19 6V12"
              stroke="currentColor" stroke-width="1.5"/>
            <path d="M10 10H14M10 6H14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                  stroke-linejoin="round"/>
          </svg>
        </button>

        <button
          v-if="props.modelValue.length > 1" type="button"
          class="text-gray-500 dark:text-gray-300 group-hover:inline-flex"
          @click="onRemoveEmail(idx)">

          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
               class="stroke-current size-5 stroke-2 hover:text-rose-500" fill="none">
            <path
              d="M19.5 5.5L18.8803 15.5251C18.7219 18.0864 18.6428 19.3671 18.0008 20.2879C17.6833 20.7431 17.2747 21.1273 16.8007 21.416C15.8421 22 14.559 22 11.9927 22C9.42312 22 8.1383 22 7.17905 21.4149C6.7048 21.1257 6.296 20.7408 5.97868 20.2848C5.33688 19.3626 5.25945 18.0801 5.10461 15.5152L4.5 5.5"
              stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            <path
              d="M3 5.5H21M16.0557 5.5L15.3731 4.09173C14.9196 3.15626 14.6928 2.68852 14.3017 2.39681C14.215 2.3321 14.1231 2.27454 14.027 2.2247C13.5939 2 13.0741 2 12.0345 2C10.9688 2 10.436 2 9.99568 2.23412C9.8981 2.28601 9.80498 2.3459 9.71729 2.41317C9.32164 2.7167 9.10063 3.20155 8.65861 4.17126L8.05292 5.5"
              stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            <path d="M9.5 16.5L9.5 10.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            <path d="M14.5 16.5L14.5 10.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
          </svg>

        </button>
      </section>
    </div>
  </section>

  <div class="mt-4">
    <button
      v-if="modelValue.length < 4"
      type="button"
      class="flex items-center gap-2 font-bold text-blue-300 transition duration-300 dark:text-lime-300 hover:text-blue-500"
      @click="addEmail"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="w-6 h-6"
        viewBox="0 0 24 24" stroke-width="2"
        stroke="currentColor" fill="none"
        stroke-linecap="round" stroke-linejoin="round"
      >
        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
        <path d="M12 5l0 14"/>
        <path d="M5 12l14 0"/>
      </svg>

      Add email
    </button>
  </div>
</template>
