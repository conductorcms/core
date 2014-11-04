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
var coreAssets = require('./core.json').assets;

// get core assets
assets.admin.js = coreAssets.admin.js.concat(assets.admin.js);
assets.admin.sass = coreAssets.admin.sass.concat(assets.admin.sass);

// get views
for(var ii in coreAssets.admin.views) {

    assets.admin.views[ii] = coreAssets.admin.views[ii];

}

gulp.task('build:admin:js', ['build:admin:views'], function() {

    var path = '../../../public/conductor/admin/js/';

    return buildJs(assets.admin.js, 'conductor.min.js', path);
});

gulp.task('build:frontend:js', function() {

    var path = '../../../public/conductor/frontend/js/';

    return buildJs(assets.frontend.js, 'conductor.min.js', path);
});


gulp.task('build:admin:dependencies:js', function() {

    var path = '../../../public/conductor/admin/js';

    return buildDependencies('admin', 'js', 'dependencies.min.js', path)
});

gulp.task('build:admin:dependencies:styles', function() {

    var path = '../../../public/conductor/admin/css';

    return buildDependencies('admin', 'css', 'dependencies.css', path);
});

gulp.task('build:admin:sass', function() {

    var path = '../../../public/conductor/admin/css';

    return buildSass(assets.admin.sass, 'admin.css', path);
});

gulp.task('build:frontend:sass', function() {

    var path = '../../../public/conductor/frontend/css';

    return buildSass(assets.frontend.sass, 'main.css', path);
});

gulp.task('build:admin:views', function() {

    for(var module in assets.admin.views) {
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

	for(var ii in assets.admin.views) {
		views = views.concat(assets.admin.views[ii]);
	}
	var watch = assets.admin.js.concat(assets.admin.sass, views);

	gulp.watch(watch, ['build:admin']);

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

function getDependencies(group, type) {

    var dependencies = coreAssets[group].dependencies[type];

    if(assets[group].dependencies && assets[group].dependencies[type]) {
        dependencies = dependencies.concat(assets[group].dependencies[type]);
    }

    return dependencies;
}

// grouped tasks
gulp.task('build:admin:dependencies', ['build:admin:dependencies:js', 'build:admin:dependencies:styles']);
gulp.task('build:admin', ['build:admin:js', 'build:admin:sass']);

gulp.task('build:frontend:dependencies', ['build:frontend:dependencies:js', 'build:frontend:dependencies:styles']);
gulp.task('build:frontend', ['build:frontend:js', 'build:frontend:sass'])

gulp.task('build:all', ['build:admin:dependencies', 'build:admin']);