import Vue from 'vue'
import VueRouter from 'vue-router'
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
            children: [
                {
                    path: '',
                    component: () => import(/* webpackChunkName: "dashboard" */ './components/Dashboard'),
                    name: 'Dashboard'
                },
                {
                    path: 'sample',
                    component: () => import(/* webpackChunkName: "sample_component" */ './components/ExampleComponent'),
                    name: 'Sample'
                },
                {
                    path: 'patient',
                    component: () => import(/* webpackChunkName: "patient_list" */ './components/PatientList'),
                    name: 'Patient List'
                },
            ]
        }
    ]
})

export default routes
