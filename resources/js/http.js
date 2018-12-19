import axios from 'axios'
import router from './routes'

const http = axios.create({
    baseURL: '/api'
})
http.interceptors.request.use((config) => {
    const token = sessionStorage.token
    if (token) {  
        config.headers.Authorization = `Bearer ${token}`
        return config
    }
    return config
}, function (error) {
    return Promise.reject(error)
})

http.interceptors.response.use(function (response) {
    return response
}, function (error) {
    if (error.response.status === 401) {
        router.push('/')
    } else if (error.response.status === 500) {

    }
    return Promise.reject(error)
})

export default http