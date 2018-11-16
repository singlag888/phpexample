module.exports = {
    devServer: {
        proxy: {
            '/zhihuapi': {
                target: 'https://news-at.zhihu.com/',
                ws: true,
                changeOrigin: true,
                pathRewrite: {
                    '^/zhihuapi': ''
                }
            },
        }
    }
}