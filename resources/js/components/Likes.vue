<template>
    <div v-if="likes.length" class="div-tweet">
        <app-post v-for="(like, index) in likes" v-bind:key="index" v-bind:post="like" v-bind:name="like.name"></app-post>
    </div>
    <div v-else>
        <span class="align-bottom">まだいいねがありません</span>
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

