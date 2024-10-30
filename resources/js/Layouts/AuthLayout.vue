<script setup lang="ts">
import SideBar from '@/Components/SideBar.vue';
import { useMenuStore } from '@/Stores/menuStore';
import { IconMenu, IconMoon, IconSun, IconX } from '@tabler/icons-vue';
import { UseDark } from '@vueuse/components';
import { storeToRefs } from 'pinia';

const menuControl = useMenuStore()

const {
  isOpen,
} = storeToRefs(menuControl)

const { toggleOpen } = menuControl

</script>

<template>
  <article
    class="fixed z-20 flex items-center gap-4 top-5 right-5 justify-centers">
    <button
      class="flex items-center justify-center p-1 transition duration-300 rounded hover:opacity-70 bg-lime-500 md:hidden"
      value="Close sidebar" @click="toggleOpen"
      type="button"
    >
      <Transition mode="out-in" name="fade">
        <IconX v-if="isOpen" />
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

  <div class="flex min-h-screen mx-auto max-w-6xl">

    <SideBar />

    <section
      class="flex-1 h-screen overflow-y-auto scrollbar-none scroll-smooth">

      <main class="md:px-10 px-4">
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
