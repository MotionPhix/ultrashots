<template>
  <component class="w-6" :is="name" />
  <!-- <span class="sr-only">{{ name }}</span> -->
</template>

<script>
import Bold from './icons/Bold.vue';
import H2 from './icons/H2.vue';
import H3 from './icons/H3.vue';
import H4 from './icons/H4.vue';
import Hr from './icons/Hr.vue';
import Italic from './icons/Italic.vue';
import Redo from './icons/Redo.vue';
import Underline from './icons/Underline.vue';
import Undo from './icons/Undo.vue';

export default {
  components: {
    Redo,
    Bold,
    Bold,
    Hr,
    H2,
    H3,
    H4,
    Italic,
    Underline,
    Undo
  },
  props: {
    name: {
      type: String,
      default: '',
    },
    size: {
      type: String,
      default: 'normal',
    },
    modifier: {
      type: Object,
      default: null,
    },
    fixAlign: {
      type: Boolean,
      default: false,
    },
  },
};
</script>
