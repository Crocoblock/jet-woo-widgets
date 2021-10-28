let rename       = require( 'gulp-rename' ),
	sass         = require( 'gulp-sass' ),
	notify       = require( 'gulp-notify' ),
	autoprefixer = require( 'gulp-autoprefixer' );

const { src, dest, task, watch, series, parallel } = require( 'gulp' );

task('styles', function() {
	return src('assets/scss/jet-woo-widgets.scss')
		.pipe(sass({
			errorLogToConsole: true,
			outputStyle      : 'compressed'
		}))
		.on('error', console.error.bind(console))
		.pipe(autoprefixer({
			browsers: ['last 10 versions'],
			cascade : false
		}))
		.pipe(dest('./assets/css/'))
		.pipe(notify('Compile Admin Sass Done!'));
});

task('default', parallel('styles'));

task('watch', function() {
	watch('assets/scss/**/*.scss', series('styles'));
});