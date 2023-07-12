<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite('resources/sass/app.scss')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container">
                <router-link class="navbar-brand" to="/">
                    {{ config('app.name', 'Laravel') }}
                </router-link>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

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
                        <li class="nav-item">
                            <router-link class="nav-link link-light" to="logout">Sair</router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <router-view></router-view>
        </main>
    </div>
    @vite('resources/js/app.js')
</body>
</html>