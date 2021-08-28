const state = {
    personnels: []
};

const getters = {
    personnels: state => state.personnels,
};

const actions = {
    async getPersonnels({ commit }) {
        await axios.get('/personnels').then(response => {
            commit("FETCH_ALL_PERSONNELS", response.data);
        });
    },
    async managePersonnel({ commit, dispatch }, form) {
        await axios.post(`manage_personnel/${form.id ?? ""}`, form)
            .then(response => {
                commit('SET_REQUEST_RESPONSE', { status: 'success', message: 'Personnel record has been successfully saved!' })
                dispatch("getPersonnels");
            }).catch(error=>{
                commit('SET_REQUEST_RESPONSE', { status: 'failed', message: 'Error has been occur, Failed to save the record!' })
            });
    }
};

const mutations = {
    FETCH_ALL_PERSONNELS: (state, personnels) => {
        state.personnels = personnels
    },
};

export default {
    state,
    getters,
    actions,
    mutations
};
