import { defineStore } from 'pinia'
import { computed, reactive, ref, toRefs } from 'vue'

interface FiedState {
  hasMiddleName: boolean
  hasTitle: boolean
  hasNickname: boolean
  hasJobTitle: boolean
  hasLocation: boolean
  hasDepartment: Boolean
  hasAddresses: Boolean
  hasSlogan: Boolean
  hasUrl: boolean
}

export const useFieldStore = defineStore('field', () => {
  const state: FiedState = reactive({
    hasMiddleName: ref(false),
    hasTitle: ref(false),
    hasNickname: ref(false),
    hasJobTitle: ref(false),
    hasLocation: ref(false),
    hasDepartment: ref(false),
    hasAddresses: ref(false),
    hasSlogan: ref(false),
    hasUrl: ref(false),
  })

  const { ...reactiveState } = toRefs(state)

  const showTag = computed(() => !state.hasMiddleName || !state.hasTitle || !state.hasNickname)

  function toggleField(fieldKey: keyof FiedState) {
    const field = reactiveState[fieldKey]

    if (field !== undefined && field !== null)
      field.value = !field.value
  }

  return { showTag, ...reactiveState, toggleField }
})
