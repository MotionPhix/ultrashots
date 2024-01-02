<script setup>
import { Dialog, DialogOverlay, TransitionChild, TransitionRoot } from '@headlessui/vue';
import { debounce } from 'lodash';
import { onMounted, onUnmounted, ref } from 'vue';
import SearchItem from './SearchItem.vue';

const isOpen = ref(false)
const results = ref([])
const input = ref()

function isAppleOs() {
  const platform = navigator?.userAgentData?.platform || navigator?.platform || 'unknown'
  return /(Mac|iPhone|iPod|iPad)/i.test(platform)
}

const keyboardShortcut = isAppleOs() ? 'Cmd+Y' : 'Ctrl+Y'

function onKeyDown(event) {
  if (isOpen.value)
    return

  if ((event.metaKey || event.ctrlKey) && event.key === 'y')
    isOpen.value = true
}

const search = debounce(async (term) => {
  const { data } = await axios.get('/search', { params: { q: term } })
  results.value = data.results
}, 500)

function uniqueKey(item) {
  return `${item.id}_${item.modelType}_`
}

function close() {
  setTimeout(() => isOpen.value = false, 500)
}

onMounted(() => window.addEventListener('keydown', onKeyDown))
onUnmounted(() => window.removeEventListener('keydown', onKeyDown))
</script>

<template>
  <button
    v-bind="$attrs"
    class="flex text-gray-400 items-center gap-2 border dark:border-gray-900/90 border-gray-900/10 shadow-sm px-3 py-1.5 focus:outline-none focus:border-gray-300 rounded-lg"
    @click="isOpen = true"
  >
    <svg
      xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
      class="w-6 h-6 flex-none -ml-1"
    >
      <path
        stroke-linecap="round" stroke-linejoin="round"
        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"
      />
    </svg>

    <span class="flex-1 text-sm text-left">Search anything ...</span>

    <span class="flex-none text-xs uppercase font-semibold">{{ keyboardShortcut }}</span>
  </button>

  <TransitionRoot as="template" :show="isOpen">
    <Dialog
      :open="isOpen"
      class="fixed inset-0 z-50 flex justify-center items-start"
      @close="isOpen = false"
    >
      <TransitionChild
        as="template"
        enter="transition duration-200 ease-linear"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="transition duration-200 ease-linear"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <DialogOverlay class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm" />
      </TransitionChild>

      <TransitionChild
        as="template"
        enter="transition-opacity ease-in-out duration-200 transform"
        enter-from="opacity-0 scale-95"
        enter-to="opacity-100 scale-100"
        leave="transition-opacity ease-in-out duration-200 transform"
        leave-from="opacity-100 scale-100"
        leave-to="opacity-0 scale-95"
      >
        <section class="flex flex-col overflow-hidden w-full max-w-2xl rounded-md bg-white mx-4 max-h-[70vh] mt-[10vh] relative">
          <form class="flex items-center text-gray-700 relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
              <svg
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                class="w-6 h-6 flex-none"
              >
                <path
                  stroke-linecap="round" stroke-linejoin="round"
                  d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"
                />
              </svg>
            </div>

            <input
              ref="input"
              type="text"
              placeholder="Search..."
              class="py-4 w-full pl-12 border-b border-gray-100 dark:border-gray-800 outline-none placeholder-gray-400"
              @input="(e) => search(e.target.value)">

            <div class="absolute inset-y-0 flex items-center right-0 pr-4">
              <button type="button" class="text-xxs flex items-center p-1.5 font-semibold uppercase tracking-wider rounded-md border border-gray-200 focus:outline-none focus:border-gray-400">
                ESC
              </button>
            </div>
          </form>

          <article class="overflow-auto">
            <transition-group
              name="fade"
            >
              <ul v-if="results.length" class="divide-y divide-gray-200 dark:divide-gray-600">
                <li v-for="item in results" :key="uniqueKey(item)" @click="close">
                  <SearchItem :result="item" />
                </li>
              </ul>
            </transition-group>

            <transition
              name="fade"
            >
              <div
                v-if="results.length === 0 && input?.value" class="px-6 py-3 text-lg bg-gray-300"
              >
                Your search, <strong>{{ input?.value }}</strong>, returned no matching records.
              </div>
            </transition>
          </article>
        </section>
      </TransitionChild>
    </Dialog>
  </TransitionRoot>
</template>

<style>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.5s, transform 0.5s;
}

.fade-enter, .fade-leave-to {
  opacity: 0;
  transform: scale(0.95);
}
</style>
