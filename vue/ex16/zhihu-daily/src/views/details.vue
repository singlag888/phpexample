<template>
    <v-app>
        <v-toolbar app flat color="#008bed">
            <v-layout align-center justify-center row fill-height>
                <v-flex md7 lg7>
                    <v-layout align-center justify-start row fill-height>
                        <!--<v-img src="../assets/Web_Logo.png" height="56px" contain width="120px"></v-img>-->
                        <img src="../assets/Web_Logo.png" height="42px" contain width="126px"></img>

                        <v-spacer></v-spacer>
                        <v-btn color="#008bed" dark href="https://itunes.apple.com/cn/app/id639087967?mt=8"
                               target="_blank">
                            <v-icon>360</v-icon>
                            iPhone
                        </v-btn>

                        <v-btn color="#008bed" dark href="https://daily.zhihu.com/download/android" target="_blank">
                            <v-icon>android</v-icon>
                            Android
                        </v-btn>
                    </v-layout>
                </v-flex>
            </v-layout>
        </v-toolbar>

        <v-content>

            <v-layout align-start justify-center row>
                <v-flex md7 lg6>
                    <v-card color="white" flat>
                        <v-img
                                max-height="350px"
                                :src="newsDetail.image"
                        >
                            <v-container fill-height fluid>
                                <v-layout justify-end column fill-height>

                                    <v-flex md12 xs12></v-flex>
                                    <v-flex md12 xs12></v-flex>
                                    <v-flex md12 xs12 align-self-start>
                                        <span class="head_title">{{ newsDetail.title }} </span>
                                    </v-flex>

                                    <v-flex md12 align-self-end xs12>
                                        <span class="head_title head_small">图片：{{ newsDetail.image_source }}</span>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </v-img>


                        <v-card-title>
                            <!--<div>-->
                            <!--{{ newsDetail.title }}-->
                            <!--</div>-->

                            <div>
                                <span v-html="newsDetail.body">

                                </span>

                            </div>
                        </v-card-title>

                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn flat color="#008bed" :href="newsDetail.share_url">查看知乎原文</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-flex>
            </v-layout>


            <v-layout align-start justify-center row class="content_padding">
                <v-flex md7 lg6>

                    <v-card color="white" flat>
                        <v-layout align-center justify-space-around column fill-height class="bottom_content_padding">
                            <div class="bottom_title">
                                扫描二维码下载知乎日报
                            </div>

                            <div class="bottom_content">
                                支持 iOS 和 Android
                            </div>

                            <img src="http://static.daily.zhihu.com/img/qr1.png"
                                 height="150px" width="150px"></img>
                        </v-layout>
                    </v-card>
                </v-flex>
            </v-layout>

        </v-content>


        <v-footer>
            <v-layout align-center justify-center row>
                知乎网 · © 2018 知乎
            </v-layout>
        </v-footer>
    </v-app>

</template>

<script>
    import * as  zhuhuapi from '../api/zhihu'

    export default {
        data: function () {
            return {
                newsDetail: {},
            }
        },
        created: function () {
            zhuhuapi.newsDetails(this.$route.params.newid)
                .then(data => {
                    console.log(data)
                    this.newsDetail = data
                    loadCss(data.css)
                })
        }
    }

    function loadCss(file) {
        var cssTag = document.getElementById('loadCss');
        var head = document.getElementsByTagName('head').item(0);
        if (cssTag) head.removeChild(cssTag);
        let css = document.createElement('link');
//        css.href = "../css/mi_" + file + ".css";
        css.href = file;
        css.rel = 'stylesheet';
        css.type = 'text/css';
        css.id = 'loadCss';
        head.appendChild(css);
    }
</script>

<style type="text/less">

    /*@import "newsDetail.css";*/

    .head_title {
        color: white;
        font-size: 2em;
    }

    .head_small {
        font-size: 1em;
    }

    .content_padding {
        margin: 5px 0 0 0;
    }

    .bottom_content_padding {
        padding: 30px 0 30px 0;
    }

    .bottom_title {
        font-size: 1.5em;
        color: #000;
    }

    .bottom_content {
        margin: 10px 0 10px 0;
        color: grey;
    }

    .headline, .img-place-holder {
        border-bottom: 0px solid #eee !important;
        height: 0 !important;
    }


</style>