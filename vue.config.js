const { defineConfig } = require('@vue/cli-service')
const webpack = require('webpack')
require('dotenv').config()

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
    devtool: 'source-map',
    plugins: [
      new webpack.DefinePlugin({
        'process.env.VUE_APP_ENABLE_FRONTEND': JSON.stringify(process.env.VUE_APP_ENABLE_FRONTEND),
        'process.env.VUE_APP_ENABLE_BACKEND': JSON.stringify(process.env.VUE_APP_ENABLE_BACKEND),
        'process.env.VUE_APP_DEV_MODE': JSON.stringify(process.env.VUE_APP_DEV_MODE)
      })
    ]
  },
  css: {
    extract: false // This will include CSS in the main bundle
  },
  publicPath: process.env.NODE_ENV === 'production'
    ? '/wp-content/plugins/smart-press-pro/dist/'
    : 'http://localhost:8080/'
}) 