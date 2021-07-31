const state = {
    auth: {},
    recent_route: {}
};

const getters = {
    auth: state => state.auth,
    recent_route: state => state.recent_route,
};

const actions = {
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
    }
};

export default {
    state,
    getters,
    actions,
    mutations
};
