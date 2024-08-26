<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <h4 class="card-header d-flex"><span class="align-self-center">{{ $t('book.manage') }}</span> 
                        <div class="col-3 align-self-center ml-5">
                            <input class="form-control" type="text" :placeholder="$t('ui.search')" v-model="search">
                        </div>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#modalBookAdd" class="btn btn-dark btn-lg text-white ms-auto">{{ $t('book.add') }}</button></h4>

                    <div class="card-body">
                        <v-data-table
                            v-model:items-per-page="itemsPerPage"
                            :headers="headers"
                            :items="books"
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
                                    <td>{{ item.author }}</td>
                                    <td>{{ item.status == 0 ? $t('ui.loaned') : $t('ui.available') }}</td>
                                    <td>{{ item.genre === null ? '-' : item.genre.name }}</td>
                                    <td>{{ item.created_at }}</td>
                                    <td>{{ item.updated_at }}</td>
                                    <td>
                                        <v-icon
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalBookUpdate"
                                            icon="mdi-pencil"
                                            size="large"
                                            @click="$store.dispatch('saveItem', item);"
                                        />
                                        &nbsp;
                                        <v-icon
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalBookDelete"
                                            icon="mdi-delete"
                                            size="large"
                                            @click="$store.dispatch('saveItem', item);setGenre(item.genre.name)"
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

    <modal-component id="modalBookDelete" :title="$t('book.delete')">
        <template v-slot:content>
            <p>{{ $t('ui.review') }}:</p>
            <div class="form-group mb-4">
                <label class="form-label" for="nameRemove">{{ $t('ui.name') }}:</label>
                <input class="form-control" type="text" name="nameRemove" id="nameRemove" v-model="$store.state.item.name" disabled>
            </div>

            <div class="form-group mb-4">
                <label class="form-label" for="authorRemove">{{ $t('ui.author') }}:</label>
                <input class="form-control" type="text" name="authorRemove" id="authorRemove" v-model="$store.state.item.author" disabled>
            </div>

            <div class="form-group mb-4">
                <label class="form-label" for="statusRemove">{{ $t('ui.status') }}:</label>
                <input class="form-control" type="text" name="statusRemove" id="statusRemove" :value="$store.state.item.status === 1 ? $t('ui.available') : $t('ui.loaned')" disabled>
            </div>

            <div class="form-group mb-4">
                <label class="form-label" for="genreRemove">{{ $t('ui.genre') }}:</label>
                <input class="form-control" type="text" name="genreRemove" id="genreRemove" v-model="genreName" disabled>
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

    <modal-component id="modalBookUpdate" :title="$t('book.update')">
        <template v-slot:content>
            <div class="form-group mb-4">
                <label class="form-label" for="nameUpdate">{{ $t('ui.name') }}:</label>
                <input class="form-control" type="text" name="nameUpdate" id="nameUpdate" :placeholder="$t('ui.name')" v-model="$store.state.item.name">
            </div>

            <div class="form-group mb-4">
                <label class="form-label" for="authorUpdate">{{ $t('ui.author') }}:</label>
                <input class="form-control" type="text" name="authorUpdate" id="authorUpdate" :placeholder="$t('ui.author')" v-model="$store.state.item.author">
            </div>

            <div class="form-group mb-4">
                <label class="form-label" for="authorUpdate">{{ $t('ui.status') }}:</label>
                <select class="form-select" name="statusUpdate" id="statusUpdate" v-model="$store.state.item.status">
                    <option value="1" selected="{{$store.state.item.status == 1 ? 'selected' : ''}}">{{ $t('ui.available') }}</option>
                    <option value="0">{{ $t('ui.loaned') }}</option>
                </select>
            </div>

            <div class="form-group mb-4">
                <label class="form-label" for="genreUpdate">{{ $t('ui.genre') }}:</label>
                <select class="form-select" name="genreUpdate" id="genreUpdate" v-model="$store.state.item.genre_id">
                        <option v-for="item in genres" :key="item.id" :value="item.id" selected="{{$store.state.item.genre_id == item.id ? 'selected' : ''}}">{{item.name}}</option>
                </select>
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

    <modal-component id="modalBookAdd" :title="$t('book.add')">
        <template v-slot:content>
            <div class="form-group mb-4">
                <label class="form-label" for="nameAdd">{{ $t('ui.name') }}:</label>
                <input class="form-control" type="text" name="nameAdd" id="nameAdd" :placeholder="$t('ui.name')" v-model="name">
            </div>

            <div class="form-group mb-4">
                <label class="form-label" for="authorAdd">{{ $t('ui.author') }}:</label>
                <input class="form-control" type="text" name="authorAdd" id="authorAdd" :placeholder="$t('ui.author')" v-model="author">
            </div>

            <div class="form-group mb-4">
                <label class="form-label" for="statusAdd">{{ $t('ui.status') }}:</label>
                <select class="form-select" name="statusAdd" id="statusAdd" v-model="status">
                    <option value="" hidden selected>{{ $t('ui.select_status') }}</option>
                    <option value="1">{{ $t('ui.available') }}</option>
                    <option value="0">{{ $t('ui.loaned') }}</option>
                </select>
            </div>

            <div class="form-group mb-4">
                <label class="form-label" for="authorAdd">{{ $t('ui.genre') }}:</label>
                <select class="form-select" name="genreAdd" id="genreAdd" v-model="genre_id">
                        <option value="" hidden selected>{{ $t('ui.select_genre') }}</option>
                        <option v-for="item in genres" :key="item.id" :value="item.id">{{item.name}}</option>
                </select>
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
                url: '/api/v1/books',
                name: '',
                author: '',
                status: '',
                genre_id: '',
                genreName: '',
                itemsPerPage: 10,
                search: '',
                headers: [
                    {title: '#', sortable: true, key: 'id'},
                    {title: trans('ui.name'), sortable: true, key: 'name'},
                    {title: trans('ui.author'), sortable: true, key: 'author'},
                    {title: trans('ui.status'), sortable: true, key: 'status'},
                    {title: trans('ui.genre'), sortable: true, key: 'genre.name'},
                    {title: trans('ui.created_at'), sortable: true, key: 'created_at'},
                    {title: trans('ui.updated_at'), sortable: true, key: 'updated_at'},
                    {title: trans('ui.actions'), sortable: false, key: 'actions'},
                ],
                books: [],
                genres: []
            }
        },
        methods: {
            setGenre(genre){
                this.genreName = genre;
            },
            getGenres(){
                axios.get('/api/v1/genres')
                    .then(response => {
                        this.genres = response.data;
                    });
            },
            getBooks(){
                axios.get(this.url)
                    .then(response => {
                        this.books = response.data;

                        this.books.map(index => {
                            index.created_at = this.$moment(index.created_at).format('D/M/Y H:mm:ss');
                            index.updated_at = this.$moment(index.updated_at).format('D/M/Y H:mm:ss');
                        });
                    });
            },
            create(){
                let formData = new FormData();
                formData.append('name', this.name);
                formData.append('author', this.author);
                formData.append('status', parseInt(this.status));
                formData.append('genre_id', this.genre_id);

                axios.post(this.url, formData)
                    .then(response => {
                        toastr.success(trans('book.added'));
                        this.name = '';
                        this.author = '';
                        this.status = '';
                        this.genre_id = '';
                        
                        this.getBooks();
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
                formData.append('author', this.$store.state.item.author);
                formData.append('status', parseInt(this.$store.state.item.status));
                formData.append('genre_id', this.$store.state.item.genre_id);

                axios.post(this.url + '/' + this.$store.state.item.id, formData)
                    .then(response => {
                        toastr.success(trans('book.updated'));

                        this.getBooks();
                    }).catch(errors => {
                        for(let value in errors.response.data.errors){
                            toastr.error(errors.response.data.errors[value]);

                            this.getBooks();
                        }
                    });
            },
            remove(){
                let confirmation = confirm(trans('book.review'));

                if(!confirmation){
                    return false;
                }

                let formData = new FormData();
                formData.append('_method', 'delete');
                
                axios.post(this.url + '/' + this.$store.state.item.id, formData)
                    .then(response => {
                        toastr.success(response.data.success);

                        this.getBooks();
                    }).catch(errors => {
                        toastr.error(errors.response.data.errors);
                    });
            },
        },
        mounted() {
            this.getBooks();
            this.getGenres();
        },
    }
</script>
