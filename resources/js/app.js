import './bootstrap';

import { createApp } from 'vue';
import router from './router';
import Login from './Pages/Admin/Login.vue';
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
import "bootstrap-vue-3/dist/bootstrap-vue-3.css";
import "../css/assets/css/vendor/bootstrap.min.css";
import "../css/assets/css/vendor/dropzone.min.css";
import "../css/assets/css/sass/main.scss";
import VueScrollTo from 'vue-scrollto'
import { getCurrentLanguage } from './utils'
import '@imengyu/vue3-context-menu/lib/vue3-context-menu.css'
import ContextMenu from '@imengyu/vue3-context-menu'
var app= createApp();
const messages = { en: en, es: es };
const locale = getCurrentLanguage();
const i18n = createI18n({
    locale: locale,
    fallbackLocale: 'en',
    messages
  })

const components = import.meta.globEager('./**/*.vue')

    Object.entries(components).forEach(([path, definition]) => {
               
        const componentName = path.split('/').pop().replace(/\.\w+$/, '')

        app.component(componentName, definition.default)

    });

app.use(router)
.use(BootstrapVue3)
.use(Notifications)
.use(VueScrollTo)
.use(ContextMenu)
.use(store)
.use(i18n)
.mount('#app');
