const { defineConfig } = require('@vue/cli-service')
const webpack = require('webpack')

module.exports = defineConfig({
  transpileDependencies: true,
  filenameHashing: false,
  outputDir: 'dist',
  devServer: {
    port: 8080,
    hot: true,
    headers: {
      'Access-Control-Allow-Origin': '*'
    },
    allowedHosts: 'all',
    client: {
      webSocketURL: {
        hostname: 'localhost',
        pathname: '/ws',
        password: 'dev-server',
        port: 8080,
        protocol: 'ws',
      }
    }
  },
  configureWebpack: {
    optimization: {
      splitChunks: false // Disable code splitting
    },
    output: {
      filename: 'js/app.js',
      chunkFilename: 'js/[name].js'
    },
    devtool: 'source-map'
  },
  css: {
    extract: false // This will include CSS in the main bundle
  },
  publicPath: process.env.NODE_ENV === 'production'
    ? '/wp-content/plugins/smart-press-pro/dist/'
    : 'http://localhost:8080/'
}) 