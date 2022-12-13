const Path = require('path');
const { JavascriptWebpackConfig } = require('@silverstripe/webpack-config');

const PATHS = {
  ROOT: Path.resolve(),
  SRC: Path.resolve('client/src'),
};

const config = [
  // Main JS bundle
  new JavascriptWebpackConfig('js', PATHS, 'silverstripe/frameworktest')
    .setEntry({
      legacy: `${PATHS.SRC}/bundles/legacy.js`,
    })
    .getConfig(),
];

module.exports = config;
