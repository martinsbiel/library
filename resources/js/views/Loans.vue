<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <h4 class="card-header d-flex"><span class="align-self-center">Gerenciar Empréstimos</span> <button type="button" data-bs-toggle="modal" data-bs-target="#modalLoanAdd" class="btn btn-dark btn-lg text-white ms-auto">Adicionar empréstimo</button></h4>

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
                                    <td>{{ item.columns.id }}</td>
                                    <td>{{ item.columns.target_date }}</td>
                                    <td>{{ item.raw.user === null ? '-' : item.raw.user.name }}</td>
                                    <td>{{ item.raw.book === null ? '-' : item.raw.book.name }}</td>
                                    <td>{{ item.columns.delayed ? 'Atrasado' : 'Em dia' }}</td>
                                    <td>{{ item.columns.returned ? 'Devolvido' : 'Emprestado' }}</td>
                                    <td>{{ item.columns.created_at }}</td>
                                    <td>
                                        <v-icon
                                            v-show="!item.columns.returned"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalLoanSetStatus"
                                            icon="mdi-check"
                                            size="large"
                                            @click="$store.dispatch('saveItem', item.raw);setBook(item.raw.book === null ? '-' : item.raw.book.name);setUser(item.raw.user === null ? '-' : item.raw.user.name);"
                                        />
                                        &nbsp;
                                        <v-icon
                                            v-show="!item.columns.returned"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalLoanSetStatus"
                                            icon="mdi-calendar"
                                            size="large"
                                            @click="$store.dispatch('saveItem', item.raw);setBook(item.raw.book === null ? '-' : item.raw.book.name);setUser(item.raw.user === null ? '-' : item.raw.user.name);"
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

    <modal-component id="modalLoanSetStatus" title="Alterar empréstimo">
        <template v-slot:content>
            <p>Revise os dados antes de marcar como devolvido ou atrasado:</p>
            <div class="form-group mb-4">
                <label class="form-label" for="dateRemove">Data para devolução:</label>
                <input class="form-control" type="text" name="dateRemove" id="dateRemove" placeholder="Prazo para devolução" v-model="$store.state.item.target_date" disabled>
            </div>

            <div class="form-group mb-4">
                <label class="form-label" for="userRemove">Usuário:</label>
                <input class="form-control" type="text" name="userRemove" id="userRemove" placeholder="Usuário" v-model="userName" disabled>
            </div>

            <div class="form-group mb-4">
                <label class="form-label" for="bookRemove">Livro:</label>
                <input class="form-control" type="text" name="bookRemove" id="bookRemove" placeholder="Livro emprestado" v-model="bookName" disabled>
            </div>

            <div class="form-group mb-4">
                <label class="form-label" for="dateRemove">Data do empréstimo:</label>
                <input class="form-control" type="text" name="dateRemove" id="dateRemove" placeholder="Data do empréstimo" :value="$store.state.item.created_at" disabled>
            </div>
        </template>
        <template v-slot:footer>
            <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Fechar</button>
            <button type="button" class="btn btn-danger text-white" @click="setDelayed()">Atrasado</button>
            <button type="button" class="btn btn-success text-white" @click="setReturned()">Devolver</button>
        </template>
    </modal-component>

    <modal-component id="modalLoanAdd" title="Adicionar empréstimo">
        <template v-slot:content>
            <div class="form-group mb-4">
                <label class="form-label" for="dateAdd">Data para devolução:</label>
                <input class="form-control" type="date" name="dateAdd" id="dateAdd" placeholder="Data da devolução" v-model="target_date">
            </div>

            <div class="form-group mb-4">
                <label class="form-label" for="bookAdd">Livro:</label>
                <select class="form-select" name="bookAdd" id="bookAdd" v-model="book_id">
                        <option value="" hidden selected>Selecione o livro</option>
                        <option v-for="item in books" :key="item.id" :value="item.id">{{item.name}}</option>
                </select>
            </div>

            <div class="form-group mb-4">
                <label class="form-label" for="userAdd">Usuário:</label>
                <select class="form-select" name="userAdd" id="userAdd" v-model="user_id">
                        <option value="" hidden selected>Selecione o usuário</option>
                        <option v-for="item in users" :key="item.id" :value="item.id">{{item.name}}</option>
                </select>
            </div>
        </template>
        <template v-slot:footer>
            <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Fechar</button>
            <button type="button" class="btn btn-dark text-white" @click="create()">Cadastrar</button>
        </template>
    </modal-component>
</template>

<script>
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
                    {title: 'Data para devolução', sortable: true, key: 'target_date'},
                    {title: 'Usuário', sortable: true, key: 'user.name'},
                    {title: 'Livro', sortable: true, key: 'book.name'},
                    {title: 'Devolução', sortable: true, key: 'delayed'},
                    {title: 'Status', sortable: true, key: 'returned'},
                    {title: 'Criado em', sortable: true, key: 'created_at'},
                    {title: 'Ações', sortable: false, key: 'actions'},
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
                        toastr.success('Empréstimo cadastrado com sucesso.');
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
                        toastr.success('Livro devolvido com sucesso.');

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
                        toastr.success('Empréstimo marcado como atrasado.');

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
