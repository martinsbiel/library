<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card">
                    <h4 class="card-header d-flex"><span class="align-self-center">Redefinir senha</span></h4>

                    <div class="card-body">
                        <form action="" method="post" @submit.prevent="resetPassword()">
                            <div class="form-group mb-4">
                                <input type="hidden" name="token" id="token" :value="$route.params.token">
                                <label class="form-label" for="email">Email:</label>
                                <input class="form-control" type="email" name="email" id="email" placeholder="Email" v-model="email" autofocus>
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label" for="password">Senha:</label>
                                <input class="form-control" type="password" name="password" id="password" placeholder="Senha" v-model="password">
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label" for="password_confirmation">Confirmar senha:</label>
                                <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirmar senha" v-model="password_confirmation">
                            </div>

                            <div class="form-group">
                                <button class="btn btn-lg btn-dark">Redefinir</button>
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
                url: 'http://localhost:8000/api/v1/reset-password',
                token: '',
                email: '',
                password: '',
                password_confirmation: '',
            }
        },
        methods: {
            resetPassword(){
                let formData = new FormData();
                formData.append('token', this.token);
                formData.append('email', this.email);
                formData.append('password', this.password);
                formData.append('password_confirmation', this.password_confirmation);

                axios.post(this.url, formData)
                    .then(response => {
                        toastr.success(response.data.success);

                        this.$router.push({path: '/login'});
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
        },
        mounted(){
            const token = document.getElementById('token').value;

            this.token = token;
        }
    }
</script>
