import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store/index'
import MuseUI from 'muse-ui';
import 'muse-ui/dist/muse-ui.css';
import axios from 'axios'
import theme from 'muse-ui/lib/theme'
import * as colors from 'muse-ui/lib/theme/colors'

/*theme.add('custome-theme', {
    primary: colors.indigo,
    secondary: colors.pinkA200
})*/
// theme.use('light')

// Vue.prototype.$http = axios
Vue.config.productionTip = false
Vue.use(MuseUI)


new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app')
