import Axios from "axios";
import { data } from "jquery";

const state = {
    user: {},
    permissions: [],
};
const getters = {};
const actions = {
    getUser( {commit} ) {
        axios.get('api/v1/user/current')
        .then( response => {
            commit('setUser', response.data.user);
            commit('setPermission', response.data.user_permission);
        })
    },
    loginUser( {}, user ) {
        axios.post('api/v1/user/login', {
            email: user.email,
            password: user.password
        })
        .then( response => {

            if (response.data.access_token) {
                // Save token
                localStorage.setItem(
                    "LaravelVuetify_token",
                    response.data.access_token
                )
            }

            window.location.replace('/app')
        })
    },
    logoutUser() {
        //Remove token
        localStorage.removeItem("LaravelVuetify_token")

        window.location.replace('/login');
    },
    registerUser( {}, user ) {
        axios.post('api/v1/user/register', {
            name: user.name,
            email: user.email,
            password: user.password,
            confirm_password: user.confirm_password,
        })
        .then( response => {

            window.location.replace('/')
        })
    }
};
const mutations = {
    setUser( state, data) {
        state.user = data
    },
    setPermission( state, data) {
        state.permissions = data
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}