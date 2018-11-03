import shop from '../../../api/shop'

function checkout({commit, state}, products) {
    const savedCartItems = [...state.items]
    commit('setCheckoutStatus', null)
    commit('setCartItems', {items: []})
    shop.buyProducts(
        products,
        () => commit('setCheckoutStatus', 'successful'),
        () => {
            commit('setCheckoutStatus', 'failed')
            commit('setCartItems', {items: savedCartItems})
        }
    )
}

function addProductToCart({state, commit}, product) {
    commit('setCheckoutStatus', null)
    if (product.inventory > 0) {
        const cartItem = state.items.find(item => item.id === product.id)
        if (!cartItem) {
            commit('pushProductToCart', {id: product.id})
        } else {
            commit('incrementItemQuantity', cartItem)
        }
        commit('product/decrementProductInventory', {id: product.id}, {root: true})
    }
}

export default {checkout, addProductToCart}