const state = {
    loading_component: false
};

const getters = {
    loading_component: state => state.loading_component,
};

const actions = {
};

const mutations = {
    SET_LOADING_COMPONENT: (state, status) => {
        state.loading_component = status
    }
};

export default {
    state,
    getters,
    actions,
    mutations
};