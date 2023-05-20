// import './bootstrap';
// @ts-nocheck
import '../css/app.css'
import { createApp, h } from 'vue'
import { createInertiaApp, Link } from '@inertiajs/vue3'
import 'tailwindcss/tailwind.css'
import _ from 'lodash'
import axios from 'axios'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { ZiggyVue } from 'ziggy'
import { createPinia } from 'pinia'
import { OhVueIcon, addIcons } from "oh-vue-icons";
import * as FaIcons from "oh-vue-icons/icons/md";
import "vue-toastification/dist/index.css";
import Toast, { PluginOptions } from "vue-toastification";
import { createI18n } from 'vue-i18n';
import messages from './lang';

const Fa = Object.values({ ...FaIcons });
addIcons(...Fa);
const appName =
  window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel'
window._ = _
window.axios = axios
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
const optionsToast: PluginOptions = {
    // You can set your default options here
};
const pinia = createPinia()

const i18n = createI18n({
    locale: localStorage.getItem('lang') ?? 'en', // set locale
    fallbackLocale: 'en', // set fallback locale
    messages, // set locale messages
    // If you need to specify other options, you can set other options
    // ...,
    legacy: false,
  })
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
      .use(Toast, optionsToast)
      .use(i18n)
      .component('InertiaLink', Link)
      .component("v-icon", OhVueIcon)
      .mixin({ methods: { route: window.route } })
      .mount(el)
  },
  progress: {
    color: '#4B5563',
  },
})

