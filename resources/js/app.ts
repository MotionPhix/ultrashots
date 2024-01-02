import './bootstrap';

import 'maz-ui/css/main.css';

import '../css/app.css';

import 'vfonts/Inter.css';

import 'v-calendar/style.css';

import type { DefineComponent } from 'vue';

import { createApp, h } from 'vue';

import { createInertiaApp } from '@inertiajs/vue3';

import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

import mask from '@alpinejs/mask';
import Alpine from 'alpinejs';

import { createPinia } from 'pinia';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

import VueTouchRipple from 'vue-touch-ripple';
import 'vue-touch-ripple/style.css';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel'

const pinia = createPinia()

import { PhoneInput } from '@lbgm/phone-number-input';

window.Alpine = Alpine
Alpine.plugin(mask)

Alpine.start()

createInertiaApp({
  title: title => `${title} - ${appName}`,
  resolve: name => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(pinia)
      .use(plugin)
      .use(VueTouchRipple, {
        duration: 200,
      })
      .use(ZiggyVue, Ziggy)
      .component('PhoneInput', PhoneInput)
      .mixin({
        methods: {
          route: window.route,
          isRoute(...routes: []) {
            return routes.some(route => this.route().current(route))
          }
        }
      })
      .mount(el)
  },
  progress: {
    color: '#4B5563',
  },
})
