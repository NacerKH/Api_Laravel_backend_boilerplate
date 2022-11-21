import './bootstrap';

import { createApp } from 'vue';
import router from './router';

import Colxx from './components/Common/Colxx.vue'

import BootstrapVue from 'bootstrap-vue-3'
import store from './store'
// Multi Language Add
import en from './locales/en.json'
import es from './locales/es.json'
import { createI18n } from 'vue-i18n'
import 'bootstrap';
import Notifications from '@kyvg/vue3-notification'


import BootstrapVue3 from "bootstrap-vue-3";
import {vBTooltip} from 'bootstrap-vue-3'

import "bootstrap-vue-3/dist/bootstrap-vue-3.css";
import "../css/assets/css/vendor/bootstrap.min.css";
import "../css/assets/css/vendor/dropzone.min.css";
import "../css/assets/css/sass/main.scss";
import VueScrollTo from 'vue-scrollto'
import { getCurrentLanguage } from './utils'
import '@imengyu/vue3-context-menu/lib/vue3-context-menu.css'
import ContextMenu from '@imengyu/vue3-context-menu'
import Breadcrumb from './components/Common/Breadcrumb.vue'
// RefreshButton Component Add
import RefreshButton from './components/Common/RefreshButton.vue'
// Colxx Component Add
import bColxx from './components/Common/Colxx.vue'
// Perfect Scrollbar Add
import Vuetable from 'vue3-vuetable'
import vuePerfectScrollbar from 'vue3-perfect-scrollbar'
import 'vue3-perfect-scrollbar/dist/vue3-perfect-scrollbar.css'
import ShortKey from'vue-shortkey'


var app = createApp();

const messages = { en: en, es: es };
const locale = getCurrentLanguage();
const i18n = createI18n({
    locale: locale,
    allowComposition: true,
    fallbackLocale: 'en',
    messages:messages
})

const components = import.meta.globEager('./Pages/**/*.vue')

Object.entries(components).forEach(([path, definition]) => {



        const componentName = path.split('/').pop().replace(/\.\w+$/, '')
        app.component(componentName, definition.default)




});
app.component('piaf-breadcrumb', Breadcrumb);
app.component('b-refresh-button', RefreshButton);
app.component('b-colxx', bColxx);


app.directive('b-tooltip', vBTooltip);
app.use(router)
    .use(BootstrapVue3)


    .use(Notifications)
    .use(VueScrollTo)
    .use(ContextMenu)
    .use(vuePerfectScrollbar, {
        watchOptions: true,
        options: {
          suppressScrollX: true
        }
      })
    .use(store)
    .use(ShortKey)
    .use(i18n)
    .use(Vuetable)
    .mount('#app');
