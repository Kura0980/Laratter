
import Vue from 'vue'
import VueRouter from 'vue-router'
//import Home from './components/Home.vue';
import Login from './components/Login.vue'
import Signup from './components/Signup.vue'

export const routes = [
    { path: '/', component: Login },
    { path: '/signup', component: Signup}
];

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes
})

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth) && !store.authenticated) {
        next({
            path: '/',
            query: { redirect: to.fullPath }
          })
    } else {
        next()
    }
})

export default router
