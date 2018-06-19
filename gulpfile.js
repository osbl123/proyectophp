const gulp = require('gulp');
const sass = require('gulp-sass');

gulp.task('sass',()=> {
	return gulp.src([
		'node_modules/bootstrap/scss/bootstrap.scss',
		'plantillas/scss/*.scss'
	])
	.pipe(sass({
		outputStyle:'expanded'
	}))
	.pipe(gulp.dest('public/css'));
})

gulp.task('checksass',['sass'],()=> {
	gulp.watch([
		'node_modules/bootstrap/scss/bootstrap.scss',
		'plantillas/scss/*.scss'
	],['sass']);
})

gulp.task('js',()=> {
	return gulp.src([
		'plantillas/js/*.js'
	])
	.pipe(gulp.dest('public/js'));
})

gulp.task('checkjs',['js'],()=> {
	gulp.watch([
		'plantillas/js/*.js'
	],['js']);
})

gulp.task('libsjs',()=> {
	return gulp.src([
		'node_modules/bootstrap/dist/js/bootstrap.min.js',
		'node_modules/jquery/dist/jquery.min.js',
		'node_modules/popper.js/dist/umd/popper.min.js'
	])
	.pipe(gulp.dest('public/js'));
})


gulp.task('font-awesome', ()=> {
	return gulp.src('node_modules/font-awesome/css/font-awesome.min.css')
		.pipe(gulp.dest('public/css'));
})

gulp.task('fonts',()=>{
	return gulp.src('node_modules/font-awesome/fonts/*')
		.pipe(gulp.dest('public/fonts'));
})

gulp.task('fontsglyphicons',()=>{
	return gulp.src('plantillas/fonts/*')
		.pipe(gulp.dest('public/fonts'));
})

gulp.task('default',['libsjs','checksass','checkjs','font-awesome','fonts','fontsglyphicons']);