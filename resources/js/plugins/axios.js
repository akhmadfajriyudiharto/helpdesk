import Vue from 'vue';
import axios from 'axios';

axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['X-CSRF-TOKEN'] = document.head.querySelector('meta[name="csrf-token"]').content;
if (window.app.url) {
    axios.defaults.baseURL = window.app.url;
}
if (localStorage.getItem('token')) {
    axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token');
}
axios.interceptors.response.use(function (response) {
    return response;
}, function (error) {
    if (error.response.status === 401) {
        // If error 401 redirect to login
        window.location.href = window.app.url + '/auth/login';
        delete window.axios.defaults.headers.common.Authorization;
        localStorage.removeItem('token');
        throw new Error('Unauthorized');
    } else if (error.response.data.message) {
        // If it is a notification error, display message
        Ladda.stopAll();
        let message = error.response.data.message;
        if (error.response.data.errors) {
            message = '<ul class="text-left">';
            Object.keys(error.response.data.errors).forEach(function (element) {
                error.response.data.errors[element].forEach(function (item) {
                    message += '<li>' + item + '</li>';
                });
            });
            message += '</ul>';
        }
        Vue.notify({title: 'Error', text: message, type: 'error'});
        throw new Error(error.response.data.message);
    } else {
        // If it is an uncontrolled error, display http status
        Ladda.stopAll();
        Vue.notify({title: 'Error ' + error.response.status, text: error.response.statusText, type: 'error'});
        throw new Error(error);
    }
});

window.axios = axios;
