import router from '../routes'
import http from '../http'

const state =  {
    authenicated: false,
    user: {},
}

const getters = {
    authenicated: state => {
        return state.authenicated
    },
    user: state => {
        return state.user
    }
}

const mutations = {
    login(state, user) {
        state.authenicated = true
        state.user = user
    },
    logout(state) {
        state.authenicated = false
        state.user = {}
    },
    error(state, msg) {
        state.error = msg
    }
}

const actions = {
    login({ commit }, payload) {
        const auth = {
            email: payload.email,
            password: payload.password
        }
        http.post("/user", auth)
        .then(response => {
            const user = response.data.user
            commit('login', user)
            sessionStorage.setItem('token', response.data.token)
            router.push(`/user/${user.id}`)
        }).catch(err => {
            payload.component.error = 'アカウントが存在しません。メールアドレスかパスワードを確認してください。'
        })
    },

    register({ commit }, payload) {
        http.post("/user/register", payload)
        .then(response => {
            const user = response.data.user
            commit('login', user)
            sesstionStorage.setItem('token', response.data.token)
            router.push(`/user/${user.id}`)
        }).catch(err => {

        })
    },

    logout() {
        localStorage.removeItem('token')
        commit('logout')
    }
}

export default {
    state,
    mutations,
    actions,
    getters
}