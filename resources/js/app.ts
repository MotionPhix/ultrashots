import './bootstrap';

import 'maz-ui/css/main.css';

import '../css/app.css';

import 'vfonts/Inter.css';

import 'vue-touch-ripple/style.css';

import type { DefineComponent } from 'vue';

import { createApp, h } from 'vue';

import { createInertiaApp, router } from '@inertiajs/vue3';

import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

import { createPinia } from 'pinia';

import VueTouchRipple from 'vue-touch-ripple';

import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel'

const pinia = createPinia()

router.on('success', (event) => {
  let isAuthenticated = event.detail.page.props.auth.user !== null;
  window.localStorage.setItem('isAuthenticated', `${isAuthenticated}`);
});

window.addEventListener('popstate', (event) => {
  if (window.localStorage.getItem('isAuthenticated') === 'false') {
    event.stopImmediatePropagation();
    router.replace('/login');
  }
});

createInertiaApp({
  title: title => `${title} | ${appName}`,
  resolve: name => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(pinia)
      .use(plugin)
      .use(VueTouchRipple, {
        duration: 200,
      })
      .use(ZiggyVue, Ziggy)
      .mixin({
        methods: {
          route: window.route,
          isRoute(...routes: []) {
            return routes.some(route => this.route().current(route))
          },
        },
      })
      .mount(el)
  },
  progress: {
    color: '#4B5563',
  },
})
