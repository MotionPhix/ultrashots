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
    class="fixed z-50 flex items-center gap-4 top-5 right-5 justify-centers">
    <button
      class="flex items-center justify-center p-1 transition duration-300 rounded hover:opacity-70 bg-lime-500 md:hidden"
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
        class="text-gray-700 hover:opacity-70 dark:text-white"
        @click="toggleDark()">
        <IconSun v-if="isDark" />
        <IconMoon v-else />
      </button>
    </UseDark>
  </article>

  <div class="flex min-h-screen">

    <SideBar :sidebarOpened="open" @close="close" />

    <section
      class="flex-1 h-screen overflow-y-auto bg-gray-100 dark:bg-gray-800 scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-800 scrollbar-track-gray-100">

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
