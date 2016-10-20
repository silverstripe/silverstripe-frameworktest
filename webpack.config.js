const webpack = require('webpack');
const autoprefixer = require('autoprefixer');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
// const SprityWebpackPlugin = require('sprity-webpack-plugin');

const PATHS = {
  MODULES: './node_modules',
  JS_SRC: './client/src',
  JS_DIST: './client/dist',
};

// Used for autoprefixing css properties (same as Bootstrap Aplha.2 defaults)
const SUPPORTED_BROWSERS = [
  'Chrome >= 35',
  'Firefox >= 31',
  'Edge >= 12',
  'Explorer >= 9',
  'iOS >= 8',
  'Safari >= 8',
  'Android 2.3',
  'Android >= 4',
  'Opera >= 12',
];

const config = {
    // TODO Split out with new 'admin' module
    name: 'js',
    entry: {
      legacy: `${PATHS.JS_SRC}/bundles/legacy.js`,
    },
    resolve: {
      modulesDirectories: [PATHS.MODULES],
    },
    output: {
      path: 'client/dist',
      filename: '[name].js',
    },

    // lib.js provies these globals and more. These references allow the framework bundle
    // to access them.
    externals: {
        'components/Breadcrumb/Breadcrumb': 'Breadcrumb',
        'components/FormBuilderModal/FormBuilderModal': 'FormBuilderModal',
        'components/FormBuilder/FormBuilder': 'FormBuilder',
        'components/Toolbar/Toolbar': 'Toolbar',
        'containers/FormBuilderLoader/FormBuilderLoader': 'FormBuilderLoader',
        'state/breadcrumbs/BreadcrumbsActions': 'BreadcrumbsActions',
        'deep-freeze-strict': 'DeepFreezeStrict',
        i18n: 'i18n',
        jQuery: 'jQuery',
        'lib/Backend': 'Backend',
        'lib/Config': 'Config',
        'lib/Injector': 'Injector',
        'lib/ReducerRegister': 'ReducerRegister',
        'lib/Router': 'Router',
        'lib/ReactRouteRegister': 'ReactRouteRegister',
        'lib/SilverStripeComponent': 'SilverStripeComponent',
        'page.js': 'Page',
        'react-addons-css-transition-group': 'ReactAddonsCssTransitionGroup',
        'react-addons-test-utils': 'ReactAddonsTestUtils',
        'react-dom': 'ReactDom',
        'react-redux': 'ReactRedux',
        'react-router-redux': 'ReactRouterRedux',
        'react-router': 'ReactRouter',
        react: 'React',
        'redux-thunk': 'ReduxThunk',
        redux: 'Redux',
    },
    module: {
      loaders: [
        {
          test: /\.js$/,
          exclude: /(node_modules|thirdparty)/,
          loader: 'babel',
          query: {
            presets: ['es2015', 'react'],
            plugins: ['transform-object-assign', 'transform-object-rest-spread'],
            comments: false,
          },
        },
        {
          test: '/i18n.js/',
          loader: 'script-loader',
        },
      ],
    },
    plugins: [
      new webpack.ProvidePlugin({
        jQuery: 'jQuery',
        $: 'jQuery',
      }),
      new webpack.DefinePlugin({
        'process.env':{
          // Builds React in production mode, avoiding console warnings
          'NODE_ENV': JSON.stringify('production')
        }
      }),
      new webpack.optimize.UglifyJsPlugin({
        compress: {
          unused: false,
          warnings: false,
        },
        output: {
          beautify: false,
          semicolons: false,
          comments: false,
          max_line_len: 200,
        },
      }),
    ],
  };

// Use WEBPACK_CHILD=js or WEBPACK_CHILD=css env var to run a single config
module.exports = config;
