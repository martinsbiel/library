<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card">
                    <h4 class="card-header d-flex"><span class="align-self-center">Login</span></h4>

                    <div class="card-body">
                        <form action="" method="post" @submit.prevent="login()">
                            <div class="form-group mb-4">
                                <label class="form-label" for="email">Email:</label>
                                <input class="form-control" type="text" name="email" id="email" placeholder="Email" v-model="email" autofocus>
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label" for="password">Senha:</label>
                                <input class="form-control" type="password" name="password" id="password" placeholder="Senha" v-model="password">
                            </div>

                            <div class="form-group mb-4">
                                <router-link class="link-dark" to="/forgot-password">Esqueci minha senha</router-link>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-lg btn-dark">Entrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        data(){
            return {
                url: '/api/v1/login',
                email: '',
                password: ''
            }
        },
        methods: {
            login(){
                let formData = new FormData();
                formData.append('email', this.email);
                formData.append('password', this.password);

                axios.post(this.url, formData)
                    .then(response => {
                        localStorage.setItem('token', response.data.token);

                        this.$store.dispatch('setAuthenticated', true);
                        this.$router.push({path: '/'});
                    }).catch(errors => {
                        for(let value in errors.response.data.errors){
                            toastr.error(errors.response.data.errors[value]);
                        }
                    });
            }
        },
        beforeMount(){
            if(this.$store.state.isAuthenticated){
                this.$router.push({path: '/'});
            }
        }
    }
</script>
