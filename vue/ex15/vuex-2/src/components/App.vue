<template>
    <div id="app">
        <h1>Shopping Example</h1>
        <!--<img alt="Vue logo" src="../assets/logo.png">-->
        <!--<HelloWorld msg="Welcome to Your Vue.js App"/>-->
        <ProductList></ProductList>
        <Cart></Cart>
    </div>
</template>

<script>
    //import HelloWorld from './HelloWorld.vue'
    import ProductList from './ProductList.vue'
    import Cart from './ShoppingCart.vue'

    export default {
        name: 'app',
        components: {
//    HelloWorld
            ProductList,
            Cart
        }
    }
</script>

<style>
    /*#app {*/
    /*font-family: 'Avenir', Helvetica, Arial, sans-serif;*/
    /*-webkit-font-smoothing: antialiased;*/
    /*-moz-osx-font-smoothing: grayscale;*/
    /*text-align: center;*/
    /*color: #2c3e50;*/
    /*margin-top: 60px;*/
    /*}*/
</style>
