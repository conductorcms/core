var gulp     = require('gulp')
    concat   = require('gulp-concat')
    uglify   = require('gulp-uglify')
    sass     = require('gulp-sass')
    watch    = require('gulp-watch')
    annotate = require('gulp-ng-annotate');
    assets   = require('./asset_manifest.json');

if(assets.js === undefined)
{
    assets.js = [];
}
assets.js.unshift('./public/assets/js/angular/**/*.js');

gulp.task('list:assets', function()
{
    console.log('Assets found: ' + assets.length);
    for(var ii in assets)
    {
        console.log(assets[ii]);
    }
});

gulp.task('build', function()
{
    gulp.src(assets.js)
        .pipe(annotate())
        .pipe(concat('conductor.js'))
        .pipe(uglify())
        .pipe(gulp.dest('../../../public/packages/mattnmoore/conductor/assets/js/'))
});

gulp.task('watch', function()
{
    gulp.watch(assets, ['build']);
});
