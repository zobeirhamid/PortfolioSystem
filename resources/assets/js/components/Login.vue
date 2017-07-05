<template>
    <div class="login container">
        <h1>Login</h1>
        <form @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
            <p class="form-control">
                <label class="label">Email</label>
                <input class="input" type="email" placeholder="Your e-mail goes here" name="email" v-model="form.email">
                <span class="help is-danger" v-if="form.errors.has('email')" v-text="form.errors.get('email')"></span>
            </p>
            <p class="form-control">
                <label class="label">Password</label>
                <input class="input" type="password" name="password" v-model="form.password">
                <span class="help is-danger" v-if="form.errors.has('password')" v-text="form.errors.get('password')"></span>
            </p>
            <p class="form-control center-content">
                <button class="button is-success" :disabled="form.errors.any()">
                    Login
                </button>
            </p>
        </form>
    </div>
</template>

<script>
    import auth from '../auth';
    export default {
        data(){
            return{
                form: new Form({
                    email: '',
                    password: '',
                })
            }
        },
        methods: {
            onSubmit(){
                this.form.submit('post', '/api/login')
                    .then(data => {
                        auth.login(data.token);
                        if (this.$route.query.redirect) {
                            router.push(this.$route.query.redirect);
                        } else{
                            router.push('/admin');
                        }
                    })
                    .catch(errorData => console.log(errorData));
            }
        }

    }
</script>
<style lang="scss">
.login{
    max-width:800px;
}
</style>
