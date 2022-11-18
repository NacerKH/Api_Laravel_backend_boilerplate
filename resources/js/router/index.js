import { createRouter, createWebHistory } from 'vue-router';

import Login from '../Pages/Admin/user/Login.vue'
import ForgotPassword from '../Pages/Admin/user/ForgotPassword.vue'
import User from '../Pages/Admin/user/index.vue'
import Register from '../Pages/Admin/user/Register.vue'
import ResetPassword from '../Pages/Admin/user/ResetPassword.vue'
import AuthGuard from "../utils/auth.guard";
import { adminRoot } from "../constants/config";
import { UserRole } from "../utils/auth.roles";



const routes = [


    {
        path: '/',
        name: 'home',
        component:User,
    },
    {
        path: '/user',
        name: 'Login',
        component:User,
        redirect: "/user/login",
        children: [
            {
              path: "login",
             component:Login,
            },
            {
              path: "register",
              component:Register
            },
            {
              path: "forgot-password",
              component:ForgotPassword,
              meta: { loginRequired: true,roles:UserRole.Admin },
            },
            {
              path: "reset-password/:token",
              component:ResetPassword
            },

          ]
    }
];
const router= createRouter({
    history: createWebHistory(),
    linkActiveClass: "active",
    routes
})
router.beforeEach(AuthGuard);
export default router;
