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

import Home from './views/Home.vue';
import Users from './views/Users.vue';
import Books from './views/Books.vue';
import Genres from './views/Genres.vue';
import Loans from './views/Loans.vue';

const routes = [
    { path: '/', component: Home },
    { path: '/users', component: Users },
    { path: '/books', component: Books },
    { path: '/genres', component: Genres },
    { path: '/loans', component: Loans },
]

const router = VueRouter.createRouter({
    history: VueRouter.createWebHashHistory(),
    routes,
});

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});
app.use(router);
app.use(vuetify);

import {createStore} from 'vuex';

const store = createStore({
    state: {
        item: {},
    },
    actions: {
        saveItem(context, payload){
            let item = context.state.item;

            item = payload;
            
            context.commit('SAVE_ITEM', item);
        }
    },
    mutations: {
        SAVE_ITEM(state, payload){
            state.item = payload;
        }
    }
});

app.use(store);

app.config.globalProperties.$moment = moment;

import ExampleComponent from './components/ExampleComponent.vue';
import ModalComponent from './components/ModalComponent.vue';
app.component('example-component', ExampleComponent);
app.component('modal-component', ModalComponent);

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

app.mount('#app');
