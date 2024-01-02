<script setup lang="ts">
import SideBar from '@/Components/SideBar.vue';
import ToastList from '@/Components/ToastList.vue';
import { IconMenu, IconMoon, IconSun, IconX } from '@tabler/icons-vue';
import { UseDark } from '@vueuse/components';
import { ref } from 'vue';

const open = ref(false)

function close() {
  open.value = false
}

</script>

<template>
  <ToastList />

  <article
    class="fixed top-5 right-8 z-50 gap-4 flex items-center justify-centers">
    <button
      class="hover:opacity-70 bg-lime-500 rounded p-1 flex md:hidden transition duration-300 items-center justify-center"
      value="Close sidebar" @click="open = !open"
      type="button"
    >
      <Transition mode="out-in" name="fade">
        <IconX v-if="open" />
        <IconMenu v-else />
      </Transition>
    </button>

    <UseDark v-slot="{ isDark, toggleDark }">
      <button
        class="hover:opacity-70 dark:text-white text-gray-700"
        @click="toggleDark()">
        <IconSun v-if="isDark" />
        <IconMoon v-else />
      </button>
    </UseDark>
  </article>

  <div class="flex min-h-screen">

    <SideBar :sidebarOpened="open" @close="close" />

    <section
      class="flex-1 h-screen bg-gray-100 dark:bg-gray-800 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-800 scrollbar-track-gray-100">

      <main>
        <slot />
      </main>

    </section>

  </div>
</template>

<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
