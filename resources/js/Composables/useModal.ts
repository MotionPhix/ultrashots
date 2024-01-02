import type { DefineComponent } from 'vue'

import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'

const useModal = {
  computed: {
    modalComponent() {
      return this.$page.props.modal
        ? resolvePageComponent(`../Pages/${this.$page.props.modal}.vue`, import.meta.glob < DefineComponent > ('../Pages/**/*.vue')) // defineAsyncComponent(() => import(`../Pages/${this.$page.props.modal}.vue`))
        : false
    },
  },
}

export { useModal }
