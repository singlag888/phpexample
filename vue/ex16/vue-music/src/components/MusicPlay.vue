<template>

    <div>

        <!--<p>{{ songMid }}</p>-->


        <div class="center">
            <mu-button icon @click="playOrPauseMusic">
                <mu-icon :value="playButtonState" size="50">
                </mu-icon>
            </mu-button>
        </div>


        <mu-flex class="progress_content">
            <mu-flex class="flex-demo" justify-content="center">
                {{ songPlayTime }}
            </mu-flex>
            <mu-flex class="progress_content_progress" justify-content="center" fill>
                <mu-slider v-model="songProgress" :max="songTotalSecond" v-bind:displayValue="true"
                           　@change="slideProgress">

                </mu-slider>

                <audio id="songAudio" :src="songPlayUrl" autoplay loop>

                </audio>
            </mu-flex>
            <mu-flex class="flex-demo" justify-content="center">
                {{ songTotalTime }}
            </mu-flex>
        </mu-flex>

        <mu-container class="content_lyrics">
            <!--{{ songLyrics }}-->

            <mu-load-more>
                <mu-list>
                    <!--<mu-list-item v-for="item in songLyricsArr">-->
                    <!---->
                    <!--</mu-list-item>-->

                    <mu-list-item-sub-title v-for="item in songLyricsArr">
                        {{ item }}
                    </mu-list-item-sub-title>
                </mu-list>
            </mu-load-more>

        </mu-container>

    </div>

</template>

<script>

    import lodash from 'lodash'
    import {mapActions} from 'vuex'

    export default {
        data: function () {
            return {
//                songMid: '',
                isPlayStatus: true,
                songPlayTime: '00:00',
                songTotalTime: '00:00',
                songTotalSecond: 0,
                songProgress: 0,
                songPlayUrl: '',
                audioDiv: {},
                songLyrics: '',
                songLyricsArr: [],
            }
        },
        props: {
            songMid: {
                type: String,
                required: true
            },
            songid: {
                type: String,
                required: true
            }
        },
        computed: {
//            songMid() {
//                return this.songMid;
//            }
            playButtonState() {
                return this.isPlayStatus ? 'play_circle_outline' : 'pause_circle_outline'
            }
        },
        created: function () {
            this.fetchData()
        },
        watch: {
            'songMid': function () {
                console.log('music play  view songMid changed ')
                this.fetchData()
            }
        },
        updated: function () {
//            console.log('music play  view updated ')
        },
        methods: {
            ...mapActions([
                'getPlayUrl',
//                'getSongInfo',
                'getSongLyrics',
            ]),
            fetchData: function () {
                console.log('fetch music url start')
                this.getPlayUrl(this.songMid).then(data => {
                    let songUrl = data['128mp3'];
                    console.log('music url: ' + songUrl)
                    this.songPlayUrl = songUrl

                    console.log('fetch music url end')

                    this.audioEvent();
                });
                this.getSongLyrics(this.songid)
                    .then(resp => {
                        let base64Lyric = resp.data.lyric;
                        this.songLyrics = window.atob(base64Lyric)
                        this.songLyricsArr = this.songLyrics.split('\n')
                        console.log(this.songLyricsArr)
                    })
            },
            playOrPauseMusic: function (event) {
//                console.log(this.audioDiv)
                if (this.audioDiv.paused) {
                    this.audioDiv.play()
                } else {
                    this.audioDiv.pause()
                }

                if (this.audioDiv.paused) {
                    this.isPlayStatus = false
                } else {
                    this.isPlayStatus = true
                }
            },
            slideProgress: lodash.debounce(function (progress) {
//                console.log(progress)
                this.audioDiv.currentTime = progress
            }, 300, {'trailing': true}),
            audioEvent() {

                this.audioDiv = document.getElementById("songAudio")
//                console.log(this.audioDiv)

                this.audioDiv.onplaying = function () {
//                    console.log('musice playing start')
                }
                this.audioDiv.onplay = (event) => {
//                    console.log('onplay')
//                    console.log(event)
//                    console.log(this)
//                    event.timeStamp;
//                    this.audioDiv.duration;
//                    this.audioDiv.currentTime;
                    this.songTotalSecond = event.target.duration
                    this.songTotalTime = this.convertToTime(event.target.duration)
//                    console.log('totaltime: ' + event.target.duration + "  ;currentTime: " + event.target.currentTime)
                }
                this.audioDiv.ontimeupdate = (event) => {
//                    console.log('ontimeupdate progress: ')
//                    console.log(progress)
//                    console.log(this)
//                    console.log('totaltime: ' + event.target.duration + "  ;currentTime: " + event.target.currentTime)

                    this.songPlayTime = this.convertToTime(event.target.currentTime)
                    this.songProgress = event.target.currentTime
                }
            },
            convertToTime: function (time) {
                var min = Math.floor((time / 60) % 60);
                var sec = Math.floor(time % 60);
                var cTime;
                if (sec < 10) {
                    sec = '0' + sec;
                }
                if (min < 10) {
                    min = '0' + min;
                }
                cTime = min + ':' + sec
                return cTime;
            },

        }

    }
</script>

<style>

    .center {
        text-align: center;
    }

    .progress_content, .progress_content_progress {
        margin: 0px 10px;
    }

    .content_lyrics{
        padding:0 20px ;
    }


</style>