const defaultTheme = require('tailwindcss/defaultTheme')

/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: 'class',

  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './node_modules/@inertiaui/modal-vue/src/**/*.{js,vue}',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.vue',
  ],

  theme: {
    extend: {
      fontFamily: {
        sans: ['v-sans', 'Figtree', ...defaultTheme.fontFamily.sans],
      },

      fontSize: {
        xxs: ['0.65rem', { lineHeight: '1.1rem' }],
      },
    },
  },

  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
    require('tailwind-scrollbar'),
  ],
}
