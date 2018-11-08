import Vue from 'vue'
import Vuex from 'vuex'
import * as musicApi from '../api/api'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        historySongList: [],//历史记录列表
        isLeftDrawerOpen: true,//左边drawer是否打开
        songList: [],//播放列表
    },
    mutations: {
        toggleLeftDrawer(state) {
            state.isLeftDrawerOpen = !state.isLeftDrawerOpen
        },
        addSongHistoryList(state, item) {

            if (state.historySongList.length === 0) {
                state.historySongList.push(item)
            } else {
                let songIds = []
                for (let sub of state.historySongList) {
                    songIds.push(sub.songid)
                }
                if (!songIds.includes(item.songid)) {
                    state.historySongList.push(item)
                }
            }
            // console.log(state.historySongList)
        },
        addSongList(state, item) {
            state.songList = item
        }
    },
    actions: {
        getTopMusic({commit}) {
            musicApi.topMusice()
                .then(resp => {
                    let songList = resp.data.songlist;
                    let results = []
                    for(let item of songList){
                        item = item.data
                        results.push({
                            albumid: item.albumid,
                            albumname: item.albumname,
                            singler: item.singer[0].name,
                            songName: item.songname,
                            songid: item.songid,
                            songmid: item.songmid,
                        })
                    }
                    // console.log(results)
                    commit('addSongList', results)
                })
        },
        getSongList({commit, state}, keyword) {
            musicApi.search(keyword)
                .then(songList => {
                    // console.log(songList)

                    let results = []
                    for (let item of songList) {
                        results.push({
                            albumid: item.albumid,
                            albumname: item.albumname,
                            singler: item.singer.name,
                            songName: item.songname,
                            songid: item.songid,
                            songmid: item.songmid,
                        })
                    }
                    commit('addSongList', results)
                })
        },
        getPlayUrl({commit}, songMid) {
            return musicApi.getPlayUrl(songMid)
        },
        getSongInfo({commit}, songMid) {
            return musicApi.fetchSongInfo(songMid);
        },
        getSongLyrics({commit}, songId) {
            return musicApi.fetchLyric(songId)
        },
    }
})
