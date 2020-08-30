import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import App from '../views/components/App.vue';
import Contact from '../views/components/Contact.vue';
import UrlNotFound from '../views/components/404.vue';

const routes = [
    { path: '/', redirect: '/contact' },
    { path: '/contact', component: Contact },
    { path: '*', component: UrlNotFound },
];

const router = new VueRouter({
    mode: 'history',
    routes
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});