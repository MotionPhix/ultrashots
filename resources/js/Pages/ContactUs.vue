<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import GuestLayout from '../Layouts/GuestLayout.vue';

const menu = ref(false)

defineOptions({
  layout: GuestLayout
})
</script>

<template>
  <!-- <div class="container pt-16 mx-auto">
    <div class="lg:flex">
      <div class="py-16 bg-indigo-700 rounded-tl rounded-tr xl:w-2/5 lg:w-2/5 xl:rounded-bl xl:rounded-tr-none">

        <div class="px-8 mx-auto xl:w-5/6 xl:px-0">

          <h1 class="pb-4 text-3xl font-bold text-white xl:text-4xl">Get in touch</h1>

          <p class="pb-8 text-xl font-normal leading-relaxed text-white lg:pr-4">
            Got a question about us?
            Are you interested in partnering with us?
            Have some suggestions or just want to say Hi?
            Just contact us. We are here to assist you.
          </p>

          <div class="flex items-center pb-4">
            <div>
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone-call" width="20"
                height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round"
                stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" />
                <path
                  d="M4 4h5l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v5a1 1 0 0 1 -1 1a16 16 0 0 1 -16 -16a1 1 0 0 1 1 -1" />
                <path d="M15 7a2 2 0 0 1 2 2" />
                <path d="M15 3a6 6 0 0 1 6 6" />
              </svg>
            </div>

            <p class="pl-4 text-base text-white">+265 (996) 727 163</p>

          </div>

          <div class="flex items-center">

            <div>
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="20" height="20"
                viewBox="0 0 24 24" stroke-width="1.5" stroke="#FFFFFF" fill="none" stroke-linecap="round"
                stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" />
                <rect x="3" y="5" width="18" height="14" rx="2" />
                <polyline points="3 7 12 13 21 7" />
              </svg>
            </div>

            <p class="pl-4 text-base text-white">support@ultrashots.net</p>

          </div>

          <p class="pt-10 text-lg tracking-wide text-white">
            545, Street 11, Block F
            <br />
            Dean Boulevard, Ohio
          </p>

        </div>

      </div>

      <div class="h-full pt-5 pb-5 bg-gray-200 rounded-tr rounded-br xl:w-3/5 lg:w-3/5 xl:pr-5 xl:pl-0">

        <form id="contact" class="px-8 py-4 bg-white rounded-tr rounded-br">

          <h1 class="mb-6 text-4xl font-extrabold text-gray-800">Enter Details</h1>

          <div class="grid grid-cols-1 gap-10 sm:grid-cols-2">

            <div class="flex flex-col w-full">
              <label
                for="full_name"
                class="mb-2 text-sm font-semibold leading-tight tracking-normal text-gray-800">
                First Name
              </label>

              <TextInput
                id="full_name"
                name="full_name"
                type="text"
                class="w-full"
                placeholder="Full name" />
            </div>

            <div class="flex flex-col w-full">
              <label
                for="last_name"
                class="mb-2 text-sm font-semibold leading-tight tracking-normal text-gray-800">
                Last Name
              </label>

              <TextInput
                id="last_name"
                name="last_name"
                type="text"
                class="w-full"
                placeholder="Full name" />
            </div>

            <div class="flex flex-col w-full">
              <label for="email"
                class="mb-2 text-sm font-semibold leading-tight tracking-normal text-gray-800">
                Email
              </label>

              <TextInput
                id="email"
                name="email"
                type="email"
                class="w-full"
                placeholder="Email address" />
            </div>

            <div class="flex flex-col">
              <label for="phone"
                class="mb-2 text-sm font-semibold leading-tight tracking-normal text-gray-800">
                Phone
              </label>

              <TextInput id="phone" name="phone" type="tel"
                class="w-full"
                placeholder="Your phone" />
            </div>

          </div>

          <div class="w-full mt-6">
            <div class="flex flex-col">
              <label class="mb-2 text-sm font-semibold text-gray-800" for="message">Message</label>
              <textarea placeholder="" name="message"
                class="px-3 py-2 mb-4 text-sm border border-gray-300 rounded outline-none resize-none focus:border focus:border-indigo-700"
                rows="8" id="message"></textarea>
            </div>

            <PrimaryButton
              type="submit"
              class="py-3">
              Send message
            </PrimaryButton>
          </div>

        </form>

      </div>
    </div>
  </div> -->


  <div class="w-full overflow-y-auto bg-gradient-to-b from-gray-600 to-gray-400 h-96">
    <div class="px-4 py-8 md:px-20">
      <div class="flex items-center justify-between">
        <Link href="/" class="flex items-center gap-2 text-3xl font-semibold dark:text-white">
          <ApplicationLogo class="w-8 h-8" />
          <span>ultrashots</span>
        </Link>

        <div class="items-center hidden lg:flex">
          <p tabindex="0" role="button"
            class="p-2 mr-10 text-base font-medium leading-4 text-white cursor-pointer focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-white hover:text-gray-300">
            Home</p>

          <p tabindex="0" role="button"
            class="p-2 mr-10 text-base font-medium leading-4 text-white focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-white hover:text-gray-300">
            Knowledge base</p>

          <p tabindex="0" role="button"
            class="p-2 mr-10 text-base font-medium leading-4 text-white focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-white hover:text-gray-300">
            Contact</p>

          <Link
            class="px-5 py-4 text-base font-semibold leading-none text-indigo-700 bg-white rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white hover:bg-gray-300"
            href="/register">
            Register now
          </Link>
        </div>

        <div class="text-white lg:hidden">
          <svg id="open" @click="menu = true" v-if="!menu" aria-haspopup="true" aria-label="Main Menu"
            xmlns="http://www.w3.org/2000/svg" class="show-m-menu icon icon-tabler icon-tabler-menu" width="28"
            height="28" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round"
            stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z"></path>
            <line x1="4" y1="8" x2="20" y2="8"></line>
            <line x1="4" y1="16" x2="20" y2="16"></line>
          </svg>

          <div id="close" v-if="menu" class="close-m-menu" @click="menu = false">
            <svg aria-label="Close" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
              stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" />
              <line x1="18" y1="6" x2="6" y2="18" />
              <line x1="6" y1="6" x2="18" y2="18" />
            </svg>
          </div>
        </div>
      </div>

      <nav class="relative z-40 lg:hidden">
        <div class="w-full">
          <div class="flex items-center visible">
            <ul id="list" v-if="menu" class="absolute top-0 left-0 right-0 p-2 mt-6 bg-white rounded shadow">
              <li
                class="flex py-2 mt-2 text-sm leading-3 tracking-normal text-gray-600 cursor-pointer hover:text-indigo-700 focus:text-indigo-700 focus:outline-none">
                <a href="javascript:void(0)">
                  <span class="ml-2 font-bold">Home</span>
                </a>
              </li>

              <li
                class="flex flex-col justify-center py-2 text-sm leading-3 tracking-normal text-gray-600 cursor-pointer hover:text-indigo-700 focus:text-indigo-700 focus:outline-none"
                @click="menu = false">
                <a href="javascript:void(0)">
                  <span class="ml-2 font-bold">Knowledge base</span>
                </a>
              </li>

              <li
                class="flex flex-col justify-center py-2 text-sm leading-3 tracking-normal text-gray-600 cursor-pointer hover:text-indigo-700 focus:text-indigo-700 focus:outline-none"
                @click="menu = false">
                <a href="javascript:void(0)">
                  <span class="ml-2 font-bold">Contact</span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </div>

    <div class="flex items-center justify-center w-full my-12">
      <div class="absolute px-8 py-12 bg-white rounded shadow top-40 lg:px-28">

        <!-- <section class="w-full">

          <h3 class="text-4xl font-bold leading-7 text-center text-gray-700 md:text-3xl">
            Get in touch
          </h3>

          <p>
            Got a question about us? Are you interested in partnering with us?
            Have some suggestions or just want to say Hi? Just contact us.
            We are here to assist you.
          </p>

        </section> -->

        <div class="items-center mt-12 md:flex">
          <div class="flex flex-col md:w-72">
            <label class="text-base font-semibold leading-none text-gray-800">Name</label>
            <input tabindex="0" arial-label="Please input name" type="name"
              class="p-3 mt-4 text-base leading-none text-gray-900 placeholder-gray-100 bg-gray-100 border border-gray-200 rounded focus:oultine-none focus:border-indigo-700"
              placeholder="Please input  name" />
          </div>

          <div class="flex flex-col mt-4 md:w-72 md:ml-6 md:mt-0">
            <label class="text-base font-semibold leading-none text-gray-800">Email Address</label>
            <input tabindex="0" arial-label="Please input email address" type="name"
              class="p-3 mt-4 text-base leading-none text-gray-900 placeholder-gray-100 bg-gray-100 border border-gray-200 rounded focus:oultine-none focus:border-indigo-700"
              placeholder="Please input email address" />
          </div>
      </div>

      <div class="items-center mt-8 md:flex">
        <div class="flex flex-col md:w-72">
          <label class="text-base font-semibold leading-none text-gray-800">Company name</label>
          <input tabindex="0" role="input" arial-label="Please input company name" type="name"
            class="p-3 mt-4 text-base leading-none text-gray-900 placeholder-gray-100 bg-gray-100 border border-gray-200 rounded focus:oultine-none focus:border-indigo-700"
            placeholder="Please input company name" />
        </div>

        <div class="flex flex-col mt-4 md:w-72 md:ml-6 md:mt-0">
          <label class="text-base font-semibold leading-none text-gray-800">Country</label>
          <input tabindex="0" arial-label="Please input country name" type="name"
            class="p-3 mt-4 text-base leading-none text-gray-900 placeholder-gray-100 bg-gray-100 border border-gray-200 rounded focus:oultine-none focus:border-indigo-700"
            placeholder="Please input country name" />
        </div>
      </div>

      <div>
        <div class="flex flex-col w-full mt-8">
          <label class="text-base font-semibold leading-none text-gray-800">Message</label>
          <textarea tabindex="0" aria-label="leave a message" role="textbox" type="name"
            class="p-3 mt-4 text-base leading-none text-gray-900 placeholder-gray-100 bg-gray-100 border border-gray-200 rounded resize-none h-36 focus:oultine-none focus:border-indigo-700"></textarea>
        </div>
      </div>
      <p class="mt-4 text-xs leading-3 text-gray-600">By clicking submit you agree to our terms of service, privacy
        policy and how we use data as stated</p>
      <div class="flex items-center justify-center w-full">
        <button
          class="px-10 py-4 text-base font-semibold leading-none text-white bg-indigo-700 rounded mt-9 hover:bg-indigo-600 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 focus:outline-none">SUBMIT</button>
      </div>
    </div>
  </div>
</div>
</template>
