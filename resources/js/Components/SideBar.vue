<script setup>
import { Link, router } from '@inertiajs/vue3'

import { Dialog, DialogOverlay, TransitionChild, TransitionRoot } from '@headlessui/vue'

import ContactListIcon from '@/Components/Icon/IconContactList.vue'
import ContactsIcon from '@/Components/Icon/IconContacts.vue'

import ApplicationLogo from '@/Components/ApplicationLogo.vue'
import { useTagStore } from '@/Stores/tagStore'
import { IconStar, IconTag, IconTrash } from '@tabler/icons-vue'
import axios from 'axios'
import { storeToRefs } from 'pinia'
import { onMounted } from 'vue'

const props = defineProps({
  sidebarOpened: {
    type: Boolean,
    default: false,
  },
})

const emit = defineEmits(['close'])

const tagStore = useTagStore()

const {
  tags,
} = storeToRefs(tagStore)

const { setTags } = tagStore

function closeMenu() {
  emit('close')
}

function logout() {
  router.post('/logout')
}

const mainNavigation = [
  {
    href: 'contacts.index',
    filter: 'favourites',
    label: 'Favourites',
    icon: IconStar,
    active: '/favourites'
  },
  {
    href: 'contacts.index',
    label: 'All contacts',
    icon: ContactsIcon,
  },
  {
    href: 'contacts.groups.index',
    label: 'Contact groups',
    icon: ContactListIcon,
    active: '/groups'
  },
  {
    href: 'contacts.index',
    filter: 'deleted',
    label: 'Deleted',
    icon: IconTrash,
    active: '/deleted'
  },
]

onMounted(() => {
  axios
    .get('/tags')
    .then((feedback) => {
      setTags(feedback.data)
    })
})
</script>

<template>
  <TransitionRoot :show="sidebarOpened">
    <Dialog as="div" class="fixed inset-0 z-40 md:hidden" @close="closeMenu">
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

          <div class="px-4 mt-4 mb-8">
            <Link
              href="/"
              as="button"
              class="flex items-center gap-4 text-4xl font-bold dark:text-gray-200">
              <ApplicationLogo class="w-10 h-10" /> <span>ultrashots</span>
            </Link>
          </div>

          <div class="flex flex-col flex-1 overflow-y-auto">
            <div class="mb-10">
              <h3 class="mx-6 mb-2 text-xs tracking-widest text-gray-400 uppercase">
                Main
              </h3>

              <Link
                v-for="(item, index) in mainNavigation"
                :href="item.filter ? route(item.href, item.filter) : route(item.href)"
                class="flex items-center gap-3 px-6 py-2.5 text-gray-500 dark:text-gray-300 hover:text-lime-600 group"
                :class="{
                  'font-bold text-lime-600 dark:text-lime-300': item.active ? $page.url.startsWith(item.active) : $page.url === '/'
                }"
                @click="closeMenu"
                :key="index"
              >
                <component
                  :is="item.icon"
                  class="w-6 h-6 group-hover:text-lime-500"
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
                :href="route('tags.filter', item?.label)"
                class="flex items-center px-6 py-2.5 text-gray-500 hover:text-lime-600 group"
                :class="{
                  'font-bold text-lime-600': $page.url.startsWith(`/tags/${item.label}`)
                }"
                :key="item.value"
                preserve-scroll
              >
                <IconTag
                  class="w-5 h-5 mr-2 text-gray-400 group-hover:text-lime-500"
                />
                {{ item.label }}
              </Link>
            </div>

            <span class="flex-1"></span>

            <div class="mb-2 border-t border-gray-200 dark:border-gray-700">
              <Link
                as="button"
                href="/logout"
                method="post"
                class="flex items-center gap-4 px-6 py-2.5 text-gray-500 hover:text-lime-600 group"
              >
                <img
                  :src="$page.props.auth.avatar"
                  class="rounded-full w-7 h-7">

                <span>
                  {{ $page.props.auth.user.full_name }}
                </span>
              </Link>
            </div>
          </div>
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
    <div class="px-6 py-4 mb-5">
      <h3 class="flex items-center gap-4 text-base font-bold text-gray-900 dark:text-white">
        <ApplicationLogo class="w-10 h-10" />

        <span class="text-2xl">
          ultrashots
        </span>
      </h3>
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
            'font-bold text-lime-600': item.active ? $page.url.startsWith(item.active) : $page.url === '/'
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

    <div class="absolute bottom-0 z-40 w-full mb-2 border-t border-gray-200 dark:border-gray-700">

      <Link
        as="button"
        href="/logout"
        method="post"
        class="flex items-center gap-4 px-6 py-2.5 text-gray-500 hover:text-lime-600 group"
      >
        <img
          :src="$page.props.auth.avatar"
          class="rounded-full w-7 h-7">

        <span>
          {{ $page.props.auth.user.full_name }}
        </span>
      </Link>
    </div>
  </aside>
</template>
