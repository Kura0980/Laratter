
import './bootstrap'
import Vue from 'vue'
import moment from 'vue-moment'
import router from './routes'
import store from './store'
import App from './App.vue'

Vue.use(moment)

const app = new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App)
});
