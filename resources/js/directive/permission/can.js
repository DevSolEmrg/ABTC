import store from './../../store'
export default {
    bind(el, binding, vnode) {
        el.style.backgroundColor = 'red'
        if (Object.entries(store?.getters?.auth || [])?.length) {

        }
    },
    inserted(el, binding, vnode, old) {
        if (binding.value === 'remove_only_in_dom') {
            vnode.elm.parentElement.removeChild(vnode.elm)
        }
    }
}