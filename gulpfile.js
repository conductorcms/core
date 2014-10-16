var gulp = require('gulp')
    concat         = require('gulp-concat')
    uglify         = require('gulp-uglify')
    sass           = require('gulp-sass')
    watch          = require('gulp-watch')
    templateCache  = require('gulp-angular-templatecache')
    annotate       = require('gulp-ng-annotate');

var assets = require('./asset_manifest.json');

//get core assets
setCoreAssets();

gulp.task('list:assets', function()
{
    console.log('js assets:');
    listAssets('js');
    console.log('sass assets:');
    listAssets('sass');
    console.log('views:');
    listAssets('views');
});

gulp.task('build:js', function()
{
    for(var ii in assets.js)
    {
        console.log(assets.js[ii]);
    }

    gulp.src(assets.js)
        .pipe(annotate())
        .pipe(concat('conductor.js'))
        .pipe(uglify())
        .pipe(gulp.dest('../../../public/conductor/admin/js/'))
});

gulp.task('build:sass', function()
{
    gulp.src(assets.sass)
        .pipe(concat('main.css'))
        .pipe(sass())
        .pipe(gulp.dest('../../../public/conductor/admin/css/'))
});

gulp.task('build:views', function()
{
    console.log(assets.views);

    for(var module in assets.views)
    {
        var options = {
            filename: module + '.js',
            module: 'admin.' + module + '.templates',
            root: module,
            standalone: true
        }

        gulp.src(assets.views[module])
            .pipe(templateCache(options))
            .pipe(gulp.dest('./resources/js/templates'))
    }

    //for(var ii in assets.views)
    //{
    //    console.log(assets.views[ii]);
    //    //gulp.src(sources)
    //    //    .pipe((templateCache()))
    //    //    .pipe(gulp.dest('./resources/js/templates'))
    //}



});

gulp.task('build', ['build:js', 'build:sass']);

gulp.task('watch', function () {
    gulp.watch(assets, ['build']);
});


function setCoreAssets()
{
    setCoreAssetType('js');
    setCoreAssetType('sass');
    setCoreAssetType('views');
}

function setCoreAssetType(type)
{
    if(assets[type] === undefined)
    {
        assets[type] = [];
    }

    addCoreAssets(type);
}

function addCoreAssets(type)
{
    switch(type)
    {
        case 'js':
            assets.js.unshift('./resources/js/**/*.js');
            break;
        case 'sass':
            assets.sass.unshift('./resources/sass/**/*.scss');
            break;
        case 'views':
            assets.views.core = [];
            assets.views.core.unshift('./resources/views/**/*.html');
            break;

    }
}

function listAssets(type)
{
    for(var ii in assets[type])
    {
        console.log(assets[type][ii]);
    }
}
