var paths = {
    'SOURCE': './resources/assets/',
    'DESTINATION': './public/assets/',
    'BOWER': './bower_components/'
};

var elixir = require('laravel-elixir');
var gulp = require('gulp');
var imagemin = require('gulp-imagemin');
var pngquant = require('imagemin-pngquant');


gulp.task('imagemin', function () {
    return gulp.src(paths.SOURCE + 'images/**/*.{png,jpg,gif}')
        .pipe(imagemin({
            progressive: true,
            svgoPlugins: [{removeViewBox: false}],
            use: [pngquant()]
        }))
        .pipe(gulp.dest(paths.DESTINATION + 'images'));
});


elixir(function(mix) {

    mix.sass('style.scss', paths.DESTINATION + 'css').version('public/assets/css/style.css');

    mix.styles(paths.BOWER + 'normalize-css/normalize.css', paths.DESTINATION + 'css/normalize.css', './');

    mix.scripts(paths.BOWER + 'jquery/dist/jquery.js', paths.DESTINATION + 'js/jquery.js', './');
    mix.scripts(paths.BOWER + 'modernizr/modernizr.js', paths.DESTINATION + 'js/modernizr.js', './');

    mix.copy(paths.SOURCE + 'images', paths.DESTINATION + 'images');

    mix.scriptsIn(paths.SOURCE + 'js/frontend', paths.DESTINATION + 'js/frontend.js');

});
