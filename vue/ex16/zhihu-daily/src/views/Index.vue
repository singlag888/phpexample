<template>
    <v-app>
        <v-toolbar app flat color="#ffffff" height="78px">
            <!--<image height="50px" width="145px" src="https://daily.zhihu.com/img/new_home_v3/top_logo.png">-->
            <!--</image>-->

            <v-icon width="50px">

            </v-icon>

            <v-toolbar-title>
                <a href="https://daily.zhihu.com/" target="_blank">
                    <img src="https://daily.zhihu.com/img/new_home_v3/top_logo.png" alt="" height="50px" width="145px">
                </a>
            </v-toolbar-title>


            <v-spacer></v-spacer>

            <v-btn depressed color="#f0f9ff">
                App 下载
            </v-btn>

            <v-btn flat>
                浏览内容
            </v-btn>

        </v-toolbar>

        <v-content>
            <v-card color="#008bed" flat tile>

                <v-layout>
                    <v-flex md4 align-self-end offset-md2>

                        <img height="100%" src="https://daily.zhihu.com/img/new_home_v3/phone_sample.png" alt="">

                    </v-flex>

                    <v-flex md4>

                        <v-layout align-space-around justify-space-between column fill-height>

                            <v-flex md7 align-self-end>
                                <v-layout align-center justify-end column fill-height>
                                    <h2 class="top_title">每天三次 每次七分钟</h2>
                                    <p class="top_title_des">在中国，资讯类移动应用的人均阅读时长是 5 分钟，而在知乎日报，这个数字是 21。</p>

                                </v-layout>
                            </v-flex>

                            <v-flex md5>
                                <v-layout align-center justify-space-around row fill-height>

                                    <!--<v-img src="https://daily.zhihu.com/img/new_home_v3/qr_top2.png">-->
                                    <!--</v-img>-->
                                    <img src="https://daily.zhihu.com/img/new_home_v3/qr_top2.png" alt="">

                                    <v-layout align-space-around justify-center column fill-height class="clear_flex">
                                        <v-btn depressed large
                                               href="http://zhstatic.zhihu.com/pkg/store/daily/zhihu-daily-zhihu-2.5.4(392).apk">
                                            <v-icon>phone_iphone</v-icon>
                                            IOS 版
                                        </v-btn>
                                        <!--{{ appDownloadAndroids }}-->

                                        <v-menu open-on-hover offset-y bottom>
                                            <v-btn depressed large
                                                   slot="activator"
                                                   href="http://zhstatic.zhihu.com/pkg/store/daily/zhihu-daily-zhihu-2.5.4(392).apk">
                                                <v-icon>android</v-icon>
                                                Android 版
                                            </v-btn>
                                            <v-list>
                                                <v-list-tile
                                                        v-for="(item,index) in appDownloadAndroids"
                                                        :key="index"
                                                        :href="item.link"
                                                        target="_blank"
                                                >
                                                    <!--@click=""-->
                                                    <!--<v-icon medium></v-icon>-->
                                                    <img :src="item.icon" alt="">

                                                    <v-list-tile-title> {{ item.title }}</v-list-tile-title>
                                                </v-list-tile>
                                            </v-list>
                                        </v-menu>
                                    </v-layout>
                                </v-layout>
                            </v-flex>


                        </v-layout>

                        <!-- <v-layout column align-self-center>
                             <v-flex >
                                 <h2>每天三次 每次七分钟</h2>
                                 <p>在中国，资讯类移动应用的人均阅读时长是 5 分钟，而在知乎日报，这个数字是 21。</p>

                             </v-flex>

                             <v-flex>
                                 <h2>每天三次 每次七分钟</h2>
                                 <p>在中国，资讯类移动应用的人均阅读时长是 5 分钟，而在知乎日报，这个数字是 21。</p>

                             </v-flex>
                         </v-layout>-->
                    </v-flex>
                </v-layout>


            </v-card>

            <v-layout>
                <v-flex md2 offset-md2>

                    <h2 class="center_title_left">浏览内容</h2>

                </v-flex>

                <v-flex md2 offset-md5 align-self-end>
                    <h2 class="center_title_right">最新内容</h2>
                </v-flex>
            </v-layout>

            <v-layout fluid>
                <v-flex md8 offset-md2>
                    <v-container grid-list-xl fluid>
                        <v-layout row wrap>

                            <v-flex
                                    md4
                                    v-for="(item,key) in news"
                                    :key="key"
                            >
                                <v-card flat class="card_padding" color="white" :to="{ name:'detail',params:{newid:item.id} }" target="_blank">
                                    <v-img
                                            :src="item.images[0]"
                                            max-width="200px"
                                            contain
                                    ></v-img>
                                    <v-card-title>
                                        <p class="content_title"> {{ item.title }} </p>
                                    </v-card-title>
                                </v-card>

                            </v-flex>

                        </v-layout>

                    </v-container>
                </v-flex>


            </v-layout>

            <v-flex md8 offset-md2>
                <v-card color="#e8eef2" flat>
                    <v-card-title class="center">
                        <div class="content_bottom_text">
                            更多精彩内容可在知乎日报应用中查看
                        </div>
                    </v-card-title>
                </v-card>
            </v-flex>


            <v-flex md8 offset-md2>
                <v-card flat color="application">
                    <v-card-title class="center">
                        <!--<div class="content_bottom_text">-->
                        <!--更多精彩内容可在知乎日报应用中查看-->
                        <!--</div>-->
                    </v-card-title>
                </v-card>
            </v-flex>


        </v-content>

        <v-layout class="content_bottom">
            <v-flex md6 offset-md2>
                <v-layout align-start justify-center column fill-height>
                    <p>知乎日报是一款拥有千万用户的资讯类客户端，每日提供来自知乎社区的精选问答，还有国内一流媒体的专栏特稿。</p>
                    <p>主题日报包括动漫、设计、大公司、游戏、财经、电影、电子音乐、互联网安全等丰富内容，为业内人和资深爱好者推荐各领域最精彩文章，满足高质量阅读需求。</p>

                    <p>在知乎日报，告别浮躁，重获阅读的愉悦。</p>

                    <p>© 2018 知乎</p>

                </v-layout>
            </v-flex>

            <v-flex md2>
                <v-layout align-center justify-center column fill-height>
                    <v-card flat color="white" class="bottom_img_padding">

                        <img src="https://daily.zhihu.com/img/new_home_v3/qr_bottom.png" alt="">

                    </v-card>
                    <div>
                        <p>扫描下载客户端</p>
                    </div>
                </v-layout>
            </v-flex>
        </v-layout>

        <!--<v-img  src="https://daily.zhihu.com/img/new_home_v3/qr_bottom.png"></v-img>-->


        <!--<v-footer app>-->

        <!--</v-footer>-->
    </v-app>
</template>

<script>
    //import HelloWorld from './components/HelloWorld'
    import {mapActions} from 'vuex'
    import * as zhihuapi from '../api/zhihu'

    export default {
        name: 'App',
        components: {
//    HelloWorld
        },
        data() {
            return {
                //
                appDownloadAndroids: [
                    {
                        icon: 'https://daily.zhihu.com/img/new_home_v3/icon_wandoujia.png',
                        title: '碗豆荚',
                        link: 'http://www.wandoujia.com/apps/com.zhihu.daily.android'
                    },
                    {
                        icon: 'https://daily.zhihu.com/img/new_home_v3/icon_91market.png',
                        title: '91 市场',
                        link: 'http://apk.hiapk.com/html/2013/09/1752117.html?p=iphone&amp;f_name=%u77E5%u4E4E%u65E5%u62A5&amp;f_version='
                    },
                    {
                        icon: 'https://daily.zhihu.com/img/new_home_v3/icon_360market.png',
                        title: '360 市场',
                        link: 'http://zhushou.360.cn/detail/index/soft_id/348684'
                    },
                ],
                news: [],

            }
        },
        created: function () {
            this.getNews()
        },
        methods: {
            getNews() {
                this.getDailyNewss()
            },
            getDailyNewss() {
                zhihuapi.getThreeDailyNews().then(data => {
                    console.log(data)
                    this.news = data
                })

            },
        }
    }
</script>

<style>
    a {

    }

    .tool_bar_padding {
        padding: 0 50px;
        display: inline;
    }

    .top_title {
        font-size: 3em;
        color: white;
    }

    .top_title_des {
        font-size: 1.3em;
        color: #99d1f8;
    }

    .center_title_left {
        font-size: 2em;
        padding: 20px 10px;
    }

    .center_title_right {
        font-size: 2em;
        padding: 20px 10px;
        color: #ccc;
    }

    .card_padding {
        padding: 16px;
    }

    .content_title {
        font-size: 1.5em;
        margin: 10px 0 0 0;
    }

    .content_bottom_text {
        display: block;
        font-size: 1.5em;
        color: #15527b;
    }

    .center {
        text-align: center;
        display: block;
    }

    .content_bottom {
        background: #e5e5e5;
        padding: 30px 0 30px 0;
    }

    .bottom_img_padding {
        padding: 10px;
        margin-bottom: 10px;
    }

    .clear_flex{
        flex:none;
    }

</style>
