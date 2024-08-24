<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <h4 class="card-header d-flex"><span class="align-self-center">{{ $t('genre.manage') }}</span> <button type="button" data-bs-toggle="modal" data-bs-target="#modalGenreAdd" class="btn btn-dark btn-lg text-white ms-auto">{{ $t('genre.add') }}</button></h4>

                    <div class="card-body">
                        <v-data-table
                            :items-per-page="itemsPerPage"
                            :headers="headers"
                            :items="genres"
                            item-value="name"
                            class="elevation-1"
                        >
                            <template v-slot:item="{ item }">
                                <tr>
                                    <td>{{ item.id }}</td>
                                    <td>{{ item.name }}</td>
                                    <td>{{ item.created_at }}</td>
                                    <td>{{ item.updated_at }}</td>
                                    <td>
                                        <v-icon
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalGenreUpdate"
                                            icon="mdi-pencil"
                                            size="large"
                                            @click="$store.dispatch('saveItem', item);"
                                        />
                                        &nbsp;
                                        <v-icon
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalGenreDelete"
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

    <modal-component id="modalGenreDelete" :title="$t('genre.delete')">
        <template v-slot:content>
            <p>{{ $t('ui.review') }}:</p>
            <div class="form-group mb-4">
                <label class="form-label" for="nameRemove">{{ $t('ui.genre') }}:</label>
                <input class="form-control" type="text" name="nameRemove" id="nameRemove" v-model="$store.state.item.name" disabled>
            </div>

            <div class="form-group mb-4">
                <label class="form-label" for="dateRemove">{{ $t('ui.registration_date') }}:</label>
                <input class="form-control" type="text" name="dateRemove" id="dateRemove" :value="$store.state.item.created_at" disabled>
            </div>

            <div v-if="$store.state.item.updated_at != $store.state.item.created_at" class="form-group">
                <label class="form-label" for="dateUpUpdate">{{ $t('ui.update_date') }}:</label>
                <input class="form-control" type="text" name="dateUpRemove" id="dateUpRemove" :value="$store.state.item.updated_at" disabled>
            </div>
        </template>
        <template v-slot:footer>
            <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">{{ $t('ui.close') }}</button>
            <button type="button" class="btn btn-danger text-white" @click="remove()">{{ $t('ui.remove') }}</button>
        </template>
    </modal-component>

    <modal-component id="modalGenreUpdate" :title="$t('genre.update')">
        <template v-slot:content>
            <div class="form-group mb-4">
                <label class="form-label" for="nameUpdate">{{ $t('ui.genre') }}:</label>
                <input class="form-control" type="text" name="nameUpdate" id="nameUpdate" :placeholder="$t('ui.genre')" v-model="$store.state.item.name">
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

    <modal-component id="modalGenreAdd" :title="$t('genre.add')">
        <template v-slot:content>
            <div class="form-group mb-4">
                <label class="form-label" for="nameAdd">{{ $t('ui.genre') }}:</label>
                <input class="form-control" type="text" name="nameAdd" id="nameAdd" :placeholder="$t('ui.genre')" v-model="name">
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
                url: '/api/v1/genres',
                name: '',
                itemsPerPage: 10,
                headers: [
                    {title: '#', sortable: true, key: 'id'},
                    {title: trans('ui.name'), sortable: true, key: 'name'},
                    {title: trans('ui.created_at'), sortable: true, key: 'created_at'},
                    {title: trans('ui.updated_at'), sortable: true, key: 'updated_at'},
                    {title: trans('ui.actions'), sortable: false, key: 'actions'},
                ],
                genres: []
            }
        },
        methods: {
            getGenres(){
                axios.get(this.url)
                    .then(response => {
                        this.genres = response.data;

                        this.genres.map(index => {
                            index.created_at = this.$moment(index.created_at).format('D/M/Y H:mm:ss');
                            index.updated_at = this.$moment(index.updated_at).format('D/M/Y H:mm:ss');
                        });
                    });
            },
            create(){
                let formData = new FormData();
                formData.append('name', this.name);

                axios.post(this.url, formData)
                    .then(response => {
                        toastr.success(trans('genre.added'));
                        this.name = '';
                        this.email = '';
                        
                        this.getGenres();
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

                axios.post(this.url + '/' + this.$store.state.item.id, formData)
                    .then(response => {
                        toastr.success(trans('genre.updated'));

                        this.getGenres();
                    }).catch(errors => {
                        for(let value in errors.response.data.errors){
                            toastr.error(errors.response.data.errors[value]);

                            this.getGenres();
                        }
                    });
            },
            remove(){
                let confirmation = confirm(trans('genre.review'));

                if(!confirmation){
                    return false;
                }

                let formData = new FormData();
                formData.append('_method', 'delete');
                
                axios.post(this.url + '/' + this.$store.state.item.id, formData)
                    .then(response => {
                        toastr.success(response.data.success);

                        this.getGenres();
                    }).catch(errors => {
                        toastr.error(errors.response.data.errors);
                    });
            },
        },
        mounted() {
            this.getGenres();
        },
    }
</script>
