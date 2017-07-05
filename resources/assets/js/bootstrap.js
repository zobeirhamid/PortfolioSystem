import Vue from 'vue';
import axios from 'axios';
import VueRouter from 'vue-router';
import EventDispatcher from './utilities/EventDispatcher';
import Form from './utilities/Form';
import FileForm from './utilities/FileForm';
import sweetAlert from 'sweetalert';
import VueDragula from 'vue-dragula';
import './models.js';

window.Event = EventDispatcher;
window.Form = Form;
window.FileForm = FileForm;
window.Vue = Vue;
window.axios = axios;
window.sweetAlert = sweetAlert;


Vue.use(VueRouter);
Vue.use(VueDragula);

window.axios.defaults.headers.common = {
    //'X-CSRF-TOKEN': window.Laravel.csrfToken,
    Accept: 'application/json',
    'X-Requested-With': 'XMLHttpRequest'
};
