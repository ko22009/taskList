var gulp			= require('gulp'),
	browserSync	= require('browser-sync'),
	uglify			= require('gulp-uglify'),
	php 				= require('gulp-connect-php'),
	browserify 	= require('browserify'),
	source = require('vinyl-source-stream'),
	buffer = require('vinyl-buffer'),
	sourcemaps = require('gulp-sourcemaps');


gulp.task('php', function(){
	php.server({ base: '.', keepalive:true, hostname: '127.0.0.1', port: 3000, open: false});
});

gulp.task('browser-sync',['php'], function() {
	browserSync({
		proxy: '127.0.0.1:3000',
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

gulp.task('libs', function () {
	// set up the browserify instance on a task basis
	var b = browserify({
		entries: './app/js/app.js',
		debug: false
	});

	return b.bundle()
		.pipe(source('app.js'))
		.pipe(buffer())
		.pipe(sourcemaps.init({loadMaps: true}))
		// Add transformation tasks to the pipeline here.
		.pipe(uglify())
		.pipe(sourcemaps.write('./'))
		.pipe(gulp.dest('./app'));
});

gulp.task('watch', ['libs', 'browser-sync'], function() {
	gulp.watch('app/js/*.js', ['libs', browserSync.reload]);
	gulp.watch('app/views/*.php', browserSync.reload);
});

gulp.task('build', ['libs'], function() {
	gulp.watch('app/js/*.js', ['libs']);
});

gulp.task('default', ['watch']);

gulp.task('build', ['libs'], function() {
});