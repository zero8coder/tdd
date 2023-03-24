/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import flash from "./components/Flash.vue";
import thread from "./pages/Thread.vue";
import navview from "./components/NavView.vue";

const app = Vue.createApp({

});

app.component('flash', flash)
    .component('thread-view', thread)
    .component('navview', navview)
    .mount('#app');
