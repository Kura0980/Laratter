<template>
    <div>
        <p class="error" v-if="error">{{ error }}</p>
        <div class="form-group">
            <label for="exampleInputEmail1">メールアドレス</label>
            <input type="email" class="form-control" aria-describedby="emailHelp" placeholder="メールアドレス" v-model="email">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">パスワード</label>
            <input type="password" class="form-control" placeholder="パスワード" v-model="password">
        </div>
        <button type="submit" class="btn btn-primary" @click="submit">ログイン</button>
        <router-link to="/signup" tag="button" class="btn btn-outline-primary">アカウント作成</router-link>
    </div>
</template>

<script>
    import { mapActions } from 'vuex'

    export default {
        data() {
            return {
                email: '',
                password: '',
                error: ''
            }
        },
        methods: {
            ...mapActions([
                'login'
            ]),
            submit () {
                const auth = {
                    email: this.email,
                    password: this.password,
                    component: this
                }
                this.login(auth)
            }
        }
    }
</script>

<style scope>
    .error{
        color: red;
    }
</style>
