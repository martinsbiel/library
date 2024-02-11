<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card">
                    <h4 class="card-header d-flex"><span class="align-self-center">Solicitar troca de senha</span></h4>

                    <div class="card-body">
                        <form action="" method="post" @submit.prevent="sendResetLink()">
                            <div class="form-group mb-4">
                                <label class="form-label" for="email">Email:</label>
                                <input class="form-control" type="email" name="email" id="email" placeholder="Email" v-model="email" autofocus>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-lg btn-dark">Solicitar</button>
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
                url: '/api/v1/forgot-password',
                email: ''
            }
        },
        methods: {
            sendResetLink(){
                let formData = new FormData();
                formData.append('email', this.email);

                axios.post(this.url, formData)
                    .then(response => {
                        toastr.success(response.data.success);

                        this.$router.push({path: '/'});
                    }).catch(errors => {
                        if(!errors.response.data.errors.email){
                            for(let value in errors.response.data.errors){
                                toastr.error(errors.response.data.errors[value]);
                            }
                        }
                        
                        for(let value in errors.response.data.errors.email){
                            toastr.error(errors.response.data.errors.email[value]);
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
