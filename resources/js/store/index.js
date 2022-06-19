import patients from "./modules/patients";
import users from "./modules/users";
import vaccines from "./modules/vaccines";
import personnels from "./modules/personnel";
import roles from "./modules/role";
import enums from "./modules/enum";
import createPersistedState from "vuex-persistedstate";
import request from "./modules/request";
import loader from "./modules/loader";
import dashboard from "./modules/dashboard";

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
        vaccines,
        personnels,
        roles,
        enums,
        dashboard
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