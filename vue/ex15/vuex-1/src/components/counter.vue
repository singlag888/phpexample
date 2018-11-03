<template>

    <div>
        <p>counter : {{ this.$store.state.count }} </p>
        <p>count is {{ even }}</p>
        <button @click="increment">+</button>
        <button @click="decrement">-</button>
        <button @click="incrementIfOdd">+ if odd</button>
        <button @click="incrementAsync">+ Async</button>


        <input type="number" v-model="inputCount" @keyup.enter="setCount">
    </div>
</template>

<script>


    export default {
        data: function () {
            return {
                inputCount: 0
            }
        },
        computed: {
//            even() {
//            //直接访问　state
//                return this.$store.state.count % 2 == 0 ? 'odd' : 'even'
//            }
            even() {
                //调用　getter
                return this.$store.getters.evenOrOdd
            }
        },
        methods: {
            increment() {
                //调用　mutation
                this.$store.commit('increment')
            },
            decrement() {
                this.$store.commit('decrement')
            },
            setCount() {
                console.log('set count commit' + this.inputCount)
                this.$store.commit('setCount', this.inputCount)
            },
            incrementIfOdd() {
                //调用　action
                this.$store.dispatch('incrementIfOdd')
            },
            incrementAsync() {
                this.$store.dispatch('incrementAsync')
            }
        }
    }
</script>

<style>

    button {
        display: block;
        padding: 5px 10px;
        margin: 5px;
    }

</style>