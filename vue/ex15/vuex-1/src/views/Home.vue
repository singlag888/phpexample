<template>
  <div id="app">
    <!--<img alt="Vue logo" src="../assets/logo.png">-->
    <!--<HelloWorld msg="Welcome to Your Vue.js App"/>-->

    <Counter class="counter"></Counter>
    <Counter2 class="counter2"></Counter2>
  </div>
</template>

<script>
    import HelloWorld from '../components/HelloWorld.vue'
    import Counter from '../components/counter.vue'
    import Counter2 from '../components/counter2.vue'

    export default {
        name: 'app',
        components: {
//    HelloWorld
            Counter,
            Counter2,
        }
    }
</script>

<style>
  #app {
    font-family: 'Avenir', Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
    margin-top: 60px;
  }

  .counter {
    border: 1px solid green;
    margin-bottom: 10px;
  }

  .counter2 {
    border: 1px solid red;
  }
</style>
