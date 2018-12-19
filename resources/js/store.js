import Vue from 'vue'
import Vuex from 'vuex'
import VuexPersistedstate from 'vuex-persistedstate'
import user from './store/user'

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        user
    },
    plugins: [
        VuexPersistedstate({storage: window.sessionStorage})
    ]
});