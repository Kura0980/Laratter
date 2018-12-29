<template>
<div class="media post">
  <img class="align-self-start mr-3 rounded-circle user-icon" src="/img/icon/default_icon.png" alt="Generic placeholder image">
  <div class="media-body">
    <router-link tag="h5" :to="`/user/${post.user_id}`" class="mt-0">{{ name }}</router-link>
    <p>{{ post.sentence }}</p>
    <div class="row">
    <div class="col-2">
        <span class="oi oi-comment-square comment-icon"></span>
        <span class="comment-cnt">0</span>
    </div>
    <div class="col-2">
        <span class="oi oi-loop retweet-icon"></span>
        <span class="retweet-cnt">0</span>
    </div>
    <div class="col-2">
        <span class="oi oi-heart like-icon" v-bind:class="{ active: post.is_like }" @click="changeLike"></span>
        <span class="like-cnt">0</span>
    </div>
    </div>
  </div>
</div>
</template>

<script>
import http from '../http'

export default {
    props: {
        post: Object,
        name: String,
    },
    methods: {
        changeLike() {
            const isLike = !this.post.is_like
            if (isLike) {
                this.like()
            } else {
                this.cancelLike()
            }
        },

        like() {
            http.post('/like', { 'post_id': this.post.post_id })
            .then(response => {
                this.post.is_like = true
            }).catch(err => {

            })
        },

        cancelLike() {
            const postId = this.post.post_id
            http.delete(`/like/${postId}`)
            .then(response => {
                this.post.is_like = false
            }).catch(err => {

            })
        }
        
    }
}
</script>

<style scoped>
.post {
    border-bottom: solid 1px;
    padding-top: 10px;
    padding-bottom: 10px;
}

@media (min-width: 600px) {
    .user-icon{
        margin: 5px;
        width: 50px;
        background-color: #d0cccc;
    }
}

@media (max-width: 599px) {
    .user-icon{
        margin: 5px;
        width: 30px;
        background-color: #d0cccc;
    }
}

.comment-icon:not(.active),
.retweet-icon:not(.active),
.like-icon:not(.active) {
    color: #8080803b;
}

.like-icon.active {
    color: red;
}
</style>