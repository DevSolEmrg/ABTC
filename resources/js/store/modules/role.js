const state = {
    roles: []
};

const getters = {
    roles: state => state.roles,
};

const actions = {
    async getRoles({ commit }) {
        await axios.get('/roles').then(response => {
            commit("FETCH_ALL_ROLES", response.data);
        });
    },
    async manageRole({ commit, dispatch }, form) {
        await axios.post(`manage_role/${form.id ?? ""}`, form)
            .then(response => {
                commit('SET_REQUEST_RESPONSE', { status: 'success', message: 'Role record has been successfully saved!' })
                dispatch("getRoles");
            }).catch(error=>{
                commit('SET_REQUEST_RESPONSE', { status: 'failed', message: 'Error has been occur, Failed to save the record!' })
            });
    }
};

const mutations = {
    FETCH_ALL_ROLES: (state, roles) => {
        state.roles = roles
    },
};

export default {
    state,
    getters,
    actions,
    mutations
};
