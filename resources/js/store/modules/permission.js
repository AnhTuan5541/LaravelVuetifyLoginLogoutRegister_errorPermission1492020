
const state = {
    permissions: []
};
const getters = {};
const actions = {
    getPermissions( {commit} ) {
        axios.get('api/v1/permission/all')
        .then( response => {
            commit('setPermissions', response.data);
        })
    },
};
const mutations = {
    setPermissions( state, data) {
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