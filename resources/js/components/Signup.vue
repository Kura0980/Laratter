<template>
    <div class="col-sm-8 offset-sm-2">
        <div class="card">
            <div class="card-body">
                <h5>アカウントを作成</h5>
                <form @submit.prevent="submit">
                <div class="form-group row">
                    <div class="col-sm-8 offset-sm-2">
                        <input type="name" class="form-control" id="staticEmail" placeholder="名前" v-model="name" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-8 offset-sm-2">
                        <input type="email" class="form-control" id="staticEmail" placeholder="メールアドレス" v-model="email" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-8 offset-sm-2">
                        <input type="password" class="form-control" id="inputPassword" placeholder="パスワード" v-model="password" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary float-right">登録する</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapActions } from 'vuex'

    export default {
        data() {
            return {
                name: '',
                email: '',
                password: ''
            }
        },
        methods: {
            ...mapActions([
                'register'
            ]),
            submit() {
                const user = {
                    name: this.name,
                    email: this.email,
                    password: this.password
                }
                this.register(user)
            }
        }
    }
</script>