var path = require('path');
var pkg = require('../package.json');
var webpack = require('webpack');
var ExtractTextPlugin = require('extract-text-webpack-plugin');

var bannerPack = new webpack.BannerPlugin(
  'Quill Editor v' + pkg.version + '\n' +
  'https://quilljs.com/\n' +
  'Copyright (c) 2014, Jason Chen\n' +
  'Copyright (c) 2013, salesforce.com'
, { entryOnly: true });
var constantPack = new webpack.DefinePlugin({
  QUILL_VERSION: JSON.stringify(pkg.version)
});


module.exports = {
  context: path.resolve(__dirname, '..'),
  entry: {
    'quill.js': ['./quill.js'],
    'quill.core.js': ['./core.js'],
    'quill.core': './assets/core.styl',
    'quill.bubble': './assets/bubble.styl',
    'quill.snow': './assets/snow.styl',
    'unit.js': './test/unit.js'
  },
  output: {
    filename: '[name]',
    library: 'Quill',
    libraryTarget: 'umd',
    path: 'dist/'
  },
  resolve: {
    alias: {
      'parchment': path.resolve(__dirname, '..', 'node_modules/parchment/src/parchment')
    },
    extensions: ['', '.js', '.styl', '.ts']
  },
  module: {
    loaders: [
      { test: /parchment\/src\/.*\.ts$/, loader: 'ts' },
      { test: /\.styl$/, loader: ExtractTextPlugin.extract('style', 'css!stylus') },
      { test: /\.svg$/, loader: 'html?minimize=true' },
      {
        test: /\.js$/,
        exclude: [/node_modules/, /rich-text/],
        loader: 'babel',
        query: {
          presets: ['es2015']
          // plugins: ['transform-es2015-modules-commonjs']
        }
      }
    ],
    noParse: [
      /\/node_modules\/clone\/clone\.js$/,
      /\/node_modules\/eventemitter3\/index\.js$/,
      /\/node_modules\/extend\/index\.js$/
    ]
  },
  ts: {
    configFileName: 'tsconfig.json',
    compilerOptions: {
      target: 'es5',
      module: 'commonjs'
    },
    silent: true
  },
  plugins: [
    bannerPack,
    constantPack,
    new ExtractTextPlugin('[name].css', { allChunks: true })
  ],
  devServer: {
    hot: false,
    port: process.env.npm_package_config_ports_webpack,
    stats: {
      assets: false,
      chunks: false,
      errorDetails: true,
      errors: true,
      hash: false,
      timings: false,
      version: false,
      warnings: true
    }
  }
};

if (process.argv.indexOf('--coverage') !== -1) {
  module.exports.module.postLoaders = [{
    test: /\.js$/,
    loader: 'istanbul-instrumenter',
    exclude: [
      path.resolve(__dirname, '..', 'node_modules'),
      path.resolve(__dirname, '..', 'test'),
      path.resolve(__dirname, '..', 'core/polyfill.js'),
      path.resolve(__dirname, '..', 'core.js'),
      path.resolve(__dirname, '..', 'quill.js')
    ]
  }];
  module.exports.module.loaders[3].query = {
    plugins: ['transform-es2015-modules-commonjs']
  };
}

if (process.argv.indexOf('--minimize') !== -1) {
  module.exports.entry = {
    'quill.min.js': './quill.js'
  };
  module.exports.plugins.push(
    new webpack.optimize.DedupePlugin(),
    new webpack.optimize.UglifyJsPlugin({
      compress: {
        warnings: false
      }
    })
  );
  module.exports.devtool = 'source-map';
}
