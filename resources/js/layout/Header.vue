<template>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Left Side Of Navbar -->
        <ul v-if="$store.state.isAuthenticated" class="navbar-nav mr-auto">
            <li class="nav-item">
                <router-link class="nav-link" to="/">{{ $t('ui.home') }}</router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" to="users">{{ $t('ui.users') }}</router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" to="admins">{{ $t('ui.admins') }}</router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" to="books">{{ $t('ui.books') }}</router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" to="genres">{{ $t('ui.genres') }}</router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" to="loans">{{ $t('ui.loans') }}</router-link>
            </li>
        </ul>

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown mr-5">
                <select class="form-select" id="locale" name="locale" @change="setLocale($event)">
                    <option value="en">English</option>
                    <option value="pt_BR" :selected="$store.state.locale == 'pt_BR'">Português</option>
                </select>
            </li>
            <li v-if="$store.state.isAuthenticated" class="nav-item dropdown">
                <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ $store.state.user.name }}
                </button>
                <ul class="dropdown-menu dropdown-menu-dark">
                    <li><router-link class="dropdown-item" to="change-password">{{ $t('ui.change_pass') }}</router-link></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><router-link class="dropdown-item" to="logout">{{ $t('ui.logout') }}</router-link></li>
                </ul>
            </li>
        </ul>
    </div>
</template>
<script>
import { loadLanguageAsync } from 'laravel-vue-i18n';

    export default {
        methods: {
            setLocale(e){
                loadLanguageAsync(e.target.value);
                localStorage.setItem('locale', e.target.value);
                this.$store.state.locale = e.target.value;
                axios.get(`/api/lang/${e.target.value}`)
                    .then(response => {
                        this.$router.push(this.$router.currentRoute);
                    });
            }
        },
        mounted() {
            this.$store.state.locale = localStorage.getItem('locale');
            loadLanguageAsync(this.$store.state.locale);
        }
    }
</script>