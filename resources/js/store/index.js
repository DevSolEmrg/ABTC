import patients from "./modules/patients";
import users from "./modules/users";
import medicines from "./modules/medicines";
import createPersistedState from "vuex-persistedstate";
import request from "./modules/request";
import loader from "./modules/loader";

import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store =  new Vuex.Store({
    modules: {
        strict: process.env.NODE_ENV !== "production",
        users,
        patients,
        request,
        loader,
        medicines
    },
    plugins: [
        createPersistedState({
            key: "state",
            reducer (val) {
                if (!val.users.auth) {
                    return {}
                }
                return val
            },
            storage: window.localStorage
        })
    ]
})

export default store