<template>
  <smart-tagz
    autosuggest
    editable
    inputPlaceholder="Select Countries ..."
    :allowDuplicates="false"
    :maxTags="4"
    :defaultTags="['United Kingdom', 'Uruguay', 'Uzbekistan']"
    :class-names="{
      wrapper: 'tags_wrapper_custom',
      tag_name: 'tag_name_custom',
      tag_container: 'tag_container_custom',
      tag_close_btn: 'tag_close_btn_custom',
    }"
  />
</template>

<script>
import { SmartTagz } from "smart-tagz";
// import "smart-tagz/dist/smart-tagz.css";

import { defineComponent } from "vue";

export default defineComponent({
  name: "Basic",
  components: {
    SmartTagz,
  }
});
</script>
