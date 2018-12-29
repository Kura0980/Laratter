<template>
    <div>
        <div class="user-header">
            <div class="jumbotron jumbotron-fluid user-header-img"></div>
            <img class="rounded-circle border border-white user-icon" src="/img/icon/default_icon.png">
        </div>
        <div class="user-profile">
            <div class="d-flex flex-row-reverse">
                <button class="btn btn-outline-success profile-edit-button">プロフィール編集</button>
            </div>
            <div><h3>{{ user.name }}</h3></div>
            <div><span>コメント</span></div>
        </div>
        <div>
            <nav class="nav nav-justified">
                <router-link class="nav-item nav-link" :to="`/user/${$route.params.id}`" exact-active-class="active">ツイート</router-link>
                <router-link class="nav-item nav-link" :to="`/user/${$route.params.id}/follor`" exact-active-class="active">フォロー</router-link>
                <router-link class="nav-item nav-link" :to="`/user/${$route.params.id}/follwer`" exact-active-class="active">フォロワー</router-link>
                <router-link class="nav-item nav-link" :to="`/user/${$route.params.id}/like`" exact-active-class="active">いいね</router-link>
            </nav>        
        </div>
        <router-view></router-view>
        <!-- <router-link tag="button" to="/edit">ツイート</router-link> -->
    </div>
</template>

<script>
import http from '../http'

export default {
    data() {
        return {
            user: {}
        }
    },
    methods: {
        fetchUser(id) {
            http.get(`/user/${id}`)
            .then(response => {
                this.user = response.data
            })
            .catch(err => {

            })
        }
    },
    watch: {
        '$route' (to, from) {
            this.fetchUser(to.params.id)
        }
    },
    created() {
        this.fetchUser(this.$route.params.id)
    }
}
</script>

<style scoped>
    .user-header{
        position: relative;
    }
    .user-header-img{
        background-color: greenyellow;
        height: 150px;
    }
    .user-icon{
        border: 15px;
        background-color: #d0cccc;
        position: absolute;
        bottom: -50px;
    }
    .user-profile{
        padding: 0px 10px;
    }
    .profile-edit-button{
        border-radius: 1000px;
    }
    .nav-item:hover{
        background-color: rgba(29, 161, 242, 0.1);
    }
    .nav-item.active{
        border-bottom: 2px solid;
    }
</style>