import Vue from 'vue'
import Router from 'vue-router'
import MuseUi from './views/MuseUi.vue'
import Index from './views/index.vue'
import Player from './views/player.vue'

Vue.use(Router)

export default new Router({
    mode: 'history',
    base: process.env.BASE_URL,
    routes: [
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
