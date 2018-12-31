<template>
    <div v-if="posts.length" class="div-tweet">
        <app-post v-for="(post, index) in posts" v-bind:key="index" v-bind:post="post" v-bind:name="post.name"></app-post>
    </div>
    <div v-else class="div-notweet">
        <span class="align-bottom">ツイートがありません</span>
    </div>
</template>

<script>
import http from '../http'
import Post from './Post.vue'

export default {
    data() {
        return {
            posts: []
        }
    },
    methods: {
        fetchPost(id) {
            http.get(`/user/${id}/post`)
            .then(response => {
                this.posts = response.data
            })
            .catch(err => {
            })
        }
    },
    created(){
        this.fetchPost(this.$route.params.id)        
    },
    components: {
        AppPost: Post
    }
}
</script>


<style scoped>
    .div-tweet{
        height: 100%;
    }
</style>
