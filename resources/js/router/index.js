import { createRouter, createWebHistory } from 'vue-router';

import Login from '../Pages/Admin/user/Login.vue'
import ForgotPassword from '../Pages/Admin/user/ForgotPassword.vue'
import User from '../Pages/Admin/user/indexUser.vue'
import home from '../Pages/Client/Home.vue'
import dashboard from '../Pages/Admin/app/index.vue'

import Register from '../Pages/Admin/user/Register.vue'
import ResetPassword from '../Pages/Admin/user/ResetPassword.vue'
import AuthGuard from "../utils/auth.guard";
import { adminRoot } from "../constants/config";
import { UserRole } from "../utils/auth.roles";
import Error from'../Pages/Error.vue'



const routes = [


    {
        path: '/',
        name: 'home',
        component:home,
    },
    {
        path: '/user',
        name: 'Login',
        component:User,
        redirect: "/user/login",
        children: [
            {
              path: "login",
              component: () => import(/* webpackChunkName: "login" */ "../Pages/Admin/user/Login.vue"),
              meta: {
                hideForAuth: true
            }
            },
            {
              path: "register",
              component:Register
            },
            {
              path: "forgot-password",
              component:ForgotPassword,

            },
            {
              path: "reset-password/:token",
              component:ResetPassword
            },

          ]
    },
    ,
    {
        path: '/admin',
        name: 'admin',
        component:User,
        meta: { loginRequired: true, roles: UserRole.Admin },
        redirect: "/admin/dashboard",
        children: [
            {
              path: "dashboard",
              component: dashboard,
              meta: { loginRequired: true, roles: UserRole.Admin },
            },

          ]
    },
    {
        path: "/error",
        component: () => import(/* webpackChunkName: "error" */ "../Pages/Error.vue")
      },
      {
        path: "/unauthorized",
        component: () => import(/* webpackChunkName: "error" */ "../Pages/Unauthorized.vue")
      },
    // {
    //     path: "*",
    //     component: () => import(/* webpackChunkName: "error" */ "../Pages/Error.vue")
    //   }

];
const router= createRouter({
    history: createWebHistory(),
    linkActiveClass: "active",
    routes
})
router.beforeEach(AuthGuard);
export default router;
