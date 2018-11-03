export const cartProducts = (state, getters, rootState) => {
    return state.items.map(({id, quantity}) => {
        const product = rootState.product.allProducts.find(product => product.id === id)
        {
            return {
                title: product.title,
                price: product.price,
                quantity
            }
        }
    })
}

export const cartToTotalPrice = (state, getters) => {
    return getters.cartProducts.reduce((total, product) => {
        return total + product.price * product.quantity
    }, 0)
}