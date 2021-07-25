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
            ]
        }
    ]
});

function authenticated (to, from, next) {
    axios.get('check_auth').then((response) => {
        //console.log('then before enter', response)
        next()
    }).catch(async(error) => {
        //console.log('before enter err', error)
        await store.commit("UNSET_AUTH")
        alert(`${document.title.toUpperCase()}\n• Session expired please re-login your credential to avoid any error!`)
        location.assign(location.origin.concat('/login'))
        next()
    });
}

export default routes
