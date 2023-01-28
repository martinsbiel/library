<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <h4 class="card-header d-flex"><span class="align-self-center">Gerenciar Livros</span> <button type="button" data-bs-toggle="modal" data-bs-target="#modalBookAdd" class="btn btn-dark btn-lg text-white ms-auto">Adicionar livro</button></h4>

                    <div class="card-body">
                        <v-data-table
                            v-model:items-per-page="itemsPerPage"
                            :headers="headers"
                            :items="books"
                            item-value="name"
                            class="elevation-1"
                        >
                            <template v-slot:item="{ item }">
                                <tr>
                                    <td>{{ item.columns.id }}</td>
                                    <td>{{ item.columns.name }}</td>
                                    <td>{{ item.columns.author }}</td>
                                    <td>{{ item.columns.status == 0 ? 'Emprestado' : 'Disponível' }}</td>
                                    <td>{{ item.raw.genre === null ? '-' : item.raw.genre.name }}</td>
                                    <td>{{ item.columns.created_at }}</td>
                                    <td>{{ item.columns.updated_at }}</td>
                                    <td>
                                        <v-icon
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalBookUpdate"
                                            icon="mdi-pencil"
                                            size="large"
                                            @click="$store.dispatch('saveItem', item.raw);"
                                        />
                                        &nbsp;
                                        <v-icon
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalBookDelete"
                                            icon="mdi-delete"
                                            size="large"
                                            @click="$store.dispatch('saveItem', item.raw);setGenre(item.raw.genre.name)"
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

    <modal-component id="modalBookDelete" title="Deletar livro">
        <template v-slot:content>
            <p>Revise os dados antes de excluir:</p>
            <div class="form-group mb-4">
                <label class="form-label" for="nameRemove">Nome:</label>
                <input class="form-control" type="text" name="nameRemove" id="nameRemove" placeholder="Nome do livro" v-model="$store.state.item.name" disabled>
            </div>

            <div class="form-group mb-4">
                <label class="form-label" for="authorRemove">Autor:</label>
                <input class="form-control" type="text" name="authorRemove" id="authorRemove" placeholder="Autor do livro" v-model="$store.state.item.author" disabled>
            </div>

            <div class="form-group mb-4">
                <label class="form-label" for="statusRemove">Status:</label>
                <input class="form-control" type="text" name="statusRemove" id="statusRemove" placeholder="Status do livro" :value="$store.state.item.status === 1 ? 'Disponível' : 'Emprestado'" disabled>
            </div>

            <div class="form-group mb-4">
                <label class="form-label" for="genreRemove">Gênero:</label>
                <input class="form-control" type="text" name="genreRemove" id="genreRemove" placeholder="Gênero do livro" v-model="genreName" disabled>
            </div>

            <div class="form-group mb-4">
                <label class="form-label" for="dateRemove">Data de cadastro:</label>
                <input class="form-control" type="text" name="dateRemove" id="dateRemove" placeholder="Data de cadastro" :value="$store.state.item.created_at" disabled>
            </div>

            <div v-if="$store.state.item.updated_at != $store.state.item.created_at" class="form-group">
                <label class="form-label" for="dateUpRemove">Data da última atualização:</label>
                <input class="form-control" type="text" name="dateUpRemove" id="dateUpRemove" placeholder="Data da última atualização" :value="$store.state.item.updated_at" disabled>
            </div>
        </template>
        <template v-slot:footer>
            <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Fechar</button>
            <button type="button" class="btn btn-danger text-white" @click="remove()">Remover</button>
        </template>
    </modal-component>

    <modal-component id="modalBookUpdate" title="Atualizar livro">
        <template v-slot:content>
            <div class="form-group mb-4">
                <label class="form-label" for="nameUpdate">Nome:</label>
                <input class="form-control" type="text" name="nameUpdate" id="nameUpdate" placeholder="Nome do livro" v-model="$store.state.item.name">
            </div>

            <div class="form-group mb-4">
                <label class="form-label" for="authorUpdate">Autor:</label>
                <input class="form-control" type="text" name="authorUpdate" id="authorUpdate" placeholder="Autor do livro" v-model="$store.state.item.author">
            </div>

            <div class="form-group mb-4">
                <label class="form-label" for="authorUpdate">Status:</label>
                <select class="form-select" name="statusUpdate" id="statusUpdate" v-model="$store.state.item.status">
                    <option value="1" selected="{{$store.state.item.status == 1 ? 'selected' : ''}}">Disponível</option>
                    <option value="0">Emprestado</option>
                </select>
            </div>

            <div class="form-group mb-4">
                <label class="form-label" for="genreUpdate">Gênero:</label>
                <select class="form-select" name="genreUpdate" id="genreUpdate" v-model="$store.state.item.genre_id">
                        <option v-for="item in genres" :key="item.id" :value="item.id" selected="{{$store.state.item.genre_id == item.id ? 'selected' : ''}}">{{item.name}}</option>
                </select>
            </div>

            <div class="form-group mb-4">
                <label class="form-label" for="dateUpdate">Data de cadastro:</label>
                <input class="form-control" type="text" name="dateUpdate" id="dateUpdate" placeholder="Data de cadastro" :value="$store.state.item.created_at" disabled>
            </div>

            <div v-if="$store.state.item.updated_at != $store.state.item.created_at" class="form-group">
                <label class="form-label" for="dateUpUpdate">Data da última atualização:</label>
                <input class="form-control" type="text" name="dateUpUpdate" id="dateUpUpdate" placeholder="Data da última atualização" :value="$store.state.item.updated_at" disabled>
            </div>
        </template>
        <template v-slot:footer>
            <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Fechar</button>
            <button type="button" class="btn btn-dark text-white" @click="update()">Atualizar</button>
        </template>
    </modal-component>

    <modal-component id="modalBookAdd" title="Adicionar livro">
        <template v-slot:content>
            <div class="form-group mb-4">
                <label class="form-label" for="nameAdd">Nome:</label>
                <input class="form-control" type="text" name="nameAdd" id="nameAdd" placeholder="Nome do livro" v-model="name">
            </div>

            <div class="form-group mb-4">
                <label class="form-label" for="authorAdd">Autor:</label>
                <input class="form-control" type="text" name="authorAdd" id="authorAdd" placeholder="Autor do livro" v-model="author">
            </div>

            <div class="form-group mb-4">
                <label class="form-label" for="statusAdd">Status:</label>
                <select class="form-select" name="statusAdd" id="statusAdd" v-model="status">
                    <option value="" hidden selected>Selecione o status</option>
                    <option value="1">Disponível</option>
                    <option value="0">Emprestado</option>
                </select>
            </div>

            <div class="form-group mb-4">
                <label class="form-label" for="authorAdd">Gênero:</label>
                <select class="form-select" name="genreAdd" id="genreAdd" v-model="genre_id">
                        <option value="" hidden selected>Selecione o gênero</option>
                        <option v-for="item in genres" :key="item.id" :value="item.id">{{item.name}}</option>
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
                url: 'http://localhost:8000/api/v1/books',
                name: '',
                author: '',
                status: '',
                genre_id: '',
                genreName: '',
                itemsPerPage: 10,
                headers: [
                    {title: '#', sortable: true, key: 'id'},
                    {title: 'Nome', sortable: true, key: 'name'},
                    {title: 'Autor', sortable: true, key: 'author'},
                    {title: 'Status', sortable: true, key: 'status'},
                    {title: 'Gênero', sortable: true, key: 'genre.name'},
                    {title: 'Criado em', sortable: true, key: 'created_at'},
                    {title: 'Atualizado em', sortable: true, key: 'updated_at'},
                    {title: 'Ações', sortable: false, key: 'actions'},
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
                axios.get('http://localhost:8000/api/v1/genres')
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
                        toastr.success('Livro cadastrado com sucesso.');
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
                        toastr.success('Livro atualizado com sucesso.');

                        this.getBooks();
                    }).catch(errors => {
                        for(let value in errors.response.data.errors){
                            toastr.error(errors.response.data.errors[value]);

                            this.getBooks();
                        }
                    });
            },
            remove(){
                let confirmation = confirm('Tem certeza que deseja remover esse livro?');

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
                        toastr.error(errors.response.data.error);
                    });
            },
        },
        mounted() {
            this.getBooks();
            this.getGenres();
        },
    }
</script>
