// Подключаем Gulp и все необходимые библиотеки
var gulp           = require('gulp'),
		gutil          = require('gulp-util' ),
		sass           = require('gulp-sass'),
		browserSync    = require('browser-sync'),
		cleanCSS       = require('gulp-clean-css'),
		autoprefixer   = require('gulp-autoprefixer'),
		bourbon        = require('node-bourbon'),
		ftp            = require('vinyl-ftp');

// Обновление страниц сайта на локальном сервере
gulp.task('browser-sync', function() {
	browserSync({
		proxy: "vitaminbox",
		notify: false
  });
});

// Компиляция stylesheet.css
gulp.task('sass', function() {
	return gulp.src('catalog/view/theme/vitaminbox/stylesheet/stylesheet.sass')
		.pipe(sass({
			includePaths: bourbon.includePaths
		}).on('error', sass.logError))
		.pipe(autoprefixer(['last 15 versions']))
		.pipe(cleanCSS())
		.pipe(gulp.dest('catalog/view/theme/vitaminbox/stylesheet/'))
		.pipe(browserSync.reload({stream: true}))
});

function reload(done){
  browserSync.reload();
  done();
}

// Выгрузка изменений на хостинг
gulp.task('deploy', function() {
	var conn = ftp.create({
		host:      '93.125.99.124',
		user:      'vitaminlp@vitaminb.vh112.hosterby.com',
		password:  'vitaminbox1122',
		parallel:  10,
		log: gutil.log
	});
	var globs = [
	'catalog/view/theme/vitaminbox/**'
	];
	return gulp.src(globs, {buffer: false})
	.pipe(conn.dest('/shop/catalog/view/theme/vitaminbox/'));
});

// Наблюдение за файлами

gulp.task('watch', function() {
	gulp.watch('catalog/view/theme/vitaminbox/stylesheet/*.sass', gulp.parallel('sass'));
	gulp.watch('catalog/view/theme/vitaminbox/template/**/*.twig', reload);
	gulp.watch('catalog/view/theme/vitaminbox/js/**/*.js', reload);
	gulp.watch('catalog/view/theme/vitaminbox/libs/**/*', reload);
});

gulp.task('default', gulp.parallel('watch', 'sass', 'browser-sync'));
