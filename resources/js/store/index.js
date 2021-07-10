import patients from "./modules/patients";
import users from "./modules/users";
import createPersistedState from "vuex-persistedstate";

import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store =  new Vuex.Store({
    modules: {
        strict: process.env.NODE_ENV !== "production",
        users,
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