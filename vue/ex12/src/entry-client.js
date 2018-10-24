import {createApp} from "./app";

// 客户端特定引导逻辑……

const {app, router, store} = createApp();

if (window.__INITIAL_STATE__) {
    store.replaceState(window.__INITIAL_STATE__q)
}

router.onReady(function () {


    router.beforeResolve((to, from, next) => {
        const matched = router.getMatchedComponents(to)
        const prevMatched = router.getMatchedComponents(from)

        let diffed = false
        const activated = matched.filter((c, i) => {
            return diffed || (diffed = (prevMatched[i] !== c))
        })

        if (!activated.length) {
            return next()
        }

        Promise.all(activated.map(c => {
            if (c.asyncData) {
                return c.asyncData({store, route: to})
            }
        })).then(() => {
            next()
        }).catch(next)
    })

    app.$mount('#app')
})

Vue.mixin({
    // beforeMount() {
    //     const {asyncData} = this.$options
    //     if (asyncData) {
    //         this.dataPromise = asyncData({
    //             store: this.$store,
    //             route: this.$route,
    //         })
    //     }
    // },

    beforeRouteUpdate(to, from, next) {
        const {asyncData} = this.$options
        if (asyncData) {
            asyncData({
                store: this.$store,
                route: to
            }).then(next).catch(next)
        } else {
            next()
        }
    }
})