<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button
        :type="type"
        class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-gray-700 uppercase transition duration-150 ease-in-out bg-white rounded-md shadow-sm dark:bg-gray-800 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-lime-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25"
    >
        <slot />
    </button>
</template>
