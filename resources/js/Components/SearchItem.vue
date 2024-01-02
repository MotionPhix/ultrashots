<script setup>
import SearchCompany from './SearchCompany.vue';
import SearchContact from './SearchContact.vue';

const props = defineProps({
  result: {
    type: Object,
    required: true,
  },
})
</script>

<template>
  <SearchCompany v-if="result.modelType === 'Company'" :result="result" />
  <SearchContact v-if="result.modelType === 'Contact'" :result="result" />
</template>
