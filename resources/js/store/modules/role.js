
const state = {
    roles: [],
};
const getters = {};
const actions = {
    getRoles( {commit} ) {
        axios.get('api/v1/role/all')
        .then( response => {
            commit('setRoles', response.data);
        })
    },
};
const mutations = {
    setRoles( state, data) {
        state.roles = data
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}