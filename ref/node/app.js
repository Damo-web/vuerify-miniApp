const express = require('express')
var proxy = require('http-proxy-middleware')
const app = express()

app.get('/', (req, res) => res.send('Hello World!'))


// proxy middleware options
var options = {
  target: 'http://www.baidu.com/', // target host
  changeOrigin: true, // needed for virtual hosted sites
  ws: true, // proxy websockets
  pathRewrite: {
    '^/api/old-path': '/api/new-path', // rewrite path
    '^/api/remove/path': '/path' // remove base path
  },
  router: {
    // when request.headers.host == 'dev.localhost:3000',
    // override target 'http://www.example.org' to 'http://localhost:8000'
    'dev.localhost:3000': 'http://localhost:8000'
  }
}

// create the proxy (without context)
var exampleProxy = proxy(options)

// mount `exampleProxy` in web server
app.use('/api', exampleProxy)
app.listen(8000)