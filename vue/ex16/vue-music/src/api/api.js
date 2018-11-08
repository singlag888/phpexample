import Vue from 'vue'
import axios from 'axios'
import VueResource from 'vue-resource'

var querystring = require('querystring');


// axios.defaults.headers.common['Access-Control-Allow-Origin']='*'
// axios.defaults.headers.common['Origin']='*/*'
Vue.use(VueResource)

//Vue.http.options.emulateJSON = true;
var qqAPI = {

    top_music: {
        url: 'https://c.y.qq.com/v8/fcg-bin/fcg_v8_toplist_cp.fcg',
        params: () => {
            return {
                g_tk: 5381,
                uin: 0,
                format: 'json',
                inCharset: 'utf-8',
                outCharset: 'utf-8¬ice=0',
                platform: 'h5',
                needNewCode: 1,
                tpl: 3,
                page: 'detail',
                type: 'top',
                topid: 27,
                _: '1519963122923',
                //     ?g_tk=5381&uin=0&format=json&inCharset=utf-8
                //     &outCharset=utf-8¬ice=0&platform=h5
                // &needNewCode=1&tpl=3&page=detail
                // &type=top&topid=27&_=1519963122923
            }
        }
    },
    album: {
        url: 'https://c.y.qq.com/v8/fcg-bin/fcg_v8_album_info_cp.fcg',
        params: (id) => {
            return {
                albummid: id,
                g_tk: 5381,
                loginUin: 0,
                hostUin: 0,
                format: 'jsonp',
                inCharset: 'utf8',
                outCharset: 'utf-8',
                notice: 0,
                platform: 'yqq',
                needNewCode: 0
            }
        },

    },
    song_info: {
        url: '/qq-m-api/v8/fcg-bin/fcg_play_single_song.fcg',
        params: (mid) => {
            return {
                'songmid': mid,
                'format': 'json',
            }
        },

    },
    search: {
        url: 'http://c.y.qq.com/soso/fcgi-bin/search_cp?',
        params: (key) => {
            return {
                'p': 1,
                'n': 15,
                'w': key,
                'aggr': 1,
                'lossless': 1,
                'cr': 1,
            }
        }

    },
    hotkey: {
        url: 'https://c.y.qq.com/splcloud/fcgi-bin/gethotkey.fcg',
        params: () => {
            return {
                g_tk: 5381,
                loginUin: 0,
                hostUin: 0,
                format: 'jsonp',
                jsonp: 'jsonpCallback',
                inCharset: 'utf8',
                outCharset: 'utf-8',
                notice: 0,
                platform: 'yqq',
                needNewCode: 0
            }
        },

    },

    lyric: {
        url: 'https://c.y.qq.com/lyric/fcgi-bin/fcg_query_lyric.fcg',
        params: (id) => {
            return {
                nobase64: 1,
                musicid: id,
                songtype: 0,
                g_tk: 5381,
                loginUin: 0,
                hostUin: 0,
                format: 'jsonp',
                inCharset: 'utf8',
                outCharset: 'utf-8',
                notice: 0,
                platform: 'yqq',
                needNewCode: 0
            }
        },

    },


}

export function topMusice() {
    let p = Vue.http.jsonp(qqAPI.top_music.url, {params: qqAPI.top_music.params(), jsonp: 'jsonpCallback'});
    p.then(resp => {
        console.log(resp)
    }, err => {
        console.log('request top music error')
    });
    return p;
}


export function search(word) {
    // axios
    //     .get(qqAPI.search.url, querystring.stringify(qqAPI.search.params(word)))
    //
    //     .then(function (response) {
    //         console.log(response)
    //     })
    //     .catch(function (error) {
    //         console.log(error)
    //     }).then(function () {
    //
    // });
    // console.log(Vue.http)
    // console.log(Vue.http.jsonp)


    var p = Vue.http.jsonp(qqAPI.search.url, {params: qqAPI.search.params(word), jsonp: 'jsonpCallback'});
    console.log(qqAPI.search.url + querystring.stringify(qqAPI.search.params(word)))
    return p.then(resp => {
        console.log(resp.data);
        return Promise.resolve(resp.data.data.song.list)
        // return Promise.reject('what are you ？')
    }, resp => {
        console.log("request error");
    });
    // return p;
}

export function fetchSongInfo(song_mid) {
    var p = Vue.http.get(qqAPI.song_info.url, {params: qqAPI.song_info.params(song_mid)});
    //var p=Vue.http.get("/qq-m-api/v8/fcg-bin/fcg_play_single_song.fcg?songmid=001Ud2bQ0u61uC&format=json");
    console.log(qqAPI.song_info.url + '?' + querystring.stringify(qqAPI.song_info.params(song_mid)))
    return p.then(resp => {
        console.log(resp.data);
        return Promise.resolve(resp.data);
    }, resp => {
        return Promise.reject('reques error')
        console.log("request error");
    });
    // return p;
}

export function fetchHotkey() {
    var p = Vue.http.jsonp(qqAPI.hotkey.url, qqAPI.hotkey.params());
    p.then(resp => {
        console.log(resp.data);
    }, resp => {
        console.log("request error");
    });
    return p;
}

export function fetchAlbum(albummid) {
    var p = Vue.http.jsonp(qqAPI.album.url, {params: qqAPI.album.params(albummid), jsonp: 'jsonpCallback',});
    p.then(resp => {
        console.log(resp.data);
    }, resp => {
        console.log("request error");
    });
    return p;
}

export function fetchLyric(songid) {

    console.log('fetch Lyrics')
    var p = Vue.http.jsonp('https://api.darlin.me/music/lyric/' + songid + '/', {
        params: qqAPI.lyric.params(songid),
        jsonp: 'callback'
    });
    p.then(resp => {
        console.log(resp);
    }, resp => {
        console.log(resp);
        console.log("request error");
    });
    return p;
}

export function fetchHitAll() {
    var p = Vue.http.jsonp(baseListUrl + '/musicbox/shop/v3/data/hit/hit_all.js');
    p.then(resp => {
        console.log(resp.data);
    }, resp => {
        console.log("request error");
    });
    return p;
}

export function fetchHitNewSong() {
    var p = Vue.http.jsonp(baseListUrl + '/musicbox/shop/v3/data/hit/hit_newsong.js');
    p.then(resp => {
        console.log(resp.data);
    }, resp => {
        console.log("request error");
    });
    return p;
}

function getRandom1(start, end) {
    var length = end - start + 1;
    var num = parseInt(Math.random() * (length) + end);
    return num;
}

function genKey() {

    let random1 = getRandom1(1, 2147483647);
// random1 = 1809645566;
    console.log(random1);

    let number = Date.parse(new Date()).toString().substr(0, 10);

    console.log(number);//1541518998000  //0.08719500 1541518261

    let microtime = ['0.62426800', number].join(' ');
    microtime = 0.59250400;
    console.log(microtime);

    // let guid = parseInt(Math.random() * (2147483647 - 1 + 1) + 1, 10) * (number) % 10000000000;

    let guid = parseInt(random1 * microtime % 10000000000);
    console.log(guid)

    console.log(random1 + '   ' + microtime + '   ' + guid)
    // return 'hello';
    let data = Vue.http.jsonp('https://c.y.qq.com/base/fcgi-bin/fcg_musicexpress.fcg?json=3&guid=' + guid, {jsonp: 'jsonpCallback'});
    return data.then(resp => {
        console.log(resp.data);

        if (resp.data) {
            let key = resp.data.key;
            let playUrl = resp.data.sip[1];

            return Promise.resolve({
                'guid': guid,
                'key': key,
                'playUrl': playUrl,
            })
        } else {
            return Promise.reject('not response data!')
        }

    }, error => {
        console.log("request error" + error);
    });
}

export function getPlayUrl(songMid) {


    // 提示错误，无法解决：Cross-Origin Read Blocking (CORB) blocked cross-origin response http://phpexample.com/thirdApi/TencentMusicAPI.php?songMid=002MjXqL1747v9 with MIME type text/json. See https://www.chromestatus.com/feature/5629709824032768 for more details.
    // 使用服务器获取数据后再转发回来
    // 使用node 代理服务器解决: http-proxy-middleware
    // let getFileData = 0;
    /* Vue.http.jsonp('http://c.y.qq.com/v8/fcg-bin/fcg_play_single_song.fcg?songmid=' + songMid + '&format=json')
         .then(resp => {
             console.log(resp.data)
             if (resp.data) {

                 let fileDatas = resp.data.data[0].file

                 let type = {
                     'size_320mp3:': ['M800', 'mp3'],
                     'size_128mp3:': ['M500', 'mp3'],
                     'size_96aac:': ['C400', 'm4a'],
                     'size_48aac:': ['C200', 'm4a'],
                 }

                 let playUrls = []
                 for (let item in type) {
                     console.log(item + ' ' + type[item][0])
                     if (fileDatas[item]) {
                         playUrls.push()
                     }
                 }

                 return Promise.resolve(fileDatas)
             } else {
                 return Promise.reject('not response data')
             }
         }, error => {
             console.log('getplay url error' + error.message)
             // return Promise.reject('not response data')
         });*/


    /*let songInfo = fetchSongInfo(songMid);
    let genKey1 = genKey();

    return Promise.all([genKey1, songInfo])
        .then(data => {
                console.log(data)
                let key = data[0];
                let songData = data[1].data[0];
                let fileData = songData.file;

                let type = {
                    'size_320mp3': ['M800', 'mp3'],
                    'size_128mp3': ['M500', 'mp3'],
                    'size_96aac': ['C400', 'm4a'],
                    'size_48aac': ['C200', 'm4a'],
                }

                let playUrls = {}
                for (let item in type) {
                    if (fileData[item]) {
                        playUrls[item.substr(5)] = key.playUrl + type[item][0] + fileData.media_mid + '.' + type[item][1]
                            + '?vkey=' + key['key'] + '&guid=' + key['guid'] + '&fromtag=30'
                    }
                }
                return Promise.resolve(playUrls);
                // console.log(playUrls);
            }
        );*/

    return Vue.http.get('http://phpexample.com/thirdApi/TencentMusicAPI.php?songMid=' + songMid)
        .then(resp => {
            console.log(resp.data)
            if (resp.data) {
                return Promise.resolve(resp.data)
            } else {
                return Promise.reject('not response data')
            }
        });
}

function ajax(params) {
    params = params || {};
    params.data = params.data || {};
    // 判断是ajax请求还是jsonp请求
    var json = params.jsonp ? jsonp(params) : json(params);

    // ajax请求
    function json(params) {
        // 请求方式，默认是GET
        params.type = (params.type || 'GET').toUpperCase();
        // 避免有特殊字符，必须格式化传输数据
        params.data = formatParams(params.data);
        var xhr = null;


        // 实例化XMLHttpRequest对象
        if (window.XMLHttpRequest) {
            xhr = new XMLHttpRequest();
        } else {
            // IE6及其以下版本
            xhr = new ActiveXObjcet('Microsoft.XMLHTTP');
        }


        // 监听事件，只要 readyState 的值变化，就会调用 readystatechange 事件
        xhr.onreadystatechange = function () {
            // readyState属性表示请求/响应过程的当前活动阶段，4为完成，已经接收到全部响应数据
            if (xhr.readyState == 4) {
                var status = xhr.status;
                // status：响应的HTTP状态码，以2开头的都是成功
                if (status >= 200 && status < 300) {
                    var response = '';
                    // 判断接受数据的内容类型
                    var type = xhr.getResponseHeader('Content-type');
                    if (type.indexOf('xml') !== -1 && xhr.responseXML) {
                        response = xhr.responseXML; //Document对象响应
                    } else if (type.indexOf('application/json')) {
                        response = JSON.parse(xhr.responseText); //JSON响应
                    } else {
                        response = xhr.responseText; //字符串响应
                    }
                    ;
                    // 成功回调函数
                    params.success && params.success(response);
                } else {
                    params.error && params.error(status);
                }
            }
            ;
        };

        // 连接和传输数据
        if (params.type == 'GET') {
            // 三个参数：请求方式、请求地址(get方式时，传输数据是加在地址后的)、是否异步请求(同步请求的情况极少)；
            xhr.open(params.type, params.url + '?' + params.data, true);
            xhr.send(null);
        } else {
            xhr.open(params.type, params.url, true);
            //必须，设置提交时的内容类型
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
            // 传输数据
            xhr.send(params.data);
        }
    }

    // jsonp请求
    function jsonp(params) {
        //创建script标签并加入到页面中
        var callbackName = params.jsonp;
        var head = document.getElementsByTagName('head')[0];
        // 设置传递给后台的回调参数名
        params.data['callback'] = callbackName;
        var data = formatParams(params.data);
        var script = document.createElement('script');
        head.appendChild(script);

        //创建jsonp回调函数
        window[callbackName] = function (json) {
            console.log(json)

            head.removeChild(script);
            clearTimeout(script.timer);
            window[callbackName] = null;
            params.success && params.success(json);
        };


        //发送请求
        script.src = params.url;// + '?' + data;
        // script.src = params.url + '?' + data;


        //为了得知此次请求是否成功，设置超时处理
        if (params.time) {
            script.timer = setTimeout(function () {
                window[callbackName] = null;
                head.removeChild(script);
                params.error && params.error({
                    message: '超时'
                });
            }, time);
        }
    }


    //格式化参数
    function formatParams(data) {
        var arr = [];
        for (var name in data) {
            // encodeURIComponent() ：用于对 URI 中的某一部分进行编码
            arr.push(encodeURIComponent(name) + '=' + encodeURIComponent(data[name]));
        }
        ;
        // 添加一个随机数参数，防止缓存
        arr.push('v=' + random());
        return arr.join('&');
    }


    // 获取随机数
    function random() {
        return Math.floor(Math.random() * 10000 + 500);
    }

}


// console.log('process')