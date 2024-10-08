/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import * as VueRouter from 'vue-router';
import vuetify from './plugins/vuetify';
import moment from 'moment';
import { i18nVue, loadLanguageAsync } from 'laravel-vue-i18n';

import Home from './views/Home.vue';
import Login from './views/Login.vue';
import ForgotPassword from './views/ForgotPassword.vue';
import ResetPassword from './views/ResetPassword.vue';
import ChangePassword from './views/ChangePassword.vue';
import Logout from './views/Logout.vue';
import Users from './views/Users.vue';
import Admins from './views/Admins.vue';
import Books from './views/Books.vue';
import Genres from './views/Genres.vue';
import Loans from './views/Loans.vue';

const routes = [
    { path: '/', component: Home, meta: {
        auth: true
    }},
    { path: '/login', component: Login },
    { path: '/forgot-password', component: ForgotPassword },
    { path: '/reset-password/:token', component: ResetPassword },
    { path: '/logout', component: Logout, meta: {
        auth: true
    }},
    { path: '/change-password', component: ChangePassword, meta: {
        auth: true
    }},
    { path: '/users', component: Users, meta: {
        auth: true
    }},
    { path: '/admins', component: Admins, meta: {
        auth: true
    }},
    { path: '/books', component: Books, meta: {
        auth: true
    }},
    { path: '/genres', component: Genres, meta: {
        auth: true
    }},
    { path: '/loans', component: Loans, meta: {
        auth: true
    }},
]

const router = VueRouter.createRouter({
    history: VueRouter.createWebHashHistory(),
    routes,
});

router.beforeEach(async(to, from) => {
    const loggedIn = store.state.isAuthenticated;


    if(to.matched.some(record => record.meta.auth) && !loggedIn && to.path !== '/login'){
        return {path: '/login'}
    }
});

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});
app.use(router);
app.use(vuetify);
app.use(i18nVue, {
    resolve: async lang => {
        const langs = import.meta.glob('../../lang/*.json');
        return await langs[`../../lang/php_${lang}.json`]();
    }
})

import {createStore} from 'vuex';

const store = createStore({
    state: {
        item: {},
        isAuthenticated: false,
        locale: '',
        user: []
    },
    actions: {
        saveItem(context, payload){
            let item = context.state.item;

            item = payload;
            
            context.commit('SAVE_ITEM', item);
        },
        saveUser(context, payload){
            let user = context.state.user;

            user = payload;
            
            context.commit('SAVE_USER', user);
        },
        saveLocale(context, payload){
            let locale = context.state.locale;

            locale = payload;

            context.commit('SAVE_LOCALE', locale);
        },
        setAuthenticated(context, payload){
            let status = context.state.isAuthenticated;

            status = payload;

            context.commit('SAVE_STATUS', status);
        },
        me({commit}){
            return axios.get('/api/user').then(response => {
                commit('SAVE_USER', response.data);
                commit('SAVE_STATUS', true);
            }).catch(() => {
                commit('SAVE_STATUS', false);
            });
        }
    },
    mutations: {
        SAVE_ITEM(state, payload){
            state.item = payload;
        },
        SAVE_USER(state, payload){
            state.user = payload;
        },
        SAVE_LOCALE(state, payload){
            state.locale = payload;
        },
        SAVE_STATUS(state, payload){
            state.isAuthenticated = payload;
        }
    }
});

// intercepting requests
axios.interceptors.request.use(
    config => {
        config.headers.Accept = 'application/json';

        let token = `Bearer ${localStorage.getItem('token')}`;

        config.headers.Authorization = token;

        return config;
    },
    error => {
        return Promise.reject(error);
    }
);

// intercepting responses
axios.interceptors.response.use(
    response => {
        return response;
    },
    error => {
        if(error.response.status === 401){
            store.dispatch('setAuthenticated', false);
        }
        return Promise.reject(error);
    }
);

app.use(store);

app.config.globalProperties.$moment = moment;

import ExampleComponent from './components/ExampleComponent.vue';
import ModalComponent from './components/ModalComponent.vue';
import HeaderComponent from './layout/Header.vue';
app.component('example-component', ExampleComponent);
app.component('modal-component', ModalComponent);
app.component('header-component', HeaderComponent);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

store.dispatch('me').then(() => app.mount('#app'));
