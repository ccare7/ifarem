module.exports = {
    devServer: {
        proxy: {
            '/api': {
                target: 'http://www.baidu1.com:3367/index.php',
                ws: true,
                changeOrigin: true
            },
        }
    }
}