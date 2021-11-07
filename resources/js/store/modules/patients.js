const state = {
    patients: [],
    selected_patient: [],
    //selected_history: []
};

const getters = {
    patients: state => state.patients,
    selected_patient: state => state.selected_patient,
};

const actions = {
    async getPatients({ commit, dispatch }, form) {
        await axios.get('/api/patients').then(response => {
            console.log('get all patients response:', response)
            commit("FETCH_ALL_PATIENTS", response.data);
        });
    },
    async getSelectedPatient({ commit }, form) {
        await axios.post('selected_patient/', form).then(response => {
            commit("UPDATE_PATIENT", {id: form.id, data: response.data});
            console.log("pateint:", response.data)
            commit("SET_SELECTED_PATIENT", response.data);
        });
    },
    async managePatients({ commit, dispatch }, form) {
        await axios.post(`manage_patients/${form.id ?? ""}`, form)
            .then(response => {
                commit('SET_REQUEST_RESPONSE', { status: 'success', message: 'Patient record has been successfully saved!' })
                //console.log('manage patients response:', response)
                dispatch("getPatients");
            }).catch(error=>{
                commit('SET_REQUEST_RESPONSE', { status: 'failed', message: 'Error has been occur, Failed to save the patient record!' })
            });
    },
    async manageTreatment({ commit, dispatch }, form) {
        await axios.post(`manage_treatment/${form.id ?? ""}`, form)
            .then(response => {
                commit('SET_REQUEST_RESPONSE', { status: 'success', message: 'Treatment seesion has been successfully saved!' })
                dispatch('getSelectedPatient', {id: form.patient_id})
                //console.log('manage patients response:', response)
                // dispatch("getPatients");
            }).catch(error=>{
                commit('SET_REQUEST_RESPONSE', { status: 'failed', message: 'Error has been occur, Failed to save the treatment session!' })
            });
    }
};

const mutations = {
    FETCH_ALL_PATIENTS: (state, patients) => {
        state.patients = patients
    },
    UPDATE_PATIENT: (state, param) => {
        const PatientIndex = state.patients.findIndex((patient) => patient.id == param.id)
        if (PatientIndex != -1) {
          state.patients[PatientIndex] = param.data
          var data = state.patients
          state.patients = []
          state.patients = data
        }
    },
    SET_SELECTED_PATIENT: (state, data) => {
        state.selected_patient = data
    },
    // SET_SELECTED_HISTORY: (state, data) => {
    //     state.selected_history = data
    // },
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
