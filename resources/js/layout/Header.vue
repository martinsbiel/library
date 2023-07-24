<template>
    <div v-if="$store.state.isAuthenticated" class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Left Side Of Navbar -->
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <router-link class="nav-link" to="/">Início</router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" to="users">Usuários</router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" to="admins">Administradores</router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" to="books">Livros</router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" to="genres">Gêneros</router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" to="loans">Empréstimos</router-link>
            </li>
        </ul>

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ $store.state.user.name }}
                </button>
                <ul class="dropdown-menu dropdown-menu-dark">
                    <li><a class="dropdown-item" href="#">Alterar senha</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><router-link class="dropdown-item" to="logout">Sair</router-link></li>
                </ul>
            </li>
        </ul>
    </div>
</template>
<script>
    export default {
        mounted() {
            
        }
    }
</script>