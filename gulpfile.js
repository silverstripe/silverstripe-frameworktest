const gulp = require('gulp');
const browserify = require('browserify');
const buffer = require('vinyl-buffer');
const sourcemaps = require('gulp-sourcemaps');
const uglify = require('gulp-uglify');
const gulpUtil = require('gulp-util');
const notify = require('gulp-notify');
const source = require('vinyl-source-stream');

const isDev = typeof process.env.npm_config_development !== 'undefined';

const PATHS = {
    JS_SRC: './client/src',
    JS_DIST: './client/dist',
};

const browserifyOptions = {
    debug: true,
    paths: [PATHS.JS_SRC],
};

const babelifyOptions = {
    presets: ['es2015', 'es2015-ie', 'react'],
    plugins: ['transform-object-assign', 'transform-object-rest-spread'],
    ignore: /(node_modules|thirdparty)/,
    comments: false,
};

const uglifyOptions = {
    mangle: false,
};

gulp.task('build', ['bundle']);

gulp.task('bundle', ['bundle-legacy']);

gulp.task('bundle-legacy', function bundleLeftAndMain() {
    const bundleFileName = 'bundle-legacy.js';

    return browserify(Object.assign({}, browserifyOptions,
        { entries: `${PATHS.JS_SRC}/bundles/legacy.js` }
    ))
        .on('update', bundleLeftAndMain)
        .on('log', (msg) =>
            gulpUtil.log('Finished', `bundled ${bundleFileName} ${msg}`)
        )
        .transform('babelify', babelifyOptions)
        .external('config')
        .external('jQuery')
        .external('i18n')
        .external('i18nx')
        .external('react')
        .external('react-dom')
        .external('components/FormBuilder/FormBuilder')
        .bundle()
        .on('update', bundleLeftAndMain)
        .on('error', notify.onError({ message: `${bundleFileName}: <%= error.message %>` }))
        .pipe(source(bundleFileName))
        .pipe(buffer())
        .pipe(sourcemaps.init({ loadMaps: true }))
        .pipe(uglify(uglifyOptions))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(PATHS.JS_DIST));
});

gulp.task('default', ['build'], () => {
    if (isDev) {
        gulp.watch(`${PATHS.JS_SRC}/**/*.js`, ['build']);
    }
});
