<script setup>
import { useMenuStore } from '@/Stores/menuStore';
import { Link, router } from '@inertiajs/vue3';
import { IconLogout, IconSettingsBolt } from '@tabler/icons-vue';

const menuControl = useMenuStore()
const { toggleOpen } = menuControl

const openPath = (path) => {
  toggleOpen()
  router.get(route(path))
}

const icons = {
  IconLogout,
  IconSettingsBolt,
}
</script>

<template>
  <UltraDropdown
    :items="[
      {
        label: 'Settings',
        icon: 'IconSettingsBolt',
        action: () => openPath('settings.profile.index')
      },
      {
        label: 'Logout',
        icon: 'IconLogout',
        action: () => openPath('settings.profile.index')
      }
    ]"
    block
    no-chevron
    no-padding
    position="top left"
    trigger="click">
    <template #default>

      <div class="flex items-center gap-2">

        <UltraAvatar :src="$page.props.auth.avatar" />

        <span class="font-semibold text-gray-700 dark:text-gray-400 text-wrap">
          {{ $page.props.auth.user.full_name }}
        </span>

      </div>

    </template>

    <template #menuitem-label="{ item }">

      <div
        class="flex items-center gap-4">
        <component :is="icons[item.icon]" class="size-6" />
        <span>{{ item.label }}</span>
      </div>

    </template>
  </UltraDropdown>

</template>
