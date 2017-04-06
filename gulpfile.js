var gulp			= require('gulp'),
	browserSync	= require('browser-sync'),
	uglify			= require('gulp-uglify'),
	browserify 	= require('browserify'),
	source = require('vinyl-source-stream'),
	buffer = require('vinyl-buffer'),
	sourcemaps = require('gulp-sourcemaps'),
	reload = browserSync.reload;

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
	var count = 0;
	var bundleThis = function(srcArray) {
		srcArray.forEach(function(src) {
			count++;
			var bundle = browserify(["./app/assets/js/" + src + ".js"]).bundle();
			bundle.pipe(source(src + ".js"))
				.pipe(buffer())
				.pipe(sourcemaps.init({loadMaps: true}))
				// Add transformation tasks to the pipeline here.
				.pipe(uglify())
				.pipe(sourcemaps.write('./'))
				.pipe(gulp.dest(destDir))
				.pipe(reload({stream:true})); // для каждого файла обновляем браузер
		});
	};
	bundleThis(["list", "app", "task"]);
});

gulp.task('watch', ['libs', 'browser-sync'], function() {
	gulp.watch('app/assets/js/**/*.js', ['libs']);
	gulp.watch('app/views/**/*.php', reload({stream:true}));
});

gulp.task('build', ['libs'], function() {
	gulp.watch('app/assets/js/**/*.js', ['libs']);
});

gulp.task('default', ['watch']);