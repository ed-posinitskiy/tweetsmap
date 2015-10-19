var gulp = require('gulp'),
    wrap = require('gulp-wrap'),
    watch = require('gulp-watch'),
    concat = require('gulp-concat'),
    less = require('gulp-less'),
    rename = require('gulp-rename');

var paths = {
    public: {
        js: 'public/js',
        css: 'public/css',
        img: 'public/img',
        fonts: 'public/fonts'
    },
    scripts: 'frontend/js/*.js',
    images: 'frontend/img/*.*',
    css: 'frontend/css/*.css',
    bootstrap: {
        fonts: 'bower_components/bootstrap/dist/fonts/*.{ttf,woff,eot,svg}',
        js: 'bower_components/bootstrap/dist/js/bootstrap.min.js',
        css: 'bower_components/bootstrap/dist/css/bootstrap.min.css'
    },
    jquery: 'bower_components/jquery/dist/jquery.min.js'
};

/**
 * Copy assets
 */
gulp.task('build-vendor', ['copy-bootstrap-fonts', 'copy-bootstrap-js', 'copy-bootstrap-css', 'copy-jquery']);

gulp.task('copy-bootstrap-fonts', function() {
    return gulp
        .src(paths.bootstrap.fonts)
        .pipe(gulp.dest(paths.public.fonts));
});

gulp.task('copy-bootstrap-css', function() {
    return gulp
        .src(paths.bootstrap.css)
        .pipe(gulp.dest(paths.public.css));
});

gulp.task('copy-bootstrap-js', function() {
    return gulp
        .src(paths.bootstrap.js)
        .pipe(gulp.dest(paths.public.js));
});

gulp.task('copy-jquery', function() {
    return gulp
        .src(paths.jquery)
        .pipe(gulp.dest(paths.public.js));
});

/**
 * Handle custom files
 */
gulp.task('build-custom', ['custom-images', 'custom-js', 'custom-css']);

gulp.task('custom-images', function() {
    return gulp.src(paths.images)
        .pipe(gulp.dest(paths.public.img));
});

gulp.task('custom-js', function() {
    return gulp.src(paths.scripts)
        .pipe(concat('app.js'))
        .pipe(gulp.dest(paths.public.js));
});

gulp.task('custom-css', function() {
    return gulp.src(paths.css)
        .pipe(concat('app.css'))
        .pipe(gulp.dest(paths.public.css));
});

/**
 * Watch custom files
 */
gulp.task('watch', function() {
    gulp.watch([paths.images], ['custom-images']);
    gulp.watch([paths.css], ['custom-css']);
    gulp.watch([paths.scripts], ['custom-js']);
});

/**
 * Gulp tasks
 */
gulp.task('build', ['build-vendor', 'build-custom']);
gulp.task('default', ['build', 'watch']);