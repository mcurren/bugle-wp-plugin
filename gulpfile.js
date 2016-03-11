'use strict';

// Include gulp
var gulp = require('gulp'); 

// Include Our Plugins
var sass = require('gulp-sass');
var concat = require('gulp-concat');
// var livereload = require('gulp-livereload');
var browserSync = require('browser-sync').create();
var postcss = require('gulp-postcss');
var sourcemaps = require('gulp-sourcemaps');
var autoprefixer = require('autoprefixer');

// Parse SASS into CSS
gulp.task('sass', function() {
    return gulp.src('scss/*.scss')
        .pipe(sourcemaps.init())
        .pipe(sass({outputStyle: 'expanded'})) // .pipe(sass({outputStyle: 'compressed'}))
        .pipe(postcss([ autoprefixer({ browsers: ['last 2 versions'] }) ]))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('css'))
        // .pipe(browserSync.reload({
        //     stream: true
        // }))
});

// Live-reloading with Browser Sync
gulp.task('browserSync', function() {
  browserSync.init({
    server: {
      baseDir: ''
    },
  })
});

// Watch Files For Changes
gulp.task('watch',/* ['browserSync', 'sass'],*/ function() {
    gulp.watch('scss/**/*.scss', ['sass']);
    // gulp.watch('*.html', browserSync.reload);
});

// Default Task
gulp.task('default', ['sass', 'watch']);