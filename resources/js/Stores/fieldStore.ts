import { defineStore } from 'pinia'
import { computed, reactive, ref, toRefs } from 'vue'

interface FiedState {
  hasMiddleName: boolean
  hasJobTitle: boolean
  hasAddress: boolean
  hasSlogan: boolean
  hasUrl: boolean
}

export const useFieldStore = defineStore('field', () => {
  const state: FiedState = reactive({
    hasMiddleName: ref(false),
    hasJobTitle: ref(false),
    hasAddress: ref(false),
    hasSlogan: ref(false),
    hasUrl: ref(false),
  })

  const { ...reactiveState } = toRefs(state)

  function toggleField(fieldKey: keyof FiedState) {
    const field = reactiveState[fieldKey]

    if (field !== undefined && field !== null)
      field.value = !field.value
  }

  return { ...reactiveState, toggleField }
})
