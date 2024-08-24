<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <h4 class="card-header d-flex"><span class="align-self-center">{{ $t('loan.manage') }}</span> <button type="button" data-bs-toggle="modal" data-bs-target="#modalLoanAdd" class="btn btn-dark btn-lg text-white ms-auto">{{ $t('loan.add') }}</button></h4>

                    <div class="card-body">
                        <v-data-table
                            v-model:items-per-page="itemsPerPage"
                            :headers="headers"
                            :items="loans"
                            item-value="name"
                            class="elevation-1"
                        >
                            <template v-slot:item="{ item }">
                                <tr>
                                    <td>{{ item.id }}</td>
                                    <td>{{ item.target_date }}</td>
                                    <td>{{ item.user === null ? '-' : item.user.name }}</td>
                                    <td>{{ item.book === null ? '-' : item.book.name }}</td>
                                    <td>{{ item.delayed ? $t('ui.overdue') : $t('ui.on_time') }}</td>
                                    <td>{{ item.returned ? $t('ui.returned') : $t('ui.loaned') }}</td>
                                    <td>{{ item.created_at }}</td>
                                    <td>
                                        <v-icon
                                            v-show="!item.returned"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalLoanSetStatus"
                                            icon="mdi-check"
                                            size="large"
                                            @click="$store.dispatch('saveItem', item);setBook(item.book === null ? '-' : item.book.name);setUser(item.user === null ? '-' : item.user.name);"
                                        />
                                        &nbsp;
                                        <v-icon
                                            v-show="!item.returned"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalLoanSetStatus"
                                            icon="mdi-calendar"
                                            size="large"
                                            @click="$store.dispatch('saveItem', item);setBook(item.book === null ? '-' : item.book.name);setUser(item.user === null ? '-' : item.user.name);"
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

    <modal-component id="modalLoanSetStatus" :title="$t('loan.modify')">
        <template v-slot:content>
            <p>{{ $t('loan.review') }}:</p>
            <div class="form-group mb-4">
                <label class="form-label" for="dateRemove">{{ $t('ui.return_date') }}:</label>
                <input class="form-control" type="text" name="dateRemove" id="dateRemove" v-model="$store.state.item.target_date" disabled>
            </div>

            <div class="form-group mb-4">
                <label class="form-label" for="userRemove">{{ $t('ui.user') }}:</label>
                <input class="form-control" type="text" name="userRemove" id="userRemove" v-model="userName" disabled>
            </div>

            <div class="form-group mb-4">
                <label class="form-label" for="bookRemove">{{ $t('ui.book') }}:</label>
                <input class="form-control" type="text" name="bookRemove" id="bookRemove" v-model="bookName" disabled>
            </div>

            <div class="form-group mb-4">
                <label class="form-label" for="dateRemove">{{ $t('ui.registration_date') }}:</label>
                <input class="form-control" type="text" name="dateRemove" id="dateRemove" :value="$store.state.item.created_at" disabled>
            </div>
        </template>
        <template v-slot:footer>
            <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">{{ $t('ui.close') }}</button>
            <button type="button" class="btn btn-danger text-white" @click="setDelayed()">{{ $t('ui.overdue') }}</button>
            <button type="button" class="btn btn-success text-white" @click="setReturned()">{{ $t('ui.return') }}</button>
        </template>
    </modal-component>

    <modal-component id="modalLoanAdd" :title="$t('loan.add')">
        <template v-slot:content>
            <div class="form-group mb-4">
                <label class="form-label" for="dateAdd">{{ $t('ui.return_date') }}:</label>
                <input class="form-control" type="date" name="dateAdd" id="dateAdd" :placeholder="$t('ui.return_date')" v-model="target_date">
            </div>

            <div class="form-group mb-4">
                <label class="form-label" for="bookAdd">{{ $t('ui.book') }}:</label>
                <select class="form-select" name="bookAdd" id="bookAdd" v-model="book_id">
                        <option value="" hidden selected>{{ $t('ui.select_book') }}</option>
                        <option v-for="item in books" :key="item.id" :value="item.id">{{item.name}}</option>
                </select>
            </div>

            <div class="form-group mb-4">
                <label class="form-label" for="userAdd">{{ $t('ui.user') }}:</label>
                <select class="form-select" name="userAdd" id="userAdd" v-model="user_id">
                        <option value="" hidden selected>{{ $t('ui.select_user') }}</option>
                        <option v-for="item in users" :key="item.id" :value="item.id">{{item.name}}</option>
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
                url: '/api/v1/loans',
                target_date: '',
                user_id: '',
                book_id: '',
                userName: '',
                bookName: '',
                itemsPerPage: 10,
                headers: [
                    {title: '#', sortable: true, key: 'id'},
                    {title: trans('ui.return_date'), sortable: true, key: 'target_date'},
                    {title: trans('ui.user'), sortable: true, key: 'user.name'},
                    {title: trans('ui.book'), sortable: true, key: 'book.name'},
                    {title: trans('ui.return_status'), sortable: true, key: 'delayed'},
                    {title: trans('ui.status'), sortable: true, key: 'returned'},
                    {title: trans('ui.created_at'), sortable: true, key: 'created_at'},
                    {title: trans('ui.actions'), sortable: false, key: 'actions'},
                ],
                loans: [],
                books: [],
                users: []
            }
        },
        methods: {
            setUser(user){
                this.userName = user;
            },
            setBook(book){
                this.bookName = book;
            },
            getBooks(){
                axios.get('/api/v1/books')
                    .then(response => {
                        this.books = response.data;
                    });
            },
            getUsers(){
                axios.get('/api/v1/users')
                    .then(response => {
                        this.users = response.data;
                    });
            },
            getLoans(){
                axios.get(this.url)
                    .then(response => {
                        this.loans = response.data;

                        this.loans.map(index => {
                            index.target_date = this.$moment(index.target_date).format('D/M/Y');
                            index.created_at = this.$moment(index.created_at).format('D/M/Y H:mm:ss');
                        });
                    });
            },
            create(){
                let formData = new FormData();
                formData.append('target_date', this.target_date);
                formData.append('user_id', this.user_id);
                formData.append('book_id', this.book_id);

                axios.post(this.url, formData)
                    .then(response => {
                        toastr.success(trans('loan.added'));
                        this.target_date = '';
                        this.user_id = '';
                        this.book_id = '';
                        
                        this.getLoans();
                    }).catch(errors => {
                        for(let value in errors.response.data.errors){
                            toastr.error(errors.response.data.errors[value]);
                        }
                    });
            },
            setReturned(){
                let formData = new FormData();
                formData.append('_method', 'patch');

                axios.post(this.url + '/set-returned/' + this.$store.state.item.id, formData)
                    .then(response => {
                        toastr.success(trans('book.returned'));

                        this.getLoans();
                    }).catch(errors => {
                        for(let value in errors.response.data.errors){
                            toastr.error(errors.response.data.errors[value]);

                            this.getLoans();
                        }
                    });
            },
            setDelayed(){
                let formData = new FormData();
                formData.append('_method', 'patch');

                axios.post(this.url + '/set-delayed/' + this.$store.state.item.id, formData)
                    .then(response => {
                        toastr.success(trans('loan.overdue'));

                        this.getLoans();
                    }).catch(errors => {
                        for(let value in errors.response.data.errors){
                            toastr.error(errors.response.data.errors[value]);

                            this.getLoans();
                        }
                    });
            },
        },
        mounted() {
            this.getLoans();
            this.getBooks();
            this.getUsers();
        },
    }
</script>
