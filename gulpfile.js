var gulp = require('gulp')
    concat         = require('gulp-concat')
    uglify         = require('gulp-uglify')
    sass           = require('gulp-ruby-sass')
    watch          = require('gulp-watch')
    templateCache  = require('gulp-angular-templatecache')
    annotate       = require('gulp-ng-annotate')

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

gulp.task('build:js', ['build:views'], function()
{
    gulp.src(assets.js)
        .pipe(annotate())
        .pipe(concat('conductor.js'))
        .pipe(uglify())
        .pipe(gulp.dest('../../../public/conductor/admin/js/'))
});

gulp.task('build:dependencies:js', function()
{
    var dependencies = getJsDependencies();

    gulp.src(dependencies)
        .pipe(annotate())
        .pipe(concat('dependencies.js'))
        .pipe(uglify())
        .pipe(gulp.dest('../../../public/conductor/admin/js'))
});

gulp.task('build:dependencies:styles', function()
{
	var dependencies = getStyleDependencies();

	gulp.src(dependencies)
		.pipe(concat('dependencies.css'))
		.pipe(gulp.dest('../../../public/conductor/admin/css'));
});


gulp.task('build:sass', function()
{
    return gulp.src(assets.sass)
        .pipe(sass({sourcemaps: false}))
		.on('error', function (err) { console.log(err.message); })
        .pipe(concat('admin.css'))
		.pipe(gulp.dest('../../../public/conductor/admin/css'));
});

gulp.task('build:views', function()
{
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
});

gulp.task('watch', function () {
	var views = [];
	for(var ii in assets.views)
	{
		views = views.concat(assets.views[ii]);
	}
	var watch = assets.js.concat(assets.sass, views);
	gulp.watch(watch, ['build:js']);
});

gulp.task('build:dependencies', ['build:dependencies:js', 'build:dependencies:styles']);
gulp.task('build', ['build:js', 'build:sass']);
gulp.task('build:all', ['build:dependencies', 'build']);

//helper functions

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
        'angular-strap/dist/angular-strap.js',
        'angular-strap/dist/modules/dimensions.js',
        'angular-strap/dist/angular-strap.tpl.js',
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
