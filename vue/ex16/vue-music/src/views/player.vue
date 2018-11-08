<template>

    <div>


        <mu-container class="header_avatar_container">
            <mu-paper circle :z-depth="5" class="header_img_center rotate_img">
                <!--<img src="https://sm.pcmag.com/t/pcmag_au/review/g/google-pho/google-photos_6b7u.640.jpg" alt="">-->
                <mu-avatar size="230">
                    <img :src="albumImgUrl" alt="">
                </mu-avatar>
            </mu-paper>

            <!--//获取参数对象：　query 传递-->
            <!--{{ $route.query }}-->
            <!--//获取对象参数：　params　传递-->
            <!--{{ $route.params }}-->

            <p> {{ songName }} </p>
            <p> {{ singerName }} </p>
        </mu-container>


        <musicPlay :songMid="songmid" :songid="songid">

        </musicPlay>

        <!--{{ $route.params }}-->
        <!--{{ console.log($route.params) }}-->


    </div>
</template>

<script>

    import musicPlay from '../components/MusicPlay.vue'
    import {mapActions} from 'vuex'

    export default {
        components: {
            musicPlay,
        },
        props: {
//            'song': Object,
        },
        data: function () {
            return {
                songName: '',
                singerName: '',
            }
        },
        computed: {
            albumid() {
                return this.$route.params.albumid
            },
            albumImgUrl() {
                return `http://imgcache.qq.com/music/photo/album_300/${this.albumid % 100}/300_albumpic_${this.albumid}_0.jpg`
            },
            songmid() {
                console.log('player view songmid use')
                return this.$route.params.songmid
            },
            songid() {
                return this.$route.params.songid
            }
        },
        created: function () {
            console.log('player view created ')
            console.log(this)
            console.log(this.$route)
            //获取对象参数：　query 传递
            console.log(this.$route.query)
            //获取对象参数：　params　传递
            console.log(this.$route.params)
//            console.log(this.song)
            this.songInfo()
        },
        watch: {
            'songmid': function () {
                this.songInfo()
            }
        },
        updated: function () {
            console.log('player view updated ')
//            musicPlay
        },
        methods: {
            ...mapActions([
//                'getPlayUrl',
                'getSongInfo',
            ]),
            songInfo() {
                this.getSongInfo(this.songmid).then(data => {
//                console.log(data)
                    this.songName = data.data[0].name;
                    this.singerName = data.data[0].singer[0].name;
                })
            },
        }

    }

</script>

<style>

    .header_avatar_container {
        text-align: center;
        width: 100%;
        padding: 20px 10px;
    }

    .header_avatar_container > p {
        font-size: 1.5em;
        color: black;
        margin: 5px;
    }

    .header_img_center {
        text-align: center;
        width: 230px;
        height: 230px;
        display: inline-block;
    }

    .rotate_img {
        animation: rotateImg 20s linear infinite;
    }

    @keyframes rotateImg {
        0% {
            -webkit-transform: rotate(0deg);
        }
        50% {
            -webkit-transform: rotate(180deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
        }
    }

</style>