import Vue from "vue";
import store from './../store'

// Vue.prototype.$appName = "nameHere";
Vue.prototype.$hasAccessTo = function(param='') {
    if (Object.entries(store?.getters?.auth || [])?.length) {
        var permit = store?.getters?.auth?.roles?.reduce((permits, role)=>{
            role?.permissions?.forEach(p => {
                if (!permits?.includes(p?.name)) {
                    if (!permits?.includes(p?.name?.split('-')[1])) {
                        permits?.push(p?.name?.split('-')[1])
                    }
                    permits?.push(p?.name)
                }
            });
            return permits
        }, [])
        return typeof param == 'string' ? permit?.includes(param) : param?.some(p=>permit?.includes(p))
    }
    return false
}