const state = {
    enum: []
};

const getters = {
    enum: state => state.enum,
};

const actions = {
    async getInstances({ commit }) {
        await axios.get('/instances').then(response => {
            commit("SET_ENUM", response.data);
        });
    },
    async manageInstance({ commit, dispatch }, form) {
        return await new Promise((resolve, reject) => {
            axios.post(`manage_instance/${form.id ?? ""}`, form)
            .then(response => {
                commit('SET_REQUEST_RESPONSE', { status: 'success', message: 'App instance record has been successfully saved!' })
                dispatch("getInstances")
                resolve(response)
            }).catch(collected_error=>{
                commit('SET_REQUEST_RESPONSE', { status: 'failed', message: 'Error has been occur, Failed to save the record!' })
                reject(collected_error?.response)
            });
        })
    }
};

const mutations = {
    SET_ENUM: (state, enums) => {
        state.enum = enums
    },
};

export default {
    state,
    getters,
    actions,
    mutations
};
