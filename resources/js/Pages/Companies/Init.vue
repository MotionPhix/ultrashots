<script setup lang="ts">
import {useForm} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";

const form = useForm({
  name: ''
})

function onSubmit() {
  form.post(route('brands.store'), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset()
    }
  })
}

defineOptions({
  layout: GuestLayout
})
</script>

<template>

  <form @submit.prevent="onSubmit">

    <div class="grid gap-2">
      <UltraInput
        v-model="form.name"
        rounded-size="md"
        placeholder="Enter a brand name"
        size="sm"
        block/>

      <UltraBtn
        type="submit"
        rounded-size="md"
        size="sm">
        Add brand
      </UltraBtn>

    </div>

    <InputError class="mt-2" :message="form.errors.name"/>

  </form>

</template>
