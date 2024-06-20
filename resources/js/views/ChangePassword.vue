<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card">
                    <h4 class="card-header d-flex"><span class="align-self-center">{{ $t('ui.change_pass') }}</span></h4>

                    <div class="card-body">
                        <form action="" method="post" @submit.prevent="changePassword()">
                            <div class="form-group mb-4">
                                <label class="form-label" for="password">{{ $t('ui.current_pass') }}:</label>
                                <input class="form-control" type="password" name="password" id="password" :placeholder="$t('ui.current_pass')" v-model="password" autofocus>
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label" for="new_password">{{ $t('ui.new_pass') }}:</label>
                                <input class="form-control" type="password" name="new_password" id="new_password" :placeholder="$t('ui.new_pass')" v-model="new_password">
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label" for="new_password_confirmation">{{ $t('ui.confirm_new_pass') }}:</label>
                                <input class="form-control" type="password" name="new_password_confirmation" id="new_password_confirmation" :placeholder="$t('ui.confirm_new_pass')" v-model="new_password_confirmation">
                            </div>

                            <div class="form-group">
                                <button class="btn btn-lg btn-dark">{{ $t('ui.update') }}</button>
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
                url: '/api/v1/change-password',
                password: '',
                new_password: '',
                new_password_confirmation: '',
            }
        },
        methods: {
            changePassword(){
                let formData = new FormData();
                formData.append('_method', 'patch');
                formData.append('password', this.password);
                formData.append('new_password', this.new_password);
                formData.append('new_password_confirmation', this.new_password_confirmation);

                axios.post(this.url + '/' + this.$store.state.user.id, formData)
                    .then(response => {
                        toastr.success(response.data.success);

                        this.$router.push({path: '/'});
                    }).catch(errors => {
                        for(let value in errors.response.data.errors){
                            toastr.error(errors.response.data.errors[value]);
                        }
                    });
            }
        },
        mounted(){
            
        }
    }
</script>
