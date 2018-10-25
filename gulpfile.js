const gulp = require('gulp');
const connect = require('gulp-connect-php');
const sync = require('browser-sync');
const less = require('gulp-less');
const cleanCSS = require('gulp-clean-css');

gulp.task('connect-sync', () => {
    connect.server({
        base: 'public'
    }, () => {
        sync({
            injectChanges: true,
            proxy: '127.0.0.1:8000'
        });
    });
    gulp.start('watch');
});

// Less file
gulp.task('less', () => {
    gulp.src('./public/**/*.less')
        .pipe(less())
        .pipe(gulp.dest('./public'));
});

// Minify CSS
gulp.task('minify-css', () => {
    gulp.src('./public/**/*.css')
        .pipe(cleanCSS())
        .pipe(gulp.dest('./public'));
});

// Watch for changes
gulp.task('watch', () => {
    gulp.watch('./public/**/*.less', ['less']).on('change', () => {
        sync.reload();
    });
    gulp.watch('./public/**/*.css', ['minify-css']).on('change');
    gulp.watch('public/*.php').on('change', () => {
        sync.reload();
    });
});

gulp.task('default', ['connect-sync', 'watch']);