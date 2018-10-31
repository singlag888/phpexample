<template>
    <div id="app">
        <img alt="Vue logo" src="./assets/logo.png">
        <HelloWorld msg="Welcome to Your Vue.js App"/>

        <!--<Markdown></Markdown>-->

        <!--<Github></Github>-->

        <!--<GridView></GridView>-->

        <!--<TreeViewDemo></TreeViewDemo>-->

        <!--报错，找　单个vue文件中定义多个模板-->
        <!--<Chart></Chart>-->

        <!--modal-->
        <!-- <button id="show-modal" @click="showModal = true">Show Modal</button>
         &lt;!&ndash; use the modal component, pass in the prop &ndash;&gt;
         <modal v-if="showModal" @close="showModal = false">
             &lt;!&ndash;
               you can use custom content here to overwrite
               default content
             &ndash;&gt;
             <h3 slot="header">custom header</h3>
         </modal>-->


    </div>
</template>

<script>
    import HelloWorld from './components/HelloWorld.vue'
    import Markdown from './components/markdown.vue'
    import Github from './components/github.vue'
    import GridView from './components/GridView.vue'
    import TreeViewDemo from './components/TreeViewDemo.vue'
    import Chart from './components/chart.vue'
    import Modal from './components/Modal.vue'

    export default {
        name: 'app',
        components: {
            HelloWorld,
            Markdown,
            Github,
            GridView,
            TreeViewDemo,
            Chart,
            Modal,
        },
        data: function () {
            return {
                showModal: false
            }
        }
    }
</script>

<style>
    #app {
        font-family: 'Avenir', Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        /*text-align: center;*/
        color: #2c3e50;
        /*margin-top: 60px;*/
        height: 100%;
        margin: 0;
        padding: 0;
    }
</style>
