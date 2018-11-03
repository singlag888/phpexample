import shop from '../../../api/shop'

const state = {
    allProducts: []
}


const getters = {}

const mutations = {
    getAllProduct(state) {
        shop.getProducts(products => state.allProducts = products)
    },
    decrementProductInventory(state, {id}) {
        const product = state.allProducts.find(product => product.id === id)
        product.inventory--
    }
}

const actions = {}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}