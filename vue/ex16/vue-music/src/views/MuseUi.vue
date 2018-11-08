<template>
    <div>

        <mu-appbar color="primary">
            <mu-button icon slot="left">
                <mu-icon value="menu"></mu-icon>
            </mu-button>

            Title

            <mu-button flat slot="right">LOGIN</mu-button>
        </mu-appbar>

        <h3>alert</h3>

        <mu-alert color="success">
            <mu-icon left value="check_circle"></mu-icon>
            this is a success alert
        </mu-alert>

        <mu-button color="primary">Primary</mu-button>
        <mu-button flat color="primary">Primary</mu-button>

        <h3>drawer</h3>

        <mu-button @click="open = !open">Open/Close</mu-button>

        <mu-drawer :open.sync="open">
            <mu-list>
                <mu-list-item button>
                    <mu-list-item-title>Menu Item 1</mu-list-item-title>
                </mu-list-item>
                <mu-list-item button>
                    <mu-list-item-title>Menu Item 1</mu-list-item-title>
                </mu-list-item>
                <mu-list-item button @click="open=false">
                    <mu-list-item-title>Close</mu-list-item-title>
                </mu-list-item>
            </mu-list>
        </mu-drawer>


        <mu-divider>

        </mu-divider>

        <div class="field_container">

            <mu-text-field full-width icon="search" underline-color='white'>

            </mu-text-field>
        </div>
    </div>
</template>

<script>


    export default {
        data: function () {
            return {
                open: false,
            }
        },
    }
</script>

<style>

    .field_container{
        padding:10px;
        background: dodgerblue;
    }
</style>