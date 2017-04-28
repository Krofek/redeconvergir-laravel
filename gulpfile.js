var paths = {
    'SOURCE': './resources/assets/',
    'DESTINATION': './public/assets/',
    'BOWER': './resources/assets/bower/',
    'PUBLIC_VENDOR': './public/vendor/'
};

require('laravel-elixir-vue-2');

// var gulp = require('gulp');
// var imagemin = require('gulp-imagemin');
// var pngquant = require('imagemin-pngquant');

// gulp.task('imagemin', function () {
//     return gulp.src(paths.SOURCE + 'images/**/*.{png,jpg,gif}')
//         .pipe(imagemin({
//             progressive: true,
//             svgoPlugins: [{removeViewBox: false}],
//             use: [pngquant()]
//         }))
//         .pipe(gulp.dest(paths.DESTINATION + 'images'));
// });

Elixir(function (mix) {

    //
    // mix.styles(paths.BOWER + 'normalize-css/normalize.css', paths.DESTINATION + 'css/normalize.css', './');
    //
    // mix.scripts(paths.BOWER + 'jquery/dist/jquery.js', paths.DESTINATION + 'js/jquery.js', './');
    // mix.scripts(paths.BOWER + 'modernizr/modernizr.js', paths.DESTINATION + 'js/modernizr.js', './');
    //
    // mix.copy(paths.SOURCE + 'images', paths.DESTINATION + 'images');
    //
    // mix.scriptsIn(paths.SOURCE + 'js/frontend', paths.DESTINATION + 'js/frontend.js');

    // mix.coffee('app.coffee', paths.SOURCE + 'js/app_coffee.js');

    // compile scss file
    mix.sass('app.scss', paths.SOURCE + 'css');

    // copy glyph icons for bootstrap, select2 images
    mix.copy(paths.BOWER + 'bootstrap/dist/fonts', paths.DESTINATION + 'fonts/bootstrap');

    // compile es6 (babel) and vue with webpack
    mix.webpack('app.js', paths.DESTINATION + 'js/app.js');

    // mix&copy ie scripts
    mix.scripts([
        paths.BOWER + 'html5shiv/dist/html5shiv.min.js',
        paths.BOWER + 'respond/dest/respond.min.js'
    ], paths.DESTINATION + 'js/ie.js');

    // mix&copy vendor scripts
    mix.scripts([
        paths.SOURCE + 'js/generated/laroute.js',
        paths.BOWER + 'jquery/dist/jquery.min.js',
        paths.BOWER + 'bootstrap/dist/js/bootstrap.min.js',
        paths.PUBLIC_VENDOR + 'backpack/select2/select2.js'
    ], paths.DESTINATION + 'js/build.js');

    // mix&copy custom css files
    mix.styles([
        paths.SOURCE + 'css/app.css',
    ], paths.DESTINATION + 'css/app.css');
});
