module.exports = {
    devServer: {
        proxy: {
            '/qq-m-api': {
                target: 'http://c.y.qq.com/',
                ws: true,
                changeOrigin: true,
                pathRewrite:{
                    '^/qq-m-api':''
                }
            },
        }
    }
}