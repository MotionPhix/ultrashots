<script setup lang="ts">
import {useForm, usePage} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";

const form = useForm({
  name: ''
})

const emit = defineEmits(['companyCreated']);

const getActive = route().params

console.log(getActive)

function onSubmit() {
  form.post(route('companies.store'), {
    preserveScroll: true,
    onSuccess: (resp) => {
      console.log(resp)
      form.reset()
      emit('companyCreated', resp.props.company_id);
    }
  })
}
</script>

<template>
  <form>

    <div class="flex items-center gap-2">
      <UltraInput
        v-model="form.name"
        rounded-size="md"
        placeholder="Enter a company name to create it"
        size="sm"
        block/>

      <UltraBtn
        type="button"
        rounded-size="md"
        @click="onSubmit"
        size="sm">
        Create
      </UltraBtn>

    </div>

    <InputError :message="form.errors.name"/>

  </form>
</template>
