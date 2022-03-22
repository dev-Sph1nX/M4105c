import Vue from 'vue';
import { createInertiaApp, Link } from '@inertiajs/inertia-vue';

import { store } from "./store/base-store";
import VCalendar from 'v-calendar';
import Toaster from 'v-toaster';
import 'v-toaster/dist/v-toaster.css';
Vue.use(Toaster, {timeout: 5000});
Vue.use(VCalendar);


Vue.prototype.$route = route;
Vue.component("Link", Link);

createInertiaApp({
  resolve: name => require(`./Pages/${name}`),
  setup({ el, App, props, plugin }) {
    Vue.use(plugin)

    new Vue({
      render: h => h(App, props),
      store
    }).$mount(el)
  },
})