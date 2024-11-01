import './bootstrap';

import 'maz-ui/css/main.css';

import "vue-toastification/dist/index.css";

import '../css/app.css';

import 'preline'

import type { DefineComponent } from 'vue';

import { createApp, h } from 'vue';

import { createInertiaApp, router } from '@inertiajs/vue3';

import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

import { createPinia } from 'pinia';

import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

import { Modal, ModalLink, renderApp } from '@inertiaui/modal-vue'

import MazCheckbox from "maz-ui/components/MazCheckbox"

import MazSelect from "maz-ui/components/MazSelect"

import MazInput from "maz-ui/components/MazInput"

import MazBtn from "maz-ui/components/MazBtn"

import MazPhoneNumberInput from "maz-ui/components/MazPhoneNumberInput";

import MazDropdown from "maz-ui/components/MazDropdown";

import MazAvatar from "maz-ui/components/MazAvatar";

import Toast, { POSITION } from "vue-toastification";

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

const options = {
  icon: false,
  position: POSITION.BOTTOM_RIGHT,
  toastDefaults: {
    default: {
      // timeout: false,
      closeButton: false,
      newestOnTop: true,
      draggable: false,
      hideProgressBar: true,
      toastClassName: "my_toast_body_class",
      containerClassName: 'my_toast_container_ads'
    }
  }
}

createInertiaApp({
  title: title => `${title} | ${appName}`,
  resolve: name => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    // createApp({ render: () => h(App, props) })
    createApp({ render: renderApp(App, props) })
      .use(pinia)
      .use(plugin)
      .use(Toast, options)
      .use(ZiggyVue, Ziggy)
      .mixin({
        methods: {
          route: window.route,
          isRoute(...routes: []) {
            return routes.some(route => this.route().current(route))
          },
        },
      })
      .component('UltraModal', Modal)
      .component('UltraLink', ModalLink)
      .component('UltraSelect', MazSelect)
      .component('UltraBtn', MazBtn)
      .component('UltraInput', MazInput)
      .component('UltraPhoneInput', MazPhoneNumberInput)
      .component('UltraCheckbox', MazCheckbox)
      .component('UltraDropdown', MazDropdown)
      .component('UltraAvatar', MazAvatar)
      .mount(el)
  },
  progress: {
    color: '#4B5563',
  },
})
