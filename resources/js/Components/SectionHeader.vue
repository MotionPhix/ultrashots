<script setup>
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';
import {Link, router} from '@inertiajs/vue3';
import { IconBuildingArch, IconCreditCardPay, IconDots, IconNotification, IconUserSquareRounded } from '@tabler/icons-vue';
import Divider from './Divider.vue';

const icons = {
  IconUserSquareRounded,
  IconBuildingArch,
}
</script>

<template>

  <section class="flex justify-between items-center mt-4 text-gray-900 dark:text-gray-100">

    <h1 class="py-2 text-2xl font-semibold">
      <slot name="title" />
    </h1>

    <UltraDropdown
      :items="[
        {
          label: 'Profile',
          action: () => router.visit(route('settings.profile.index')),
          icon: 'IconUserSquareRounded'
        },

        {
          label: 'Account',
          action: () => router.visit(route('settings.account.index')),
          icon: 'IconBuildingArch'
        }
      ]"
      position="bottom right"
      trigger="click"
      no-chevron
      size="xs"
      >
      <template #default>
        <IconDots stroke-width="3" />
      </template>

      <template #menuitem-label="{ item }">
        <div class="maz-flex maz-items-center maz-gap-2">
          <component :is="icons[item.icon]" class="h-5" /> <span>{{ item.label }}</span>
        </div>
      </template>
    </UltraDropdown>

  </section>

  <p class="text-neutral-400 dark:text-neutral-500" v-if="$slots.description">
    <slot name="description" />
  </p>

  <Divider />

</template>
