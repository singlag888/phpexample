import Vue from 'vue'
import Router from 'vue-router'
import Home from './views/Home.vue'
import MuseUi from './views/MuseUi.vue'
import Index from './views/index.vue'
import Player from './views/player.vue'

Vue.use(Router)

export default new Router({
    mode: 'history',
    base: process.env.BASE_URL,
    routes: [
        {
            path: '/home',
            name: 'home',
            component: Home
        },
        {
            path: '/about',
            name: 'about',
            // route level code-splitting
            // this generates a separate chunk (about.[hash].js) for this route
            // which is lazy-loaded when the route is visited.
            component: () => import(/* webpackChunkName: "about" */ './views/About.vue')
        },
        {
            path: '/museui',
            name: 'museui',
            component: MuseUi
        },
        {
            path: '/index',
            name: 'index',
            component: Index
        },
        {
            path: '/player/:albumid/:songid/:songmid',
            name: 'player',
            component: Player,
            // props:true,
        },
        {
            path: '*',
            redirect: '/index'
        }
    ]
})
