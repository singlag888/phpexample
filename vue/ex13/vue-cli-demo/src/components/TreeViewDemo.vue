<template>

    <div>
        <p>(You can double click on an item to turn it into a folder.)</p>

        <!-- the demo root element -->
        <ul id="demo">
            <treeView
                    class="item"
                    :model="treeData">
            </treeView>
        </ul>

    </div>
</template>

<script>

    import treeView from './TreeView.vue'

    var data = {
        name: 'My Tree',
        children: [
            {name: 'hello'},
            {name: 'wat'},
            {
                name: 'child folder',
                children: [
                    {
                        name: 'child folder',
                        children: [
                            {name: 'hello'},
                            {name: 'wat'}
                        ]
                    },
                    {name: 'hello'},
                    {name: 'wat'},
                    {
                        name: 'child folder',
                        children: [
                            {name: 'hello'},
                            {name: 'wat'}
                        ]
                    }
                ]
            }
        ]
    }

    export default {
        components: {
            'treeView': treeView
        },
        data: function () {
            return {
                treeData: data
            }
        }
    }

</script>

<style>

    #demo {
        font-family: Menlo, Consolas, monospace;
        color: #444;
    }

</style>