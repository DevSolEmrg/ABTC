import Vue from 'vue'
import VueRouter from 'vue-router'
import store from './store'
Vue.use(VueRouter)

const routes = new VueRouter({
    base: '/',
    mode: 'history',
    routes: [
        {
            path: '*',
            component: () => import(/* webpackChunkName: "not_found" */ './components/NotFound'),
            name: 'NotFound'
        },
        {
            path: '/home',
            component: () => import(/* webpackChunkName: "auth_container" */ './components/AuthContainer'),
            //beforeEach: authenticated,
            children: [
                {
                    path: '',
                    component: () => import(/* webpackChunkName: "dashboard" */ './components/Dashboard'),
                    name: 'Dashboard',
                    beforeEnter: authenticated,
                },
                {
                    path: 'sample',
                    component: () => import(/* webpackChunkName: "sample_component" */ './components/ExampleComponent'),
                    name: 'Sample',
                    beforeEnter: authenticated,
                },
                {
                    path: 'patient',
                    component: () => import(/* webpackChunkName: "patient_list" */ './components/PatientList'),
                    name: 'Patient List',
                    beforeEnter: authenticated,
                },
                {
                    path: 'vaccine',
                    component: () => import(/* webpackChunkName: "vaccine_list" */ './components/VaccineList'),
                    name: 'Vaccine List',
                    beforeEnter: authenticated,
                },
                {
                    path: 'personnel',
                    component: () => import(/* webpackChunkName: "personnel_list" */ './components/PersonnelList'),
                    name: 'Personnel List',
                    beforeEnter: authenticated,
                },
            ]
        }
    ]
});

function authenticated (to, from, next) {
    let state = localStorage.getItem('state') ? localStorage.getItem('state') : "{}"
    //if (!Object.entries(JSON.parse(state)).length && (from.fullPath != "/" || (from.fullPath == "/" && to.fullPath == "/home") )) {
    if (!Object.entries(JSON.parse(state)).length && from.fullPath != "/") {
        store.commit("UNSET_AUTH")
        alert(`${document.title.toUpperCase()}\n• Session expired please re-login your credential to avoid any error!`)
        location.assign(location.origin.concat('/login'))
        next(false)
    } else {
        axios.get('check_auth').then((response) => {
            next()
        }).catch(async(error) => {
            await store.commit("UNSET_AUTH")
            alert(`${document.title.toUpperCase()}\n• Session expired please re-login your credential to avoid any error!`)
            location.assign(location.origin.concat('/login'))
            next(false)
        });
    }
}

export default routes
