<template>
  <div class="tag-input">
    <div v-for="tag in tags" :key="tag" class="tag-item">
      {{ tag }}
      <span @click="removeTag(tag)" class="tag-close">&times;</span>
    </div>
    <input
      v-if="inputVisible"
      v-model="inputValue"
      ref="inputRef"
      class="tag-input-field"
      @keyup.enter="handleInputConfirm"
      @blur="handleInputConfirm"
    />
    <button v-else class="tag-add-button" @click="showInput">+ Add Tag</button>
  </div>
</template>

<script setup>
import { nextTick, ref } from 'vue';

const inputValue = ref('');
const tags = ref(['Tag 1', 'Tag 2', 'Tag 3']);
const inputVisible = ref(false);
const inputRef = ref(null);

const removeTag = (tag) => {
  tags.value = tags.value.filter((t) => t !== tag);
};

const showInput = () => {
  inputVisible.value = true;
  nextTick(() => {
    inputRef.value.focus();
  });
};

const handleInputConfirm = () => {
  if (inputValue.value) {
    tags.value.push(inputValue.value);
  }
  inputVisible.value = false;
  inputValue.value = '';
};
</script>

<style scoped>
.tag-input {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
}

.tag-item {
  margin: 4px;
  padding: 8px;
  background-color: #eee;
  border-radius: 4px;
  display: flex;
  align-items: center;
}

.tag-close {
  cursor: pointer;
  margin-left: 8px;
}

.tag-input-field {
  margin: 4px;
  padding: 8px;
}

.tag-add-button {
  margin: 4px;
  padding: 8px;
  cursor: pointer;
  background-color: #2196f3;
  color: white;
  border: none;
  border-radius: 4px;
}
</style>
