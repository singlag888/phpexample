<template>
    <div>
        <h2>Your Cart</h2>
        <p v-show="!products.length">Please add some products to cart</p>
        <ul>
            <li v-for="product in products">
                {{ product.title }} - {{ product.price }}
            </li>
        </ul>
        <p>Total: {{ total }}</p>
        <p>
            <button :disabled="!products.length" @click="checkout(products)">Checkout</button>
        </p>
        <p v-show="checkoutStatus">Checkout {{ checkoutStatus }}.</p>
    </div>
</template>

<script>

    import {mapGetters, mapState, mapActions} from 'vuex'

    export default {
        data: function () {
            return {}
        },
        computed: {
            ...mapState({
                checkoutStatus: state => state.cart.checkoutStatus
            }),
            ...mapGetters('cart', {
                products: 'cartProducts',
                total: 'cartToTotalPrice',
            })
        },
        methods: {
            ...mapActions('cart', {
                checkout: 'checkout'
            })
        }
    }
</script>

<style>

</style>