<template>

    <div>

        <div class="banner">
            <mu-row justify-content="center">
                <mu-avatar size="88px" color="white" text-color="primary">
                    <p class="top-avatar-title">M</p>
                </mu-avatar>


            </mu-row>
            <p class="banner_text">QQ Music</p>
            <p class="banner_text">Embrace Vue , enjoy life</p>

            <div>
                <!--<mu-text-field hintText="search song or singer" icon="search" type="search" full-width
                               iconClass="color-white" hintTextClass="color-white" inputClass="color-white"
                               underlineClass="border-white-alpha" underlineFocusClass="color-white"
                ></mu-text-field>-->
                <mu-text-field hintText="search song or singer" icon="search" type="search" full-width
                               color="white" underline-color="white" icon-color="white"
                               @change="getMusicList"
                ></mu-text-field>
            </div>

        </div>

        <mu-list>
            <div v-for="(item,index) in songsList">
                <mu-list-item button tripple @click="songItemClick(item)">
                    <mu-list-item-action>
                        <mu-avatar size="28">
                            {{ index+1 }}
                        </mu-avatar>
                    </mu-list-item-action>

                    <mu-list-item-content>
                        <mu-list-item-title>
                            {{ item.songName }}
                        </mu-list-item-title>
                    </mu-list-item-content>
                </mu-list-item>
                <mu-divider></mu-divider>
            </div>

        </mu-list>

    </div>

</template>

<script>
    import {mapState, mapActions} from 'vuex'

    export default {
        data: function () {
            return {}
        },
        computed: {
            ...mapState({
                songsList: 'songList'
            })
        },
        created() {
//            this.getMusicList('hello')
            this.getTopMusic()
        },
        methods: {
            ...mapActions({
                getSongList: 'getSongList',
                getTopMusic: 'getTopMusic',
            }),
            getMusicList(keyword) {
                this.getSongList(keyword)
            },
            songItemClick(song) {
                this.$store.commit('addSongHistoryList', song)
                //传递对象参数：　query 传递
//                this.$router.push({path: `/player/${song.albumid}/${song.songid}/${song.songmid}`,query:song})
                //传递对象参数：　params　传递
                this.$router.push({
                    name: 'player',
                    params: {'albumid': song.albumid, 'songid': song.songid, 'songmid': song.songmid, 'song': song}
                })
            },

        }
    }
</script>

<style type="text/less" lang="less">

    @import "../styles/import";

    .banner {
        background: @primaryColor;
        padding: 20px 20px;
        text-align: center;
    }

    .top-avatar-title {
        font-size: 3em;
    }

    .banner_text {
        font-size: 2em;
        color: @white;
        margin: 0;
    }

    /* <!--.color-white {-->
         <!--color: fade(@white, 87%);-->
     <!--}-->

     <!--.border-white-alpha {-->
         <!--color: fade(@white, 50%);-->
         <!--background-color: fade(@white, 50%);-->
     <!--}-->

     <!--.mu-input-line {-->
         <!--background-color: @white !important;-->
     <!--}-->*/

</style>