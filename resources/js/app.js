import './bootstrap';

import { createApp } from 'vue';
import router from './router';
import Login from './Pages/Admin/Login.vue';
var app= createApp();
const components = import.meta.globEager('./**/*.vue')

    Object.entries(components).forEach(([path, definition]) => {

        const componentName = path.split('/').pop().replace(/\.\w+$/, '')

        app.component(componentName, definition.default)

    });

app.use(router)
.mount('#app');
