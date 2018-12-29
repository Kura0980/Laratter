<template>
    <div class="div-tweet">
        <app-post v-if="likes" v-for="(like, index) in likes" v-bind:key="index" v-bind:post="like" v-bind:name="like.name"></app-post>
        <span v-else class="align-bottom">いいねがありません</span>
    </div>
</template>

<script>
import http from '../http'
import Post from './Post.vue'

export default {
    data() {
        return {
            likes: []
        }
    },
    methods: {
        fetchLike(id) {
            http.get(`/user/${id}/like`)
            .then(response => {
                this.likes = response.data
            })
            .catch(err => {
            })
        }
    },
    created(){
        this.fetchLike(this.$route.params.id)        
    },
    components: {
        AppPost: Post
    }
}

</script>

