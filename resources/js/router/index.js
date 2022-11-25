import { createRouter, createWebHistory } from 'vue-router';

import Login from '../Pages/Admin/user/Login.vue'
import ForgotPassword from '../Pages/Admin/user/ForgotPassword.vue'
import User from '../Pages/Admin/user/indexUser.vue'
import home from '../Pages/Client/Home.vue'
import dashboard from '../Pages/Admin/app/dashboards/indexDashboard.vue'

import Register from '../Pages/Admin/user/Register.vue'
import ResetPassword from '../Pages/Admin/user/ResetPassword.vue'
import AuthGuard from "../utils/auth.guard";
import { adminRoot } from "../constants/config";
import { UserRole } from "../utils/auth.roles";
import DefaultDashboards from "../Pages/Admin/app/dashboards/DefaultDashboard.vue"
import Analytics from "../Pages/Admin/app/dashboards/Analytics.vue"
import content from "../Pages/Admin/app/dashboards/content.vue"
import ecommerce from "../Pages/Admin/app/dashboards/ecommerce.vue"
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
        path:`${adminRoot}`,
        name: 'admin',
        component:dashboard,
        meta: { loginRequired: true, roles: UserRole.Admin },
        redirect: `${adminRoot}/default`,
        children: [
            {
              path: "default",
              component: DefaultDashboards,
              meta: { loginRequired: true, roles: UserRole.Admin },
            },
            {
                path: "analytics",
                component: Analytics,
                meta: { loginRequired: true, roles: UserRole.Admin },
              },
              {
                path: "ecommerce",
                component: ecommerce,
                meta: { loginRequired: true, roles: UserRole.Admin },
              },
              {
                path: "content",
                component: content,
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
        component: () => import(/* webpackChunkName: "unauthorized" */ "../Pages/Unauthorized.vue")
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
