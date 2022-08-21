import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        user: false,
        permissions: {},
        settings: false,
    },
    mutations: {
        setSettings(state, data) {
            state.settings = data;
        },
        login(state, response) {
            state.user = response.user;
            state.permissions = response.user.role.permissions;
            localStorage.setItem('token', response.token);
            window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + response.token;
        },
        logout(state) {
            axios.post('api/auth/logout').then(function () {
                state.user = false;
            });
            delete window.axios.defaults.headers.common.Authorization;
            localStorage.removeItem('token');
        },
        setUser(state) {
            if (localStorage.getItem('token')) {
                axios.get('api/auth/user').then(function (response) {
                    state.user = response.data;
                    state.permissions = response.data.role.permissions;
                });
            }
        },
        updateUser(state, response) {
            state.user = response;
            state.permissions = response.role.permissions;
        },
    }
});

export default store;

