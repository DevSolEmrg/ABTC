const state = {
    auth: {}
};

const getters = {
    auth: state => state.auth,
};

const actions = {
};

const mutations = {
    SET_AUTH: (state, user) => {
        state.auth = user
    }
};

export default {
    state,
    getters,
    actions,
    mutations
};
