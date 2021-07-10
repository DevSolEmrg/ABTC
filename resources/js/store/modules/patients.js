const state = {
    patients: []
};

const getters = {
    patients: state => state.patients,
};

const actions = {
    async getPatients({ commit, dispatch }, form) {
        await axios.get('/api/patients').then(response => {
            console.log('get all patients response:', response)
            commit("FETCH_ALL_PATIENTS", response.data);
        });
    },
    async managePatients({ commit, dispatch }, form) {
        await axios.post(`/api/manage_patients/${form.id ?? ""}`, form).then(response => {
            console.log('manage patients response:', response)
            dispatch("getPatients");
        });
    }
};

const mutations = {
    FETCH_ALL_PATIENTS: (state, patients) => {
        state.patients = patients
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
