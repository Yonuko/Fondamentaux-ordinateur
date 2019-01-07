// source: https://github.com/gulpjs/gulp/blob/master/docs/recipes/fast-browserify-builds-with-watchify.md
var gulp = require('gulp');
var browserify = require('browserify');
var stringify = require('stringify');
var watchify = require('watchify');
var source = require('vinyl-source-stream');
var buffer = require('vinyl-buffer');
var gutil = require('gulp-util');
var sourcemaps = require('gulp-sourcemaps');
var assign = require('lodash.assign');
var livereload = require('gulp-livereload');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');
var sass = require('gulp-ruby-sass');
var prefix = require('gulp-autoprefixer');
var babelify = require('babelify');
var iconfont = require('gulp-iconfont')
var iconfontCss = require('gulp-iconfont-css')


var opts = assign({}, watchify.args, []);
var b = browserify(opts).transform(babelify);
var w = watchify(b);
var runTimestamp = Math.round(Date.now()/1000);


w.on('log', gutil.log); // output build logs to terminal


// sass
gulp.task('sass', function () {
    var cssStyle =  'compressed';

    return sass('./assets/scss/main.scss', {
      sourcemap: true,
      style: cssStyle
    })
    .pipe(prefix())
    .pipe(sourcemaps.write('.', {
        includeContent: false,
        sourceRoot: './assets/scss'
    }))
    .pipe(rename({suffix: '.min'}))
    .pipe(gulp.dest('./assets/styles/'))
    .pipe(livereload());
});

gulp.task('watch', function() {
    gulp.watch('./assets/scss/**/*.scss', ['sass'])
    .on('change', function(evt) {
        console.log(
            '[watcher] File ' + evt.path.replace(/.*(?=scss)/,'') + ' was ' + evt.type + ', compiling...'
        );
    });
});

// glyphicons
gulp.task('glyphicons', function() {
 return gulp.src('./assets/icons/**/*') // où sont vos svg
    .pipe(iconfontCss({
      fontName: 'icons', // nom de la fonte, doit être identique au nom du plugin iconfont
      targetPath: '../scss/_icons.scss', // emplacement de la css finale
      fontPath: '../fonts/', // emplacement des fontes finales
    }))
    .pipe(iconfont({
      fontName: 'icons', // identique au nom de iconfontCss
      prependUnicode: true,
      formats: ['ttf', 'eot', 'woff', 'woff2', 'svg'],
      timestamp: runTimestamp,
      normalize: true,
      fontHeight: 1001
     }))
    .pipe( gulp.dest('./assets/fonts') )
})

// default
gulp.task('default', ['sass', 'watch']);
