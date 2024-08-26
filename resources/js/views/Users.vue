<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <h4 class="card-header d-flex"><span class="align-self-center">{{ $t('user.manage') }}</span> 
                        <div class="col-3 align-self-center ml-5">
                            <input class="form-control" type="text" :placeholder="$t('ui.search')" v-model="search">
                        </div>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#modalUserAdd" class="btn btn-dark btn-lg text-white ms-auto">{{ $t('user.add') }}</button></h4>

                    <div class="card-body">
                        <v-data-table
                            :items-per-page="itemsPerPage"
                            :headers="headers"
                            :items="users"
                            item-value="name"
                            class="elevation-1"
                            :search="search"
                            :no-data-text="$t('ui.no_data')"
                            :items-per-page-text="$t('ui.items_per_page')"
                            :page-text="$t('ui.page_text')"
                        >
                            <template v-slot:item="{ item }">
                                <tr>
                                    <td>{{ item.id }}</td>
                                    <td>{{ item.name }}</td>
                                    <td>{{ item.email }}</td>
                                    <td>{{ item.created_at }}</td>
                                    <td>{{ item.updated_at }}</td>
                                    <td>
                                        <v-icon
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalUserUpdate"
                                            icon="mdi-pencil"
                                            size="large"
                                            @click="$store.dispatch('saveItem', item);"
                                        />
                                        &nbsp;
                                        <v-icon
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalUserDelete"
                                            icon="mdi-delete"
                                            size="large"
                                            @click="$store.dispatch('saveItem', item);"
                                        />
                                    </td>
                                </tr>
                            </template>
                        </v-data-table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <modal-component id="modalUserDelete" :title="$t('user.delete')">
        <template v-slot:content>
            <p>{{ $t('ui.review') }}:</p>
            <div class="form-group mb-4">
                <label class="form-label" for="nameRemove">{{ $t('ui.name') }}:</label>
                <input class="form-control" type="text" name="nameRemove" id="nameRemove" v-model="$store.state.item.name" disabled>
            </div>

            <div class="form-group mb-4">
                <label class="form-label" for="emailRemove">{{ $t('ui.email') }}:</label>
                <input class="form-control" type="email" name="emailRemove" id="emailRemove" v-model="$store.state.item.email" disabled>
            </div>

            <div class="form-group mb-4">
                <label class="form-label" for="dateRemove">{{ $t('ui.registration_date') }}:</label>
                <input class="form-control" type="text" name="dateRemove" id="dateRemove" :value="$store.state.item.created_at" disabled>
            </div>

            <div v-if="$store.state.item.updated_at != $store.state.item.created_at" class="form-group">
                <label class="form-label" for="dateUpRemove">{{ $t('ui.update_date') }}:</label>
                <input class="form-control" type="text" name="dateUpRemove" id="dateUpRemove" :value="$store.state.item.updated_at" disabled>
            </div>
        </template>
        <template v-slot:footer>
            <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">{{ $t('ui.close') }}</button>
            <button type="button" class="btn btn-danger text-white" @click="remove()">{{ $t('ui.remove') }}</button>
        </template>
    </modal-component>

    <modal-component id="modalUserUpdate" :title="$t('user.update')">
        <template v-slot:content>
            <div class="form-group mb-4">
                <label class="form-label" for="nameUpdate">{{ $t('ui.name') }}:</label>
                <input class="form-control" type="text" name="nameUpdate" id="nameUpdate" :placeholder="$t('ui.name')" v-model="$store.state.item.name">
            </div>

            <div class="form-group mb-4">
                <label class="form-label" for="emailUpdate">{{ $t('ui.email') }}:</label>
                <input class="form-control" type="email" name="emailUpdate" id="emailUpdate" :placeholder="$t('ui.email')" v-model="$store.state.item.email">
            </div>

            <div class="form-group mb-4">
                <label class="form-label" for="dateUpdate">{{ $t('ui.registration_date') }}:</label>
                <input class="form-control" type="text" name="dateUpdate" id="dateUpdate" :value="$store.state.item.created_at" disabled>
            </div>

            <div v-if="$store.state.item.updated_at != $store.state.item.created_at" class="form-group">
                <label class="form-label" for="dateUpUpdate">{{ $t('ui.update_date') }}:</label>
                <input class="form-control" type="text" name="dateUpUpdate" id="dateUpUpdate" :value="$store.state.item.updated_at" disabled>
            </div>
        </template>
        <template v-slot:footer>
            <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">{{ $t('ui.close') }}</button>
            <button type="button" class="btn btn-dark text-white" @click="update()">{{ $t('ui.update') }}</button>
        </template>
    </modal-component>

    <modal-component id="modalUserAdd" :title="$t('user.add')">
        <template v-slot:content>
            <div class="form-group mb-4">
                <label class="form-label" for="nameAdd">{{ $t('ui.name') }}:</label>
                <input class="form-control" type="text" name="nameAdd" id="nameAdd" :placeholder="$t('ui.name')" v-model="name">
            </div>

            <div class="form-group mb-4">
                <label class="form-label" for="emailAdd">{{ $t('ui.email') }}:</label>
                <input class="form-control" type="email" name="emailAdd" id="emailAdd" :placeholder="$t('ui.email')" v-model="email">
            </div>
        </template>
        <template v-slot:footer>
            <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">{{ $t('ui.close') }}</button>
            <button type="button" class="btn btn-dark text-white" @click="create()">{{ $t('ui.register') }}</button>
        </template>
    </modal-component>
</template>

<script>
import { trans } from 'laravel-vue-i18n';

    export default {
        data(){
            return {
                url: '/api/v1/users',
                name: '',
                email: '',
                itemsPerPage: 10,
                search: '',
                headers: [
                    {title: '#', sortable: true, key: 'id'},
                    {title: trans('ui.name'), sortable: true, key: 'name'},
                    {title: trans('ui.email'), sortable: true, key: 'email'},
                    {title: trans('ui.created_at'), sortable: true, key: 'created_at'},
                    {title: trans('ui.updated_at'), sortable: true, key: 'updated_at'},
                    {title: trans('ui.actions'), sortable: false, key: 'actions'},
                ],
                users: []
            }
        },
        methods: {
            getUsers(){
                axios.get(this.url)
                    .then(response => {
                        this.users = response.data;

                        this.users.map(index => {
                            index.created_at = this.$moment(index.created_at).format('D/M/Y H:mm:ss');
                            index.updated_at = this.$moment(index.updated_at).format('D/M/Y H:mm:ss');
                        });
                    });
            },
            create(){
                let formData = new FormData();
                formData.append('name', this.name);
                formData.append('email', this.email);

                axios.post(this.url, formData)
                    .then(response => {
                        toastr.success(trans('user.added'));
                        this.name = '';
                        this.email = '';
                        
                        this.getUsers();
                    }).catch(errors => {
                        for(let value in errors.response.data.errors){
                            toastr.error(errors.response.data.errors[value]);
                        }
                    });
            },
            update(){
                let formData = new FormData();
                formData.append('_method', 'patch');
                formData.append('name', this.$store.state.item.name);
                formData.append('email', this.$store.state.item.email);

                axios.post(this.url + '/' + this.$store.state.item.id, formData)
                    .then(response => {
                        toastr.success(trans('user.updated'));

                        this.getUsers();
                    }).catch(errors => {
                        for(let value in errors.response.data.errors){
                            toastr.error(errors.response.data.errors[value]);

                            this.getUsers();
                        }
                    });
            },
            remove(){
                let confirmation = confirm(trans('user.review'));

                if(!confirmation){
                    return false;
                }

                let formData = new FormData();
                formData.append('_method', 'delete');
                
                axios.post(this.url + '/' + this.$store.state.item.id, formData)
                    .then(response => {
                        toastr.success(response.data.success);

                        this.getUsers();
                    }).catch(errors => {
                        for(let value in errors.response.data.errors){
                            toastr.error(errors.response.data.errors[value]);
                        }
                    });
            },
        },
        mounted() {
            this.getUsers();
        },
    }
</script>
