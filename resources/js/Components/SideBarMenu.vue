<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import ContactListIcon from '@/Components/Icon/IconContactList.vue';
import ContactsIcon from '@/Components/Icon/IconContacts.vue';
import QuickActionMenu from '@/Components/QuickActionMenu.vue';
import {useMenuStore} from '@/Stores/menuStore';
import {useTagStore} from '@/Stores/tagStore';
import {Link} from '@inertiajs/vue3';
import {IconChartLine, IconTag} from '@tabler/icons-vue';
import axios from 'axios';
import {storeToRefs} from 'pinia';
import {onMounted} from 'vue';
import IconMailTemplate from "@/Components/Icon/IconMailTemplate.vue";
import IconContactFavourite from "@/Components/Icon/IconContactFavourite.vue";
import IconRemove from "@/Components/Icon/IconRemove.vue";

const tagStore = useTagStore()

const {
  tags,
} = storeToRefs(tagStore)

const {setTags} = tagStore

const mainNavigation = [
  {
    href: 'dashboard',
    label: 'Analytics',
    icon: IconChartLine,
    active: '/dashboard'
  },
  {
    href: 'templates.starter',
    label: 'Templates',
    icon: IconMailTemplate,
    active: '/templates'
  },
  {
    href: 'contacts.index',
    filter: 'favourites',
    label: 'Favourites',
    icon: IconContactFavourite,
    active: '/people/favourites'
  },
  {
    href: 'contacts.index',
    label: 'People',
    icon: ContactsIcon,
    active: '/people'
  },
  {
    href: 'groups.index',
    label: 'Groups',
    icon: ContactListIcon,
    active: '/g'
  },
  {
    href: 'contacts.index',
    filter: 'deleted',
    label: 'Deleted',
    icon: IconRemove,
    active: '/people/deleted'
  },
]

const menuControl = useMenuStore()

const {toggleOpen} = menuControl

onMounted(() => {
  axios
    .get('/tags')
    .then((feedback) => {
      setTags(feedback.data)
    })
})
</script>

<template>
  <div class="px-4 mt-4 mb-8">
    <Link
      href="/"
      as="button"
      class="flex items-center gap-4 text-4xl font-bold dark:text-gray-200">
      <ApplicationLogo class="w-10 h-10"/>
      <span>ultrashots</span>
    </Link>
  </div>

  <div class="flex flex-col flex-1 overflow-y-auto">
    <div class="mb-10">
      <h3 class="mx-6 mb-2 text-xs tracking-widest text-gray-400 uppercase">
        Main
      </h3>

      <Link
        as="button"
        v-for="(item, index) in mainNavigation"
        :href="item.filter ? route(item.href, item.filter) : route(item.href)"
        class="text-sm w-full flex items-center gap-3 px-6 py-2.5 dark:hover:text-lime-500 hover:text-lime-600 group"
        :class="{
          'text-lime-600 dark:text-lime-500 font-bold': $page.url.startsWith(item.active)
        }"
        @click="toggleOpen"
        :key="index"
      >
        <component
          :is="item.icon"
          class="size-6"
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
        :href="route('tags.filter', item?.name.toLowerCase())"
        class="flex items-center px-6 py-2.5 text-neutral-500 hover:text-lime-600 group"
        :class="{
          'font-bold text-lime-600': $page.url.startsWith(`/tags/${item.name}`)
        }"
        :key="item.id"
        preserve-scroll
      >
        <IconTag
          class="w-5 h-5 mr-2 text-gray-400 group-hover:text-lime-500"
        />
        {{ item.name }}
      </Link>
    </div>

    <div class="flex-1"></div>

    <div
      class="px-6 py-2 text-gray-500">

      <QuickActionMenu/>

    </div>
  </div>
</template>
