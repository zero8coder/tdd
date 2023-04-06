/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.$ = window.jQuery = require('jquery');

import flash from "./components/Flash.vue";
import thread from "./pages/Thread.vue";
import navview from "./components/NavView.vue";
import replies from './components/Replies';
import newReply from './components/NewReply';
import paginator from './components/Paginator.vue';
import avatarForm from './components/AvatarForm.vue';

const app = Vue.createApp({

});

app.component('flash', flash)
    .component('thread-view', thread)
    .component('replies', replies)
    .component('navview', navview)
    .component('new-reply', newReply)
    .component('paginator', paginator)
    .component('avatar-form', avatarForm)
    .mount('#app');
