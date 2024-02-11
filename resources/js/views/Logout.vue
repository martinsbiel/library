<template>
    
</template>

<script>
    export default {
        data(){
            return {
                url: '/api/v1/logout',
            }
        },
        methods: {
            logout(){
                axios.post(this.url)
                    .then(response => {
                        this.$store.dispatch('setAuthenticated', false);
                        this.$router.push({path: '/'});

                        toastr.success(response.data.success);
                    }).catch(errors => {
                        for(let value in errors.response.data.errors){
                            toastr.error(errors.response.data.errors[value]);
                        }
                    });
            }
        },
        mounted(){
            this.logout();
        }
    }
</script>
