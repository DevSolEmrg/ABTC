const state = {
    medicines: []
};

const getters = {
    medicines: state => state.medicines,
};

const actions = {
    // async getPatients({ commit, dispatch }, form) {
    //     await axios.get('/api/medicines').then(response => {
    //         console.log('get all medicines response:', response)
    //         commit("FETCH_ALL_PATIENTS", response.data);
    //     });
    // },
    // async managePatients({ commit, dispatch }, form) {
    //     await axios.post(`manage_medicines/${form.id ?? ""}`, form)
    //         .then(response => {
    //             commit('SET_REQUEST_RESPONSE', { status: 'success', message: 'Patient record has been successfully saved!' })
    //             //console.log('manage medicines response:', response)
    //             dispatch("getPatients");
    //         }).catch(error=>{
    //             commit('SET_REQUEST_RESPONSE', { status: 'failed', message: 'Error has been occur, Failed to save the patient record!' })
    //         });
    // }
};

const mutations = {
    FETCH_ALL_PATIENTS: (state, medicines) => {
        //state.medicines = medicines
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
