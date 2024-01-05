import { Tag } from '@/types'
import { defineStore } from 'pinia'
import { reactive, ref, toRefs } from 'vue'

interface TagState {
  tags: Tag[]
  tag: Tag
}

export const useTagStore = defineStore('tag', () => {
  const state: TagState = reactive({
    tags: ref<Tag[]>([]),
    tag: ref<Tag>({}),
  })

  const { ...reactiveState } = toRefs(state)

  function setTags(tags: Tag[]) {
    state.tags = tags;
  }

  return { ...reactiveState, setTags }
})
