import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        count: 0
    },
    mutations: {
        increment(state) {
            state.count++
        },
        decrement(state) {
            state.count--
        },
        setCount(state, count) {
            state.count = count
        }
    },
    actions: {
        incrementIfOdd({commit, state}) {
            if (state.count % 2 !== 0) {
                commit('increment')
            }
        },
        incrementAsync({commit}) {
            setTimeout(() => {
                commit('increment')
            }, 1000)
        }
    },
    getters: {
        evenOrOdd: function (state) {
            return state.count % 2 === 0 ? 'even' : 'odd'
        }
    }
})
