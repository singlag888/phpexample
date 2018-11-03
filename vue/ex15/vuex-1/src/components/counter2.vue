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

    import {mapState, mapGetters, mapActions, mapMutations} from 'vuex'


    export default {
        data: function () {
            return {
                inputCount: 0
            }
        },
        //调用　state
//        computed: mapState({
//            even: state => {
//                return state.count % 2 === 0 ? 'even' : 'odd'
//            }
//        }),
//        computed:{
//            ...mapState({
//                even: state => {
//                    return state.count % 2 === 0 ? 'even' : 'odd'
//                }
//            })
//        },
        //　getter　调用
//       //单独调用
//        computed: mapGetters({
//            even: 'evenOrOdd'
//        }),
        //混入调用
        computed: {
            ...mapGetters({
                even: 'evenOrOdd'
            }),
            hello() {

            }
        },
        methods: {
            //mutation 调用
            //直接映射
            ...mapMutations([
                'increment',
                'setCount'
            ]),
            //别名映射
            ...mapMutations({
                decrement: 'decrement'
            }),
            //action 调用
            ...mapActions([
                'incrementIfOdd'
            ]),
            ...mapActions({
                incrementAsync: 'incrementAsync'
            }),
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