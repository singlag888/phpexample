<template>

    <mu-drawer :open.sync="isLeftDrawerOpen">
        <p class="center">
            <a class="a_left_history" href="">History</a>

            <mu-badge content="2018" color="secondary"></mu-badge>
        </p>

        <mu-divider></mu-divider>

        <mu-list>
            <mu-list-item v-for="item in historySongList" button
                          v-bind:to="toUrl(item)">
                <!--/player/${song.albumid}/${song.songid}/${song.songmid}-->
                <mu-list-item-title>
                    <!--{{ item }}-->
                    {{ item.songName }}
                </mu-list-item-title>
            </mu-list-item>
        </mu-list>
    </mu-drawer>
</template>

<script>

    import {mapState} from 'vuex'

    export default {
        data: function () {
            return {
//                isLeftDrawerOpen: this.$store.state.isLeftDrawerOpen,
            }
        },
        computed: {
            ...mapState({
                historySongList: 'historySongList',
                isLeftDrawerOpen: 'isLeftDrawerOpen',
            }),

        },
        created: function () {
            this.repeadLog();
            console.log('hello world history song')
        },
        methods: {
            repeadLog() {
//                setInterval(() => {
//                    console.log(this)
//                    console.log(this.historySongList)
//                }, 3000);
            },
            toUrl(item) {
                return "/player/" + item.albumid + "/" + item.songid + "/" + item.songmid
            },
        }
    }
</script>

<style>

    .a_left_history {
        color: dimgrey;
        font-size: 2em;
    }

    .center {
        text-align: center;
    }

</style>