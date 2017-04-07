'use strict';

const elixir = require('laravel-elixir');
const del = require('del');

require('laravel-elixir-eslint');
require('./tasks/swPrecache.task.js');
require('./tasks/bower.task.js');

// setting assets paths
elixir.config.assetsPath = './';
elixir.config.css.folder = 'components';
elixir.config.css.sass.folder = 'components';
elixir.config.js.folder = 'components';

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

let assets = [
        'public/js/final.js',
        'public/css/final.css'
    ],
    scripts = [
        'public/js/vendor.js', 'public/js/app.js'
    ],
    styles = [
        // for some reason, ./ prefix here works fine!
        // it is needed to override elixir.config.css.folder for styles mixin
        './public/css/vendor.css', './public/css/app.css'
    ],
    karmaJsDir = [
        'public/js/vendor.js',
        'node_modules/angular-mocks/angular-mocks.js',
        'node_modules/ng-describe/dist/ng-describe.js',
        'public/js/app.js',
        'tests/components/**/*.spec.js'
    ];

elixir(mix => {
    mix.bower()
        .copy('components/app/**/*.html', 'public/views/app/')
        .copy('components/dialogs/**/*.html', 'public/views/dialogs/')
        .webpack('index.main.js', 'public/js/app.js')
        .sass(['**/*.scss', 'critical.scss'], 'public/css')
        .sass('critical.scss', 'public/css/critical.css')
        .styles(styles, 'public/css/final.css')
        .eslint('components/**/*.js')
        .combine(scripts, 'public/js/final.js')
        .version(assets)
        .swPrecache();

    //enable front-end tests by adding the below task
    // .karma({jsDir: karmaJsDir});
});

/*------------------------------------------------------------------------------------------------*/

var base = 'app/Components',
    fromComponents = 'DealRegistration';

// Delete entire folder of view vendor
gulp.task('clean-view-vendor', function () {
    return del(['./resources/views/vendor/voyager']).then(paths => {
        console.log('Deleted files and voyager vendor folders:\n', paths.join('\n'));
    });
});

// Copying view resources
gulp.task('cp-rsc', ['clean-view-vendor'], function () {
    return gulp.src([
            './' + base + '/' + fromComponents + '/Resources/views/vendor/voyager/**/*.*'
        ])
        .pipe(gulp.dest('./resources/views/vendor/voyager'));
});

// Delete entire folder of view vendor
gulp.task('clean-public-assets', function () {
    return del(['./public/assets']).then(paths => {
        console.log('Deleted files and public assets folders:\n', paths.join('\n'));
    });
});

// Copying public assets
gulp.task('cp-pa', ['clean-public-assets'], function () {
    return gulp.src([
            './' + base + '/' + fromComponents + '/Resources/public/assets/**'
        ])
        .pipe(gulp.dest('./public/assets'));
});