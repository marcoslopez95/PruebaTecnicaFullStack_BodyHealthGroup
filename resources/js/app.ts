// import './bootstrap';
// @ts-nocheck
import '../css/app.css'
import { createApp, h, provide } from 'vue'
import { createInertiaApp, Link } from '@inertiajs/vue3'
import 'tailwindcss/tailwind.css'
import _ from 'lodash'
import axios from 'axios'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { ZiggyVue } from 'ziggy'
import { createPinia } from 'pinia'
const appName =
  window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel'
window._ = _
window.axios = axios
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
const pinia = createPinia()
createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) =>
    resolvePageComponent(
      `./Pages/${name}.vue`,
      import.meta.glob('./Pages/**/*.vue'),
    ),
  setup({ el, App, props, plugin }) {
    return createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(pinia)
      .use(ZiggyVue, Ziggy)
      .component('InertiaLink', Link)
      .mixin({ methods: { route: window.route } })
      .mount(el)
  },
  progress: {
    color: '#4B5563',
  },
})

