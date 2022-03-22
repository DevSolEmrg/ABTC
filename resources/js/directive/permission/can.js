import store from './../../store'
export default {
    bind(el, binding, vnode) {
        el.style.backgroundColor = 'red'
        if (Object.entries(store?.getters?.auth)?.length) {

        }
    }
}