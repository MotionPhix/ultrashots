<template>
  <div class="flex mt-4 animate-pulse" v-for="(idx) in [1, 2, 3]" :key="idx">
    <div class="flex-shrink-0">
      <span class="block w-12 h-12 bg-gray-200 rounded-full dark:bg-gray-700"></span>
    </div>

    <div class="w-full mt-2 ms-4">
      <h3 class="h-4 bg-gray-200 rounded-full dark:bg-gray-700" style="width: 40%;"></h3>

      <ul class="mt-5 space-y-3">
        <li class="w-full h-4 bg-gray-200 rounded-full dark:bg-gray-700"></li>
        <li class="w-full h-4 bg-gray-200 rounded-full dark:bg-gray-700"></li>
        <li class="w-full h-4 bg-gray-200 rounded-full dark:bg-gray-700"></li>
        <li class="w-full h-4 bg-gray-200 rounded-full dark:bg-gray-700"></li>
      </ul>
    </div>
  </div>
</template>
