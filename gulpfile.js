var gulp = require('gulp')
    concat = require('gulp-concat')
    uglify = require('gulp-uglify')
    sass = require('gulp-sass')
    watch = require('gulp-watch')
    annotate = require('gulp-ng-annotate');
    assets = require('./asset_manifest.json');

if (assets.js === undefined) {
    assets.js = [];
}
assets.js.unshift('./resources/js/angular/**/*.js');


if (assets.sass === undefined) {
    assets.sass = [];
}
assets.sass.unshift('./resources/sass/**/*.scss');

gulp.task('list:assets', function () {
    console.log('Assets found: ' + assets.length);
    for (var ii in assets) {
        console.log(assets[ii]);
    }
});

gulp.task('build:js', function () {
    for(var ii in assets.js)
    {
        console.log(assets.js[ii]);
    }

    gulp.src(assets.js)
        .pipe(annotate())
        .pipe(concat('conductor.js'))
        .pipe(uglify())
        .pipe(gulp.dest('../../../public/packages/mattnmoore/conductor/assets/js/'))
});

gulp.task('build:sass', function () {
    gulp.src(assets.sass)
        .pipe(concat('main.css'))
        .pipe(sass())
        .pipe(gulp.dest('../../../public/packages/mattnmoore/conductor/assets/css/'))
});

gulp.task('build', ['build:js', 'build:sass']);

gulp.task('watch', function () {
    gulp.watch(assets, ['build']);
});
