<template>
    <div id="app">
        <div class="main_container" :class="{ 'nav-hide': !isLeftDrawerOpen }">

            <mu-appbar color="primary" z-depth="0">
                <mu-button icon slot="left" @click="toggleDrawer">
                    <mu-icon value="menu"></mu-icon>
                </mu-button>

                <router-link to="/index">
                    <p class="app_bar_home">Home</p>
                </router-link>
            </mu-appbar>


            <router-view/>
        </div>


        <slide-bar class="left_container"></slide-bar>

    </div>
</template>

<script>
    import {mapState, mapActions, mapMutations} from 'vuex'
    import SlideBar from './components/SlideBar.vue'

    export default {
        data: function () {
            return {}
        },
        computed: {
            ...mapState([
                'isLeftDrawerOpen',
            ])
        },
        components: {
            SlideBar
        },
        methods: {
            ...mapMutations({
                toggleDrawer: 'toggleLeftDrawer'
            })
        }
    }

</script>
<!--vue文件中格式化less文件。添加 type="text/less" 生效。正常使用需要添加两个： type="text/less" lang="less"　-->
<style type="text/less" lang="less">
    /*#app {*/
    /*font-family: 'Avenir', Helvetica, Arial, sans-serif;*/
    /*-webkit-font-smoothing: antialiased;*/
    /*-moz-osx-font-smoothing: grayscale;*/
    /*text-align: center;*/
    /*color: #2c3e50;*/
    /*margin-top: 60px;*/
    /*}*/

    .main_container {
        margin-left: 256px;
        &.nav-hide {
            margin-left: 0;
        }
    }

    .left_container {
    }

    .app_bar_home {
        color: white;
    }
</style>
