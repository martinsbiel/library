<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <h4 class="card-header d-flex"><span class="align-self-center">Gerenciar Administradores</span> <button type="button" data-bs-toggle="modal" data-bs-target="#modalAdminAdd" class="btn btn-dark btn-lg text-white ms-auto">Adicionar administrador</button></h4>

                    <div class="card-body">
                        <v-data-table
                            v-model:items-per-page="itemsPerPage"
                            :headers="headers"
                            :items="admins"
                            item-value="name"
                            class="elevation-1"
                        >
                            <template v-slot:item="{ item }">
                                <tr>
                                    <td>{{ item.columns.id }}</td>
                                    <td>{{ item.columns.name }}</td>
                                    <td>{{ item.columns.email }}</td>
                                    <td>{{ item.columns.created_at }}</td>
                                    <td>{{ item.columns.updated_at }}</td>
                                    <td>
                                        <v-icon
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalAdminUpdate"
                                            icon="mdi-pencil"
                                            size="large"
                                            @click="$store.dispatch('saveItem', item.columns);"
                                        />
                                        &nbsp;
                                        <v-icon
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalAdminDelete"
                                            icon="mdi-delete"
                                            size="large"
                                            @click="$store.dispatch('saveItem', item.columns);"
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

    <modal-component id="modalAdminDelete" title="Deletar administrador">
        <template v-slot:content>
            <p>Revise os dados antes de excluir:</p>
            <div class="form-group mb-4">
                <label class="form-label" for="nameRemove">Nome:</label>
                <input class="form-control" type="text" name="nameRemove" id="nameRemove" placeholder="Nome do administrador" v-model="$store.state.item.name" disabled>
            </div>

            <div class="form-group mb-4">
                <label class="form-label" for="emailRemove">Email:</label>
                <input class="form-control" type="email" name="emailRemove" id="emailRemove" placeholder="Email do administrador" v-model="$store.state.item.email" disabled>
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

    <modal-component id="modalAdminUpdate" title="Atualizar administrador">
        <template v-slot:content>
            <div class="form-group mb-4">
                <label class="form-label" for="nameUpdate">Nome:</label>
                <input class="form-control" type="text" name="nameUpdate" id="nameUpdate" placeholder="Nome do administrador" v-model="$store.state.item.name">
            </div>

            <div class="form-group mb-4">
                <label class="form-label" for="emailUpdate">Email:</label>
                <input class="form-control" type="email" name="emailUpdate" id="emailUpdate" placeholder="Email do usuário" v-model="$store.state.item.email">
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

    <modal-component id="modalAdminAdd" title="Adicionar administrador">
        <template v-slot:content>
            <div class="form-group mb-4">
                <label class="form-label" for="nameAdd">Nome:</label>
                <input class="form-control" type="text" name="nameAdd" id="nameAdd" placeholder="Nome do administrador" v-model="name">
            </div>

            <div class="form-group mb-4">
                <label class="form-label" for="emailAdd">Email:</label>
                <input class="form-control" type="email" name="emailAdd" id="emailAdd" placeholder="Email do administrador" v-model="email">
            </div>

            <div class="form-group mb-4">
                <label class="form-label" for="passwordAdd">Senha:</label>
                <input class="form-control" type="password" name="passwordAdd" id="passwordAdd" placeholder="Senha do administrador" v-model="password">
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
                url: '/api/v1/admins',
                name: '',
                email: '',
                password: '',
                itemsPerPage: 10,
                headers: [
                    {title: '#', sortable: true, key: 'id'},
                    {title: 'Nome', sortable: true, key: 'name'},
                    {title: 'Email', sortable: true, key: 'email'},
                    {title: 'Criado em', sortable: true, key: 'created_at'},
                    {title: 'Atualizado em', sortable: true, key: 'updated_at'},
                    {title: 'Ações', sortable: false, key: 'actions'},
                ],
                admins: []
            }
        },
        methods: {
            getAdmins(){
                axios.get(this.url)
                    .then(response => {
                        this.admins = response.data;

                        this.admins.map(index => {
                            index.created_at = this.$moment(index.created_at).format('D/M/Y H:mm:ss');
                            index.updated_at = this.$moment(index.updated_at).format('D/M/Y H:mm:ss');
                        });
                    });
            },
            create(){
                let formData = new FormData();
                formData.append('name', this.name);
                formData.append('email', this.email);
                formData.append('password', this.password);

                axios.post(this.url, formData)
                    .then(response => {
                        toastr.success('Administrador cadastrado com sucesso.');
                        this.name = '';
                        this.email = '';
                        this.password = '';
                        
                        this.getAdmins();
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
                        toastr.success('Administrador atualizado com sucesso.');

                        this.getAdmins();

                        // in case admin updated themself
                        this.$store.dispatch('me');
                    }).catch(errors => {
                        for(let value in errors.response.data.errors){
                            toastr.error(errors.response.data.errors[value]);

                            this.getAdmins();
                        }
                    });
            },
            remove(){
                let confirmation = confirm('Tem certeza que deseja remover esse administrador?');

                if(!confirmation){
                    return false;
                }

                let formData = new FormData();
                formData.append('_method', 'delete');
                
                axios.post(this.url + '/' + this.$store.state.item.id, formData)
                    .then(response => {
                        toastr.success(response.data.success);

                        this.getAdmins();
                    }).catch(errors => {
                        for(let value in errors.response.data.errors){
                            toastr.error(errors.response.data.errors[value]);
                        }
                    });
            },
        },
        mounted() {
            this.getAdmins();
        },
    }
</script>
