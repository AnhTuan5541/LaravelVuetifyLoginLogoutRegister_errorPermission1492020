import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import User from '../components/user/user'
import Product from '../components/product/product'
import Profile from '../components/profile/profile'
import Role from '../components/role/role'
import Permission from '../components/permission/permission'

const routes = [
    {
        component: Profile,
        name: 'profile',
        path: '/'
    },
    {
        component: User,
        name: 'user',
        path: '/user'
    },
    {
        component: Product,
        name: 'product',
        path: '/product'
    },
    {
        component: Role,
        name: 'role',
        path: '/role'
    },
    {
        component: Permission,
        name: 'permission',
        path: '/permission'
    },
]

export default new VueRouter({
    // mode: 'history', //bỏ dấu thăng trên đường dẫn
    routes //short hand for routes: routes
})