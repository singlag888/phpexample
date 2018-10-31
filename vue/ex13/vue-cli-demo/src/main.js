import Vue from 'vue'
// import App from './App.vue'
import App from './components/App.vue'
import VueResource from 'vue-resource'
import VueRouter from 'vue-router'


Vue.use(VueResource)
Vue.use(VueRouter)
Vue.config.productionTip = false

import HelloWorld from './components/HelloWorld.vue'
import Markdown from './components/markdown.vue'
import Github from './components/github.vue'
import GridView from './components/GridView.vue'
import TreeViewDemo from './components/TreeViewDemo.vue'
import Chart from './components/chart.vue'
import modal from './components/Modal.vue'


const ModalView = {
    // component: {
    //     modal: Modal,
    // },
    template: `
     <button id="show-modal" @click="showModal = true">Show Modal</button>
         <!-- use the modal component, pass in the prop -->
         <modal v-if="showModal" @close="showModal = false">
             <!--
               you can use custom content here to overwrite
               default content
             -->
             <h3 slot="header">custom header</h3>
         </modal>
    `,
}
const router = new VueRouter({
    mode: 'history',
    base: __dirname,
    routes: [
        // {path: '', component: HelloWorld},
        {path: '/markdown', component: Markdown},
        {path: '/github', component: Github},
        {path: '/gridView', component: GridView},
        {path: '/treeView', component: TreeViewDemo},
        {path: '/chart', component: Chart},
        {path: '/modal', component: ModalView},
        {path: '*', component: HelloWorld}
    ]
})


new Vue({
    router,
    render: h => h(App)
}).$mount('#app')
