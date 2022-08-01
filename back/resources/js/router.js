import Vue from 'vue'


import {createRouter, createWebHistory} from "vue-router";
import Login from "./vue/pages/Login";
import Dashboard from "./vue/pages/Dashboard"

import { isLoggedIn } from './utils/auth'
import Organisation from "./vue/pages/Organisation";
import Users from "./vue/pages/Users";
import UserDetails from "./vue/components/User/UserDetails";
import UserUpdate from "./vue/components/User/UserUpdate";
import CreateOrganisation from "./vue/components/Organisation/CreateOrganisation";
import CreateUser from "./vue/components/User/CreateUser";


const routes = [
    {
        path: '/admin/index',
        name: 'Dashboard',
        component: Dashboard,
    },
    {
        path: '/admin/index/organisation/:id',
        name: 'Organisation',
        component: Organisation,
    },
    {
        path: '/admin/index/users',
        name: 'Users',
        component: Users,
    },
    {
        path: '/admin/index/user/detail/:id',
        name: 'UserDetails',
        component: UserDetails,
    },
    {
        path: '/admin/index/user/update/:id',
        name: 'UserUpdate',
        component: UserUpdate,
    },
    {
      path: '/admin/index/organisation/create',
      name: "CreateOrganisation",
      component:CreateOrganisation
    },

    {
        path: '/admin/index/user/create/:id',
        name: "CreateUser",
        component:CreateUser
    },
    {
        path: '/admin/index/login',
        name: 'Login',
        component: Login,
        meta:{
            allowAnonymous:true
        }
    },

];


const router = createRouter({
    history: createWebHistory(),
    routes
})
   router.beforeEach((to, from, next) => {
console.log(to)
  const publicPages = ['/admin/index/login'];
  const authRequired = !publicPages.includes(to.path);
    if(to.name==="Login" && isLoggedIn()){
        next({path:'/admin/index'})
    }
    if(authRequired && !isLoggedIn()){
        next({path:"/admin/index/login"});
    }else{
        next();
    }


    //    if (to.name ==='login' &&  !isLoggedIn()) {
    //        console.log('ok1')
    //        next({ path: '/' })
    //    }
    //    else if (!to.meta.allowAnonymous && !isLoggedIn()) {
    //        console.log('ok2')
    //        next({
    //           path: '/admin/index/login',
    //            query: { redirect: to.fullPath }
    //        })
    //    }
    //   else {
    //       next()
    //    }
   })



export default router
