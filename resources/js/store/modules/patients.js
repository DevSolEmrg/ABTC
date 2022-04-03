const state = {
    patients: [],
    selected_patient: [],
    //selected_history: []
    patients_last_reload: new Date().toLocaleString()
};

const getters = {
    patients: state => state.patients,
    selected_patient: state => state.selected_patient,
    patients_last_reload: state => state.patients_last_reload
};

const actions = {
    async getPatients({ commit, dispatch, state }, form) {
        await axios.post('patients?page=' + (form?.page_number || state.patients?.current_page || 1), form).then(response => {
            commit("FETCH_ALL_PATIENTS", response.data);
            commit('SET_LOADING_COMPONENT', false)
            commit('SET_PATIENTS_LAST_RELOAD')

            //on delete if no data on last page go to another page
            if (!!state.patients?.current_page && !form?.page_number && (state.patients?.current_page > response.data?.last_page)) {
                commit('SET_LOADING_COMPONENT', true)
                commit('SET_CURRENT_PAGE_PATIENT', response.data?.last_page);
                dispatch("getPatients")
            }

        });
    },
    async getSelectedPatient({ commit }, form) {
        await axios.post('selected_patient/', form).then(response => {
            commit("UPDATE_PATIENT", {id: form.id, data: response.data});
            commit("SET_SELECTED_PATIENT", response.data);
        });
    },
    async managePatients({ commit, dispatch }, form) {
        await axios.post(`manage_patients/${form.id ?? ""}`, form)
            .then(response => {
                commit('SET_REQUEST_RESPONSE', { status: 'success', message: 'Patient record has been successfully saved!' })
                dispatch("getPatients");
            }).catch(error=>{
                commit('SET_REQUEST_RESPONSE', { status: 'failed', message: 'Error has been occur, Failed to save the patient record!' })
            });
    },
    async importPatients({ commit, dispatch }, form) {
        await axios.post(`import_patients`, form)
            .then(response => {
                console.log(response.data)
            }).catch(error=>{

            });
    },
    async manageTreatment({ commit, dispatch }, form) {
        await axios.post(`manage_treatment/${form.id ?? ""}`, form)
            .then(response => {
                commit('SET_REQUEST_RESPONSE', { status: 'success', message: 'Treatment seesion has been successfully saved!' })
                dispatch('getSelectedPatient', {id: form.patient_id})
                // dispatch("getPatients");
            }).catch(error=>{
                commit('SET_REQUEST_RESPONSE', { status: 'failed', message: 'Error has been occur, Failed to save the treatment session!' })
            });
    },
    async managePatientHistory({ commit, dispatch }, form) {
        return await new Promise((resolve, reject) => {
            axios.post(`manage_patient_history/${form.id ?? ""}`, form)
            .then(response => {
                commit('SET_REQUEST_RESPONSE', { status: 'success', message: 'Patient history has been successfully saved changes!' })
                dispatch('getSelectedPatient', {id: form.patient_id})
                resolve(response)
            }).catch(error=>{
                commit('SET_REQUEST_RESPONSE', { status: 'failed', message: 'Error has been occur, Failed to save the patient history!' })
                reject(error?.response)
            });
        })
    }
};

const mutations = {
    FETCH_ALL_PATIENTS: (state, patients) => {
        state.patients = patients
    },
    UPDATE_PATIENT: (state, param) => {
        const PatientIndex = state.patients.data.findIndex((patient) => patient.id == param.id)
        if (PatientIndex != -1) {
          state.patients.data[PatientIndex] = param.data
          var data = state.patients.data
          state.patients.data = []
          state.patients.data = data
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
    SET_CURRENT_PAGE_PATIENT: (state, page) => {
        state.patients.current_page = page
    },
    SET_PATIENTS_LAST_RELOAD: (state) => {
        state.patients_last_reload = new Date().toLocaleString()
    },
};

export default {
    state,
    getters,
    actions,
    mutations
};
