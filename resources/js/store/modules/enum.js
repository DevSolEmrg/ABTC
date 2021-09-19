const state = {
    enum: []
};

const getters = {
    enum: state => state.enum,
};

const actions = {
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
