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

  <aside class="relative hidden w-64 border-r border-gray-200 md:flex-col bg-gray-50 dark:bg-gray-900 dark:border-none md:flex">

    <!-- <div class="px-6 py-4 mb-5">
      <Link
        href="/"
        as="button"
        class="flex items-center gap-4 text-base font-bold text-gray-900 dark:text-white">
        <ApplicationLogo class="w-10 h-10" />

        <span class="text-2xl">
          ultrashots
        </span>
      </Link>
    </div>

    <section
      class="absolute w-full overflow-y-auto top-20 bottom-14 scrollbar-thin">

      <div class="mb-10">
        <h3 class="mx-6 mb-2 text-xs tracking-widest text-gray-400 uppercase">
          Main
        </h3>

        <Link
          v-for="(item, index) in mainNavigation"
          :href="item.filter ? route(item.href, item.filter) : route(item.href)"
          class="flex w-full items-center gap-2 px-6 py-2.5 text-gray-400 hover:text-lime-600 group"
          :class="{
            'font-bold text-lime-600': item.active ? $page.url.startsWith(item.active) : $page.url === '/contacts'
          }"
          :key="index"
          as="button"
        >
          <component
            :is="item.icon"
            class="w-6 h-6 stroke-current group-hover:text-lime-500"
          />
          {{ item.label }}
        </Link>
      </div>

      <div class="mb-10">
        <h3 class="mx-6 mb-2 text-xs tracking-widest text-gray-400 uppercase">
          Tags
        </h3>

        <Link
          v-for="(item) in tags"
          :key="item.value" :href="route('tags.filter', item.label)"
          class="flex gap-2 items-center px-6 py-2.5 text-gray-500 hover:text-lime-600 group"
          :class="{
            'font-bold text-lime-600': $page.url.startsWith(`/tags/${item.label}`)
          }"
          preserve-scroll
        >
          <component
            :is="IconTag"
            class="text-gray-400 group-hover:text-lime-500"
          />
          <span>{{ item.label }}</span>
        </Link>
      </div>

    </section>

    <div class="flex-1"></div>

    <div class="relative z-40 flex items-center w-full gap-4 px-6 mb-2 border-t border-gray-200 dark:border-gray-700">

      <QuickActionMenu />

    </div> -->

    <SideBarMenu />

  </aside>
</template>
