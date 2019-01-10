<template>
    <div>
        <div class="user-header">
            <div class="jumbotron jumbotron-fluid user-header-img" :style="{ backgroundImage : `url(/storage/header/${header})` }">
                <label v-if="is_edit" for="header-file" class="header-file-label">
                    <input id="header-file" type="file" @change="uploadHeader" style="display:none">
                </label>
            </div>
            <div class="rounded-circle border border-white user-icon">
                <label for="icon-file">
                    <img v-if="icon !== ''" :src="`/storage/icon/${icon}`">
                    <img v-else src="/img/icon/default_icon.png">
                    <input v-if="is_edit" id="icon-file" type="file" @change="uploadIcon" style="display:none">
                </label>
            </div>
        </div>
        <div class="user-profile">
            <div v-if="user.id === loginUser.id" class="d-flex flex-row-reverse" key="profile-button">
                <button v-if="!is_edit" class="btn btn-outline-success profile-edit-button" @click="changeProfille">プロフィール編集</button>
                <button v-else class="btn btn-outline-success profile-edit-button" @click="editProfile">プロフィールを保存</button>
            </div>
            <div v-else class="d-flex flex-row-reverse" key="follow-button">
                <button v-if="!isFollow" class="btn btn-outline-success profile-edit-button" @click="changeFollow">フォロー</button>
                <button v-else class="btn btn-success profile-edit-button" @click="changeFollow">フォロー</button>
            </div>
            <div class="user-name">
                <h3 v-if="!is_edit">{{ user.name }}</h3>
                <input v-else type="text" class="profile-name-input" v-model="edit_name">
            </div>
            <div class="user-subscribe">
                <span v-if="!is_edit">{{ user.description }}</span>
                <input v-else type="text" class="profile-subscribe-input" v-model="edit_description">
            </div>
        </div>
        <div>
            <nav class="nav nav-justified">
                <router-link class="nav-item nav-link" :to="`/user/${$route.params.id}`" exact-active-class="active">ツイート</router-link>
                <router-link class="nav-item nav-link" :to="`/user/${$route.params.id}/follow`" exact-active-class="active">フォロー</router-link>
                <router-link class="nav-item nav-link" :to="`/user/${$route.params.id}/follower`" exact-active-class="active">フォロワー</router-link>
                <router-link class="nav-item nav-link" :to="`/user/${$route.params.id}/like`" exact-active-class="active">いいね</router-link>
            </nav>        
        </div>
        <router-view></router-view>
        <!-- <router-link tag="button" to="/edit">ツイート</router-link> -->
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
import http from '../http'
import follow from '../follow'

export default {
    data() {
        return {
            user: {},
            icon: '',
            header: '',
            is_edit: false,
            edit_name: '',
            edit_description: ''
        }
    },
    computed: {
        ...mapGetters({
            loginUser: 'user'
        }),
        isFollow () {
            return this.user.is_follow
        },
        user_icon () {
            return this.user.icon
        }
    },
    methods: {
        fetchUser(id) {
            http.get(`/user/${id}`)
            .then(response => {
                this.user = response.data
                this.icon = response.data.icon_img
                this.header = response.data.header_img
            })
            .catch(err => {

            })
        },
        changeProfille() {
            this.edit_name = this.user.name
            this.edit_description = this.user.description
            this.is_edit = true
        },
        changeFollow() {
            const isFollow = !this.user.is_follow
            if(isFollow) {
                this.follow(this.user.id, this);
            }else {
                this.cancelFollow(this.user.id, this);
            }
        },
        editProfile() {
            const user = {
                name: this.edit_name,
                description: this.edit_description
            }
            http.put('/user', user)
            .then(response => {
                this.user.name = response.data.name
                this.user.description = response.data.description
                this.is_edit = false
            })
            .catch(err => {

            })
        },
        uploadHeader(e) {
            const file = e.target.files[0]
            const data = new FormData
            data.append('file', file, 'title')
            http.post('/user/header', data)
            .then(response => {
                this.header = response.data.header
            })
            .catch(err => {

            })
        },
        uploadIcon(e) {
            const file = e.target.files[0]
            const data = new FormData
            data.append('file', file, 'title')
            http.post('/user/icon', data)
            .then(response => {
                this.icon = response.data.icon
            })
            .catch(err => {

            })
        }
    },
    watch: {
        '$route.params.id' (to, from) {
            this.fetchUser(to.params.id)
        }
    },
    created() {
        this.fetchUser(this.$route.params.id)
    },
    mixins:[follow]
}
</script>

<style scoped>
    .user-header{
        position: relative;
    }
    .header-file-label{
        width:100%;
        height:100%;
    }
    .user-header-img{
        background-color: greenyellow;
        background-position: center center;
        background-repeat: no-repeat;
        background-size: cover;
        height: 150px;
    }
    .user-icon{
        border: 15px;
        background-color: #d0cccc;
        position: absolute;
        bottom: -50px;
        width: 130px;
        height: 130px;
        overflow: hidden;
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
    .user-subscribe{
        margin-top: 10px;
    }

    .profile-name-input,
    .profile-subscribe-input{
        background-color: rgba(211, 211, 211, 0.1);
        border: none;
        border-bottom: solid 3px greenyellow;
    }

    .profile-name-input{
        font-weight: bold;
        font-size: large;
    }
    .profile-edit-icon{
        position: relative;
        margin: auto;
    }
</style>