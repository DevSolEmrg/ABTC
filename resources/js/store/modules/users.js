const state = {
    auth: {},
    recent_route: {},
    all_user: []
};

const getters = {
    auth: state => state.auth,
    recent_route: state => state.recent_route,
    all_user: state => state.all_user,
};

const actions = {
    async getUsers({ commit }) {
        await axios.get('/users').then(response => {
            commit("FETCH_ALL_USERS", response.data);
        });
    },
    async manageUser({ commit, dispatch }, form) {
        await axios.post(`manage_user/${form.id ?? ""}`, form)
            .then(response => {
                commit('SET_REQUEST_RESPONSE', { status: 'success', message: 'User account info has been successfully saved!' })
                dispatch("getUsers");
            }).catch(error=>{
                commit('SET_REQUEST_RESPONSE', { status: 'failed', message: 'Error has been occur, Failed to save the record!' })
            });
    }
};

const mutations = {
    SET_AUTH: (state, user) => {
        state.auth = user
    },
    UNSET_AUTH: (state) => {
        state.auth = null
    },
    SET_RECENT_ROUTE: (state, properties) => {
        state.recent_route = properties
    },
    FETCH_ALL_USERS: (state, users) => {
        state.all_user = users
    }
};

export default {
    state,
    getters,
    actions,
    mutations
};
