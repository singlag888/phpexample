import axios from 'axios'

// import qs from 'qs'

export function getDailyNews(day = '20181111') {
    let url = '/zhihuapi/api/4/news/before/' + day;

    return axios
        .get(url)//, {headers: {'content-type': 'application/x-www-form-urlencoded', 'testheaderkey': 'testheadervalue'}}
        .then(function (response) {
            // console.log(response)
            return Promise.resolve(response.data)
        })
        .catch(function (error) {
            console.log(error)
        });
}

export function newsDetails(newsId = '9701545') {
    // let url = 'https://news-at.zhihu.com/api/4/news/' + newsId;
    let url = '/zhihuapi/api/4/news/' + newsId;
    return axios
        .get(url)
        .then(function (response) {
            // console.log(response)
            return Promise.resolve(response.data)
        })
        .catch(function (error) {
            console.log(error)
        })
}

export function getThreeDailyNews() {
    let today = showDate(0);
    let yesterday = showDate(-1);
    let thedby = showDate(-2);

    return Promise
        .all([getDailyNews(today), getDailyNews(yesterday), getDailyNews(thedby)])
        .then(function (data) {
            let result = data[0].stories.concat(data[1].stories, data[2].stories);
            // console.log(result)
            return Promise.resolve(result)
        })
}

function showDate(n) {
    let date = new Date();
    date.setDate(date.getDate() + n)
    return dateToStr(date)
}

function dateToStr(date) {
    let year = date.getFullYear().toString();
    let month = (date.getMonth() + 1).toString();
    let day = date.getDate().toString();
    if (month.length === 1) {
        month = '0' + month
    }
    if (day.length === 1) {
        day = '0' + day
    }
    return year + month + day
}