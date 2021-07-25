const state = {
    request: {
        status: 'success',
        message: 'none',
    }
};

const getters = {
    request: state => state.request,
};

const actions = {
};

const mutations = {
    SET_REQUEST_RESPONSE: (state, request) => {
        state.request.status = request.status
        state.request.message = request.message
    },
};

export default {
    state,
    getters,
    actions,
    mutations
};
