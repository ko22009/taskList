var gulp			= require('gulp'),
	browserSync	= require('browser-sync'),
	uglify			= require('gulp-uglify'),
	browserify 	= require('browserify'),
	source = require('vinyl-source-stream'),
	buffer = require('vinyl-buffer'),
	sourcemaps = require('gulp-sourcemaps'),
	_ = require('lodash');

gulp.task('browser-sync', function() {
	browserSync({
		proxy: '127.0.0.1',
		ui: {
			port: 8081,
			weinre: {
				port: 8082
			}
		},
		open: false,
		port: 8080,
		notify: false
	});
});

gulp.task("libs", function(){
	var destDir = "./app/bundles";

	var bundleThis = function(srcArray) {
		_.each(srcArray, function(src) {
			var bundle = browserify(["./app/assets/js/" + src + ".js"]).bundle();
			bundle.pipe(source(src + ".js"))
				.pipe(buffer())
				.pipe(sourcemaps.init({loadMaps: true}))
				// Add transformation tasks to the pipeline here.
				.pipe(uglify())
				.pipe(sourcemaps.write('./'))
				.pipe(gulp.dest(destDir));
		});
	};
	bundleThis(["list", "app"]);
});

gulp.task('watch', ['libs', 'browser-sync'], function() {
	gulp.watch('app/assets/js/**/*.js', ['libs', browserSync.reload]);
	gulp.watch('app/views/**/*.php', browserSync.reload);
});

gulp.task('build', ['libs'], function() {
	gulp.watch('app/assets/js/**/*.js', ['libs']);
});

gulp.task('default', ['watch']);