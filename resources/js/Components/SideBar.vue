<script setup>
import SideBarMenu from '@/Components/SideBarMenu.vue';
import { useMenuStore } from '@/Stores/menuStore';
import { Dialog, DialogOverlay, TransitionChild, TransitionRoot } from '@headlessui/vue';
import { storeToRefs } from 'pinia';

const menuControl = useMenuStore()

const {
  isOpen,
} = storeToRefs(menuControl)

const { toggleOpen } = menuControl
</script>

<template>
  <TransitionRoot :show="isOpen">
    <Dialog as="div" class="fixed inset-0 z-40 md:hidden" @close="toggleOpen">
      <TransitionChild
        enter="transition ease-in-out duration-200 transform"
        enter-from="-translate-x-full"
        enter-to="translate-x-0"
        leave="transition ease-in-out duration-200 transform"
        leave-from="translate-x-0"
        leave-to="-translate-x-full"
        as="template"
      >
        <div
          class="relative z-10 flex flex-col border-r border-gray-200 h-dvh dark:border-r-0 w-72 bg-gray-50 dark:bg-gray-800 md:hidden">

          <SideBarMenu />

        </div>
      </TransitionChild>

      <TransitionChild
        enter="transition-opacity ease-linear duration-200"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="transition-opacity ease-linear duration-200"
        leave-from="opacity-100"
        leave-to="opacity-0"
        as="template"
      >
        <DialogOverlay class="fixed inset-0 bg-gray-600 bg-opacity-50" />
      </TransitionChild>
    </Dialog>
  </TransitionRoot>

  <aside class="relative hidden w-64 border-r border-neutral-300 md:flex-col dark:border-neutral-600 md:flex">

    <SideBarMenu />

  </aside>
</template>
