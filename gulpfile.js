var gulp = require('gulp')
    concat         = require('gulp-concat')
    uglify         = require('gulp-uglify')
    sass           = require('gulp-ruby-sass')
    watch          = require('gulp-watch')
    templateCache  = require('gulp-angular-templatecache')
    annotate       = require('gulp-ng-annotate')
    argv           = require('yargs').argv
    gulpif         = require('gulp-if')
    sourcemaps     = require('gulp-sourcemaps');

var assets = require('./asset_manifest.json');

//get core assets
setCoreAssets();

gulp.task('list:assets', function()
{
    console.log('js assets:');
    listAssets('admin', 'js');
    console.log('sass assets:');
    listAssets('admin', 'sass');
    console.log('views:');
    listAssets('admin', 'views');
});

gulp.task('build:admin:js', ['build:admin:views'], function()
{
    var path = '../../../public/conductor/admin/js/';

    return buildJs(assets.admin.js, path, 'conductor.min.js');
});

gulp.task('build:frontend:js', function()
{
    var path = '../../../public/conductor/frontend/js/';

    return buildJs(assets.frontend.js, path, 'conductor.min.js');
});


gulp.task('build:admin:dependencies:js', function()
{
    var dependencies = getJsDependencies();

    gulp.src(dependencies)
        .pipe(gulpif(!argv.production, sourcemaps.init()))
            .pipe(annotate())
            .pipe(concat('dependencies.min.js'))
            .pipe(uglify())
        .pipe(gulpif(!argv.production, sourcemaps.write('./maps')))
        .pipe(gulp.dest('../../../public/conductor/admin/js'))
});

gulp.task('build:admin:dependencies:styles', function()
{
	var dependencies = getStyleDependencies();

	gulp.src(dependencies)
		.pipe(concat('dependencies.css'))
		.pipe(gulp.dest('../../../public/conductor/admin/css'));
});


gulp.task('build:admin:sass', function()
{
    return gulp.src(assets.admin.sass)
        .pipe(sass({sourcemaps: false}))
		.on('error', function (err) { console.log(err.message); })
        .pipe(concat('admin.css'))
		.pipe(gulp.dest('../../../public/conductor/admin/css'));
});

gulp.task('build:frontend:sass', function()
{
    return gulp.src(assets.frontend.sass)
        .pipe(sass({sourcemaps: false}))
        .on('error', function (err) { console.log(err.message); })
        .pipe(concat('main.css'))
        .pipe(gulp.dest('../../../public/conductor/frontend/css'));
});

gulp.task('build:admin:views', function()
{
    for(var module in assets.admin.views)
    {
        var options = {
            filename: module + '.js',
            module: 'admin.' + module + '.templates',
            root: module,
            standalone: true
        }

        gulp.src(assets.admin.views[module])
            .pipe(templateCache(options))
            .pipe(gulp.dest('./resources/js/templates'))
    }
});

gulp.task('watch:admin', function () {
	var views = [];
	for(var ii in assets.admin.views)
	{
		views = views.concat(assets.admin.views[ii]);
	}
	var watch = assets.admin.js.concat(assets.admin.sass, views);
	gulp.watch(watch, ['build:admin:js']);
});

gulp.task('build:admin:dependencies', ['build:admin:dependencies:js', 'build:admin:dependencies:styles']);
gulp.task('build:admin', ['build:admin:js', 'build:admin:sass']);

gulp.task('build:frontend:dependencies', ['build:frontend:dependencies:js', 'build:frontend:dependencies:styles']);
gulp.task('build:frontend', ['build:frontend:js', 'build:frontend:sass'])

gulp.task('build:all', ['build:admin:dependencies', 'build:admin', 'build:frontend:dependencies', 'build:frontend']);

//helper functions

function setCoreAssets()
{
    setCoreAssetType('admin', 'js');
    setCoreAssetType('admin', 'sass');
    setCoreAssetType('admin', 'views');
}

function setCoreAssetType(group, type)
{
    if(assets[group][type] === undefined)
    {
        assets[group][type] = [];
    }

    addCoreAssets(group, type);
}

function addCoreAssets(group, type)
{
    switch(type)
    {
        case 'js':
            assets[group]['js'].unshift('./resources/js/**/*.js');
            break;
        case 'sass':
            assets[group]['sass'].unshift('./resources/sass/**/*.scss');
            break;
        case 'views':
            assets[group].views.core = [];
            assets[group].views.core.unshift('./resources/views/**/*.html');
            break;
    }
}

function listAssets(group, type)
{
    for(var ii in assets[group][type])
    {
        console.log(assets[group][type][ii]);
    }
}

function getJsDependencies()
{
    var dependencies = [
        'angular/angular.js',
        'angular-animate/angular-animate.js',
        'angular-bootstrap/ui-bootstrap.js',
        'angular-bootstrap/ui-bootstrap-tpls.js',
        'angular-route/angular-route.js',
        'AngularJS-Toaster/toaster.js',
		'textAngular/src/textAngular-rangy.min.js',
		'textAngular/src/textAngularSetup.js',
		'textAngular/src/textAngular.js',
		'textAngular/src/textAngular-sanitize.js',
		'angular-slugify/angular-slugify.js',
        'angular-native-dragdrop/draganddrop.js',
    ];

	return prefixDependencies('./resources/vendor/', dependencies);
}

function getStyleDependencies()
{
    var dependencies = [
		'admin-lte/css/AdminLTE.css',
		'AngularJS-Toaster/toaster.css',
		'textAngular/src/textAngular.css'
	];

	return prefixDependencies('./resources/vendor/', dependencies);
}

function prefixDependencies(prefix, dependencies)
{
	for(var ii in dependencies)
	{
		dependencies[ii] = prefix + dependencies[ii];
	}

	return dependencies;
}

function buildJs(assets, sourcePath, sourceName)
{
    return gulp.src(assets)
        .pipe(gulpif(!argv.production, sourcemaps.init()))
            .pipe(annotate())
            .pipe(concat(sourceName))
            .pipe(uglify())
        .pipe(gulpif(!argv.production, sourcemaps.write('./maps')))
        .pipe(gulp.dest(sourcePath))
}
