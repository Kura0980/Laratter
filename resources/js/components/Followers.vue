<template>
    <div v-if="is_load" class="d-flex justify-content-center">
        <img src="/img/icon/loading.gif">
    </div>
    <div v-else>
        <div v-if="followers.length" class="div-tweet">
            <app-user-link v-for="(follower, index) in followers" v-bind:key="index" v-bind:user="follower"></app-user-link>
        </div>
        <div v-else class="div-tweet">
            <span class="align-bottom">まだフォロワーがいません</span>
        </div>
    </div>
</template>

<script>
import http from '../http'
import UserLink from './UserLink.vue'

export default {
    data() {
        return {
            is_load: true,
            followers: []
        }
    },
    methods: {
        fetchFollowers(id) {
            http.get(`/user/${id}/follower`)
            .then(response => {
                this.followers = response.data
                this.is_load = false
            })
            .catch(err => {

            })
        }
    },
    created(){
        this.fetchFollowers(this.$route.params.id)        
    },
    components: {
        AppUserLink: UserLink
    }

}
</script>
