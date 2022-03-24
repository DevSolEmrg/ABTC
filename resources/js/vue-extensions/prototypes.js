import Vue from "vue";
import store from './../store'

// Vue.prototype.$appName = "myName";
// Vue.prototype.$assetsResolution = document.body.clientWidth * devicePixelRatio <= 1920 && document.body.clientHeight * devicePixelRatio <= 1080 ? 1080: 2160
Vue.prototype.$can = function(permissions=null) {
    if (Object.entries(store?.getters?.auth || [])?.length) {
        return store?.getters?.auth.name
    }
    return 'N/A'
}