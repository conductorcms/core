var gulp = require('gulp')
    concat         = require('gulp-concat')
    uglify         = require('gulp-uglify')
    sass           = require('gulp-ruby-sass')
    watch          = require('gulp-watch')
    templateCache  = require('gulp-angular-templatecache')
    annotate       = require('gulp-ng-annotate')
	jsonEdit	   = require('gulp-json-editor');

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

// convert asset paths to host paths
// to allow for gulp tasks to be
// ran from the host if
// using Vagrant
gulp.task('assets:convertPaths', function()
{
	var hostPath = __dirname + '/';
	hostPath = hostPath.substring(0, hostPath.indexOf('\\workbench\\')) + '\\workbench\\';
	var vagrantPath = assets.js[1].substring(0, assets.js[1].indexOf('/conductor/')) + '/';

	console.log(hostPath);
	console.log(vagrantPath);

	for(var ii in assets.js)
	{
		assets.js[ii] = assets.js[ii].split(vagrantPath).join(hostPath);
	}

	gulp.src('./asset_manifest.json')
		.pipe(jsonEdit(function(json)
		{
			json.js = assets.js;
			return json;
		},
			{
				'inden_char': ' ',
				'indent_size': 4
			}))
		.pipe(gulp.dest('./'));

	console.log(assets.js);
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
