var gulp           = require('gulp')
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

gulp.task('build:backend:js', ['build:backend:views'], function() {

    var path = '../../../public/conductor/backend/js/';

    return buildJs(assets.backend.js, 'conductor.min.js', path);
});

gulp.task('build:frontend:js', function() {

    var path = '../../../public/conductor/frontend/js/';

    return buildJs(assets.frontend.js, 'conductor.min.js', path);
});


gulp.task('build:backend:dependencies:js', function() {

    var path = '../../../public/conductor/backend/js';

    return buildDependencies('backend', 'js', 'dependencies.min.js', path)
});

gulp.task('build:backend:dependencies:styles', function() {

    var path = '../../../public/conductor/backend/css';

    return buildDependencies('backend', 'css', 'dependencies.css', path);
});

gulp.task('build:frontend:dependencies:js', function() {

    var path = '../../../public/conductor/frontend/js';

    return buildDependencies('frontend', 'js', 'dependencies.min.js', path);
});

gulp.task('build:frontend:dependencies:styles', function() {

    var path = '../../../public/conductor/frontend/css';

    return buildDependencies('frontend', 'css', 'dependencies.css', path);
});

gulp.task('build:backend:sass', function() {

    var path = '../../../public/conductor/backend/css';

    return buildSass(assets.backend.sass, 'backend.css', path);
});

gulp.task('build:frontend:sass', function() {

    var path = '../../../public/conductor/frontend/css';

    return buildSass(assets.frontend.sass, 'main.css', path);
});

gulp.task('build:backend:views', function() {

    for(var module in assets.backend.views) {
        var options = {
            filename: module + '.js',
            module: 'admin.' + module + '.templates',
            root: module,
            standalone: true
        }

        gulp.src(assets.backend.views[module])
            .pipe(templateCache(options))
            .pipe(gulp.dest('./resources/js/templates'))
    }
});

gulp.task('watch:backend', function () {

    var views = [];

	for(var ii in assets.backend.views) {
		views = views.concat(assets.backend.views[ii]);
	}
	var watch = assets.backend.js.concat(assets.backend.sass, views);

	gulp.watch(watch, ['build:backend']);

});

// helper functions
function buildJs(assets, filename, path) {

    return gulp.src(assets)
        .pipe(gulpif(!argv.production, sourcemaps.init()))
            .pipe(annotate())
            .pipe(concat(filename))
            .pipe(uglify())
        .pipe(gulpif(!argv.production, sourcemaps.write('./maps')))
        .pipe(gulp.dest(path))
}

function buildSass(assets, filename, path) {

    return gulp.src(assets)
        .pipe(sass({sourcemaps: false}))
        .on('error', function (err) { console.log(err.message); })
        .pipe(concat(filename))
        .pipe(gulp.dest(path));
}

function buildCss(assets, filename, path) {

    return gulp.src(assets)
        .pipe(concat(filename))
        .pipe(gulp.dest(path));
}

function buildDependencies(group, type, filename, path) {

    var dependencies = getDependencies(group, type);

    if(type == 'js')  return buildJs(dependencies, filename, path);

    if(type == 'css') return buildCss(dependencies, filename, path);
}

function prefixDependencies(dependencies, prefix)
{
	for(var ii in dependencies)
	{
		dependencies[ii] = prefix + dependencies[ii];
	}

	return dependencies;
}

function getDependencies(group, type) {
    var dependencies = [];

    if(assets[group].dependencies && assets[group].dependencies[type]) {
        dependencies = assets[group].dependencies[type];
    }

    return dependencies;
}

// grouped tasks
gulp.task('build:backend:dependencies', ['build:backend:dependencies:js', 'build:backend:dependencies:styles']);
gulp.task('build:backend', ['build:backend:js', 'build:backend:sass']);

gulp.task('build:frontend:dependencies', ['build:frontend:dependencies:js', 'build:frontend:dependencies:styles']);
gulp.task('build:frontend', ['build:frontend:js', 'build:frontend:sass'])

gulp.task('build:all', ['build:backend:dependencies', 'build:backend']);