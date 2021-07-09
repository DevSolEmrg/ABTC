import patients from "./modules/patients";
import createPersistedState from "vuex-persistedstate";

import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store =  new Vuex.Store({
    modules: {
        strict: process.env.NODE_ENV !== "production",
        patients,
    },
    plugins: [
        createPersistedState({
            key: "state",
            storage: window.localStorage
        })
    ]
})

export default store