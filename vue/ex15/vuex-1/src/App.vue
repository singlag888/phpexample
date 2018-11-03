<template>
    <div id="app">
        <div id="nav">
            <router-link to="/">Vuex 基础使用</router-link>
            <br>
            <!--<router-link to="/about">About</router-link>-->

            <router-link to="/about">Vuex Module使用</router-link>
        </div>
        <router-view/>
    </div>
</template>

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
