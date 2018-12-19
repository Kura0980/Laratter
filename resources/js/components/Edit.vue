<template>
    <div>
        <div class="edit-header">
            <div class="d-flex flex-row-reverse">
                <button class="btn btn-success post-button" v-bind:class="{ disabled: sentence === '' }" @click="newPost">ツイート</button>
            </div>
        </div>
        <div class="text-center edit-body">
            <img class="align-top rounded-circle border border-white user-icon" src="/img/icon/default_icon.png">
            <textarea class="tweet-text form-control col-7" placeholder="いまなにしてる？" v-model="sentence"></textarea>
        </div>
    </div>
</template>

<script>
import http from '../http'

export default {
    data() {
        return {
            sentence: '',
        }
    },
    methods: {
        newPost() {
            const param = { sentence: this.sentence }
            http.post("/post", param)
            .then(response => {
                const id = this.$store.getters.user.id
                this.$router.push(`/user/${id}`)
            }).catch(err => {

            })
        }
    }
}
</script>

<style scoped>
    .edit-header{
        padding: 5px;
        height: 50px;
        border-bottom: solid 1px rgba(0, 0, 0, 0.3);
    }
    .edit-body{
        margin-top: 20px;
    }
    .post-button{
        border-radius: 1000px;
        margin-right: 25px;
    }
    textarea.tweet-text{
        resize: none;
        background-color: rgba(211, 211, 211, 0.1);
        display: inline-block;
        height: 150px;
        border: none;
        border-bottom: solid 3px greenyellow;
    }
    .user-icon{
        width: 50px;
        background-color: #d0cccc;
    }
</style>
