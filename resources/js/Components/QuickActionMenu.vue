<script setup>
import { useMenuStore } from '@/Stores/menuStore';
import { router } from '@inertiajs/vue3';
import { IconLogout, IconSettingsBolt } from '@tabler/icons-vue';

const menuControl = useMenuStore()
const { toggleOpen } = menuControl

const openPath = (path) => {

  toggleOpen()

  router.get(route(path))

}

const onLogout = () => {

  router.post(route('logout'))

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
        action: () => onLogout()
      }
    ]"
    no-chevron
    position="top left"
    trigger="click"
    is-button="false">
    <template #default>

      <div class="flex items-center gap-2">

        <UltraAvatar size="0.75rem" :src="$page.props.auth.avatar" />

        <div class="flex flex-col items-start leading-tight">

          <strong class="text-gray-700 dark:text-gray-400">
            {{ $page.props.auth.user.full_name }}
          </strong>

          <span class="text-xs text-neutral-400">
            {{ $page.props.auth.user.company.name }}
          </span>

        </div>

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
