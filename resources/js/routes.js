
import Vue from 'vue'
import VueRouter from 'vue-router'
import store from './store'
//import Home from './components/Home.vue';
import Login from './components/Login.vue'
import Signup from './components/Signup.vue'
import User from './components/User.vue'
import Posts from './components/Posts.vue'
//import Profile from './components/Profile.vue'
import Edit from './components/Edit.vue'

export const routes = [
    { path: '/', component: Login },
    { path: '/signup', component: Signup},
    { path: '/user/:id(\\d+)', component: User, meta: {requiresAuth: true},
        children: [
            { path: '', component: Posts }
        ]
    },
    { path: '/edit', component: Edit}

];

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes
})

router.beforeEach((to, from, next) => {

    if (to.matched.some(record => record.meta.requiresAuth) && !store.getters.authenicated) {
        next({
            path: '/',
            query: { redirect: to.fullPath }
          })
    } else {
        next()
    }
})

export default router
