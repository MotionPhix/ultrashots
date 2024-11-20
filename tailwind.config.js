const defaultTheme = require('tailwindcss/defaultTheme')

/** @type {import('tailwindcss').Config} */
export default {
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
        sans: ['Roboto', ...defaultTheme.fontFamily.sans],
        serif: ['DM Serif Display', 'serif']
      },

      fontSize: {
        xxs: ['0.65rem', { lineHeight: '1.1rem' }],
      },

      colors: {
        primary: {
          light: '#5D9773', // Dark Green
          dark: '#0C3B2E',  // Lighter Green
        },
        secondary: {
          light: '#BBA452', // Mustard Yellow
          dark: '#FFBA00',  // Bright Yellow
        },
        background: {
          light: '#e8e5e5', // for light mode
          dark: '#77918a',  // Dark Green for dark mode
        },
        text: {
          light: '#0C3B2E', // Dark Green for text in light mode
          dark: '#FFFFFF',  // White for text in dark mode
        },
        accent: {
          light: '#FFBA00', // Bright Yellow for accents in light mode
          dark: '#BBA452',  // Mustard Yellow for accents in dark mode
        },
      },
    },
  },

  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
    require('tailwind-scrollbar'),
  ],
}
