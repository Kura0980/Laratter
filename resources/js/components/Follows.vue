<template>
    <div v-if="follows.length" class="div-tweet">
        <app-user-link v-for="(follow, index) in follows" v-bind:key="index" v-bind:user="follow"></app-user-link>
    </div>
    <div v-else>
        <span class="align-bottom">まだフォローがありません</span>
    </div>
</template>

<script>
import http from '../http'
import UserLink from './UserLink.vue'

export default {
    data() {
        return {
            follows: []
        }
    },
    methods: {
        fetchFollows(id) {
            http.get(`/user/${id}/follow`)
            .then(response => {
                this.follows = response.data
            })
            .catch(err => {

            })
        }
    },
    created(){
        this.fetchFollows(this.$route.params.id)        
    },
    components: {
        AppUserLink: UserLink
    }

}
</script>
