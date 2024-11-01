<script setup>
import {ref, onMounted} from 'vue';

const editor = ref(null);
let builder;

const initializeBuilder = () => {
  builder = new Editor({
    root: '/builderjs/dist/',
    tags: [
      {name: 'Recipient Name', type: 'display'},
      {name: 'Sender Name', type: 'display'},
      {name: 'Current Date', type: 'constant'}
    ]
  });
  builder.init();
};

const saveTemplate = () => {
  builder.save((data) => {
    console.log('Template saved with data:', data);
  });
};

onMounted(() => {
  initializeBuilder();
});
</script>

<template>
  <div>
    <div id="builderjs-editor" ref="editor" style="height: 600px;"></div>
    <button @click="saveTemplate" class="btn btn-primary">Save Template</button>
  </div>
</template>

<style>
#builderjs-editor {
  border: 1px solid #ccc;
  padding: 10px;
}

.btn {
  margin-top: 20px;
}
</style>
