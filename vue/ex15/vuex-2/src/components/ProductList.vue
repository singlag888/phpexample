<template>

    <div>
        <h2>Product List</h2>
        <ul>
            <li v-for="product in products">
                <p>{{ product.title }} - {{ product.price }}</p>

                <button
                        :disabled="!product.inventory"
                        @click="addProductToCart(product)">Add to cart
                </button>
            </li>
        </ul>
    </div>
</template>

<script>

    import {mapGetters, mapState, mapActions, mapMutations} from 'vuex'

    export default {
        data: function () {
            return {}
        },
        computed: {
            ...mapState({
                products: state => state.product.allProducts
            })
        },
        methods: mapActions('cart', [
            'addProductToCart'
        ]),
        created() {
            this.$store.commit('product/getAllProduct')
        }
    }
</script>

<style>

</style>