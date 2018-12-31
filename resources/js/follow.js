import http from './http'

export default {
    methods: {
        follow(followId, context) {
            http.post('/follow', { 'follow_id': followId })
            .then(response => {
                this.user.is_follow = true
            }).catch(err => {

            })
        },

        cancelFollow(followId, context) {
            http.delete(`/follow/${followId}`)
            .then(response => {
                this.user.is_follow = false
            }).catch(err => {

            })
        }
    }
}