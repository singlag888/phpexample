import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export function createRouter() {
    return new Router({
        mode: 'history',
        routes: [
            {
                path: '/', component: function () {
                return import('./compenents/Home.vue')
            }
            },
            {path: '/item/:id', component: () => import('./components/Item.vue')}
        ]
    })
}