var paths = {
    'SOURCE': './resources/assets/',
    'DESTINATION': './public/assets/',
    'BOWER': './resources/assets/bower/',

};

var elixir = require('laravel-elixir');
var gulp = require('gulp');
var imagemin = require('gulp-imagemin');
var pngquant = require('imagemin-pngquant');

require('laravel-elixir-vue-2');

// gulp.task('imagemin', function () {
//     return gulp.src(paths.SOURCE + 'images/**/*.{png,jpg,gif}')
//         .pipe(imagemin({
//             progressive: true,
//             svgoPlugins: [{removeViewBox: false}],
//             use: [pngquant()]
//         }))
//         .pipe(gulp.dest(paths.DESTINATION + 'images'));
// });


elixir(function (mix) {

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

    mix.sass('app.scss', paths.SOURCE + 'css');
    mix.webpack('app.js', paths.DESTINATION + 'js/app.js');

    mix.scripts([
        paths.BOWER + 'html5shiv/dist/html5shiv.min.js',
        paths.BOWER + 'respond/dest/respond.min.js',
    ], paths.DESTINATION + 'js/ie.js');

    mix.scripts([
        paths.SOURCE + 'js/generated/laroute.js',
        paths.BOWER + 'jquery/dist/jquery.min.js',
        paths.BOWER + 'bootstrap/dist/js/bootstrap.min.js',
    ], paths.DESTINATION + 'js/build.js');

    mix.styles([
        // paths.BOWER + 'bootstrap/dist/css/bootstrap.min.css',
        paths.SOURCE + 'css/app.css'
    ], paths.DESTINATION + 'css/app.css');
});
