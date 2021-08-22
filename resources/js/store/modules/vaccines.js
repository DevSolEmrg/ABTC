const state = {
    vaccines: []
};

const getters = {
    vaccines: state => state.vaccines,
};

const actions = {
    async getVaccines({ commit }) {
        await axios.get('/vaccines').then(response => {
            commit("FETCH_ALL_VACCINES", response.data);
        });
    },
    async manageVaccines({ commit, dispatch }, form) {
        await axios.post(`manage_vaccines/${form.id ?? ""}`, form)
            .then(response => {
                commit('SET_REQUEST_RESPONSE', { status: 'success', message: 'Patient record has been successfully saved!' })
                //console.log('manage vaccines response:', response)
                dispatch("getVaccines");
            }).catch(error=>{
                commit('SET_REQUEST_RESPONSE', { status: 'failed', message: 'Error has been occur, Failed to save the record!' })
            });
    }
};

const mutations = {
    FETCH_ALL_VACCINES: (state, vaccines) => {
        state.vaccines = vaccines
    },
    // SET_AUTH_USER: (state, user) => {
    //     state.auth_user = user
    // },
};

export default {
    state,
    getters,
    actions,
    mutations
};
