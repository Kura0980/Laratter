<template>
    <div v-if="is_load" class="d-flex justify-content-center">
        <img src="/img/icon/loading.gif">
    </div>
    <div v-else>
        <div v-if="likes.length" class="div-tweet">
            <app-post v-for="(like, index) in likes" v-bind:key="index" v-bind:post="like" v-bind:name="like.name" v-bind:icon="like.icon_img"></app-post>
        </div>
        <div v-else>
            <span class="align-bottom">まだいいねがありません</span>
        </div>
    </div>
</template>

<script>
import http from '../http'
import Post from './Post.vue'

export default {
    data() {
        return {
            is_load: true,
            likes: []
        }
    },
    methods: {
        fetchLike(id) {
            http.get(`/user/${id}/like`)
            .then(response => {
                this.likes = response.data
                this.is_load = false
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

