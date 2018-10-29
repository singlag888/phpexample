<template>

    <div id="demo">
        <form id="search">
            Search <input name="query" v-model="searchQuery">
        </form>
        <demo-grid
                :data="gridData"
                :columns="gridColumns"
                :filter-key="searchQuery">
        </demo-grid>
    </div>

</template>

<script>

    import demoGrid from './GridTemplate.vue'

    export default {
        components: {
            'demo-grid': demoGrid
        },
        data: function () {
            return {
                searchQuery: '',
                gridColumns: ['name', 'power'],
                gridData: [
                    {name: 'Chuck Norris', power: Infinity},
                    {name: 'Bruce Lee', power: 9000},
                    {name: 'Jackie Chan', power: 7000},
                    {name: 'Jet Li', power: 8000}
                ]
            }
        }
    }
</script>

<style>

    #demo {
        font-family: Helvetica Neue, Arial, sans-serif;
        font-size: 14px;
        color: #444;
    }


</style>