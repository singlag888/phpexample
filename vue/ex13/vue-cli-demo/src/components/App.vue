<template>

    <div>
        <h1>demo components</h1>

        <ul>
            <li>
                <router-link to="/">Hello world</router-link>
            </li>
            <li>
                <router-link to="markdown">Markdown</router-link>
            </li>
            <li>
                <router-link to="github">Github</router-link>
            </li>
            <li>
                <router-link to="gridView">GridView</router-link>
            </li>
            <li>
                <router-link to="treeView">TreeView</router-link>
            </li>
            <li>
                <router-link to="chart">Chart</router-link>
            </li>
            <li>
                <router-link to="modal">Modal</router-link>
            </li>
        </ul>


        <router-view></router-view>
    </div>
</template>

<script>

    export default {
        data: function () {
            return {
                showModal: false
            }
        }
    }
</script>