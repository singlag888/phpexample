// import * as state from './state'
import * as getters from './getters'
import mutations from './mutations'
import actions from './actions'

const state = {
    items: [],
    checkoutStatus: null
}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}