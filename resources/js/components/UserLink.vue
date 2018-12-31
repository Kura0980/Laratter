<template>
<div class="media user-description">
  <img class="align-self-start mr-3 rounded-circle user-icon" src="/img/icon/default_icon.png" alt="Generic placeholder image">
  <div class="media-body">
    <div class="row">
        <div class="col-md-9 col-7">
            <router-link tag="h5" :to="`/user/${user.id}`" class="mt-0 user-name">{{ user.name }}</router-link>
        </div>
        <div class="col-md-2 col-2">
            <button v-if="!user.is_follow" class="btn btn-outline-success follow-button" @click="changeFollow">フォロー</button>
            <button v-else-if="user.is_follow" class="btn btn-success follow-button" @click="changeFollow">フォロー</button>
        </div>
    </div>
    <!-- <p>{{ user.description }}</p> -->
    <p>コメント</p>
  </div>
</div>
</template>

<script>
import http from '../http'
import follow from '../follow'

export default {
    props: {
        user: Object
    },
    methods: {
        changeFollow() {
            const isFollow = !this.user.is_follow
            if(isFollow) {
                this.follow(this.user.id, this);
            }else {
                this.cancelFollow(this.user.id, this);
            }
        }
    },
    mixins:[
        follow
    ]

}
</script>

<style scoped>
.user-description {
    border-bottom: solid 1px;
    padding-top: 10px;
    padding-bottom: 10px;
}

.user-name {
    display: inline-block;
}

.follow-button{
    border-radius: 1000px;
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
        width: 40px;
        background-color: #d0cccc;
    }
}
</style>