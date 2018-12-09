
const state =  {
    authenticated: false,
    user: {},
    error: ''
}

const getters = {
    error: state => {
        return state.error
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
        axios.post("http://localhost/api/user", payload)
        .then(response => {
            commit('login', response.data.user)
            localStorage.setItem('token', response.data.token)
        }).catch(err => {
            payload.component.error = 'アカウントが存在しません。メールアドレスかパスワードを確認してください。'
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