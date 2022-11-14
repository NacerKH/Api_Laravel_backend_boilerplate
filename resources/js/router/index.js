import { createRouter, createWebHistory } from 'vue-router';
import Login from '../Pages/Admin/Login.vue'




const routes = [
    {
        path: '',
        name: 'Login',
        component: Login,
    }




];
export default createRouter({
    history: createWebHistory(),
    routes
})
