<script setup lang="ts">
import { UseDark } from '@vueuse/components'

import { IconMenu, IconMoon, IconSun } from '@tabler/icons-vue'

// import { Modal } from '/vendor/emargareten/inertia-modal'

import { ref } from 'vue'

import SideBar from '@/Components/SideBar.vue'

import ToastList from '@/Components/ToastList.vue'

const toggle = ref(false)

function toggleMenu() {
  toggle.value = !toggle.value
}
</script>

<template>
  <div class="fixed inset-0 flex min-h-screen bg-gray-100 dark:bg-gray-900">
    <SideBar :sidebar-opened="toggle" @close="toggleMenu" />

    <section class="flex-1 px-6 overflow-y-auto">
      <div class="fixed z-40 top-2 left-2 dark:text-gray-300 md:hidden">
        <button
          class="flex items-center justify-center flex-shrink-0 text-gray-600 rounded md:hidden hover:ring-2 hover:ring-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-600"
          type="button"
          value="Open sidebar" @click="toggleMenu"
        >
          <IconMenu class="w-6 h-6" />
        </button>
      </div>

      <div class="fixed z-40 top-2 right-2 dark:text-gray-300">
        <UseDark v-slot="{ isDark, toggleDark }">
          <button @click="toggleDark()">
            <IconSun v-if="isDark" class="h-4" />
            <IconMoon v-else class="h-4" />
          </button>
        </UseDark>
      </div>

      <main>
        <slot />
      </main>
    </section>
  </div>

  <ToastList />

  <!-- <Modal /> -->
</template>
