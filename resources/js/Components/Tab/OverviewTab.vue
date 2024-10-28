<script lang="ts" setup>
import type {Contact} from '@/types/index';
import {IconLocation, IconBuildingArch, IconMail, IconMap2, IconPhone, IconTag} from '@tabler/icons-vue';
import HeadlessTags from '../HeadlessTags.vue';

defineProps<{
  contact: Contact
}>()

</script>

<template>
  <section
    class="flex flex-col flex-1 flex-grow gap-10 py-6 xl:flex-row">

    <div class="space-y-8">

      <section
        class="flex gap-6">
        <IconMail class="shrink-0"/>

        <div>
          <h3 class="mb-4 text-lg font-semibold">
            Email address<span v-if="contact.emails?.length > 1">es</span>
          </h3>

          <p v-for="(email) in contact.emails" :key="email.id">
            <strong class="truncate">
              {{ email.email }}
            </strong>
          </p>

        </div>
      </section>

      <section
        class="flex gap-6">
        <IconPhone class="shrink-0"/>

        <div class="w-full space-y-2">
          <h3 class="mb-4 text-lg font-semibold">
            Phone number<span v-if="contact.phones?.length > 1">s</span>
          </h3>

          <p
            v-for="(phone, idx) in contact.phones"
            class="flex items-center justify-between pb-2 border-b last:border-b-0"
            :key="phone.id">
            <strong>
              {{ phone.formatted ?? phone.number }}
            </strong>

            <small>
              {{ phone.type }}
            </small>
          </p>
        </div>
      </section>

    </div>

    <div class="space-y-8">

      <section
        class="flex gap-6"
        v-if="contact.work">
        <IconBuildingArch class="shrink-0"/>

        <div>
          <h3 class="mb-4 text-lg font-semibold">Company</h3>

          <p
            class="flex flex-col gap-1">

            <span class="mb-2">
              <strong class="block">
                {{ contact.work?.name }}
              </strong>

              <small
                class="block empty:hidden"
                v-if="contact.work?.slogan">
                {{ contact.work.slogan ?? 'Slogan not added yet' }}
              </small>
            </span>

            <span
              class="flex items-start mb-1 empty:hidden"
              v-if="contact.work?.address">
              <span class="font-semibold text-gray-500 me-2">
                <IconMap2 class="w-3.5 h-3.5"/>
              </span>

              <span class="-mt-1">

              <div class="flex flex-col">

                <small class="capitalize">
                  Office address
                </small>

                <strong>
                  {{ contact.work.address.street }}
                </strong>

              </div>

            <div>
              {{ contact.work.address.city }}

              <span v-if="contact.work.address.state" class="empty:hidden">
                , {{ contact.work.address.state }}
              </span>

            </div>

            <strong class="text-blue-500">
              {{ contact.work.address.country }}
            </strong>

            </span>
            </span>

            <span
              class="flex items-center mb-1"
              v-if="contact.work?.url">
              <span class="font-semibold text-gray-400 me-2">
                <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 21 20">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6.487 1.746c0 4.192 3.592 1.66 4.592 5.754 0 .828 1 1.5 2 1.5s2-.672 2-1.5a1.5 1.5 0 0 1 1.5-1.5h1.5m-16.02.471c4.02 2.248 1.776 4.216 4.878 5.645C10.18 13.61 9 19 9 19m9.366-6h-2.287a3 3 0 0 0-3 3v2m6-8a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
              </span>

              <a
                :href="contact.work.url"
                class="text-blue-600 dark:text-blue-500 hover:underline"
                target="_blank">

                {{ contact.work.url }}
              </a>

            </span>

          </p>

        </div>
      </section>

      <section
        class="flex gap-6">
        <IconTag class="shrink-0"/>

        <div>
          <h3 class="mb-4 text-lg font-semibold">Categories</h3>

          <HeadlessTags v-model="contact.tags" :contact="contact"/>
        </div>
      </section>

    </div>

  </section>
</template>
