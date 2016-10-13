const webpack = require('webpack');
const Config = require('./webpack.config');

Config.plugins = [
    new webpack.ProvidePlugin({
      jQuery: 'jQuery',
      $: 'jQuery',
    }),
];
Config.devtool = 'source-map';

module.exports = Config;
