/*
 * GULP CONFIG
 *
 * Desciption:  Clean gulpfile for web development workflow containing
 *              - compiling/optimization of sass, javascript and images from assets to dist and vendors
 *              - browsersync
 *              - cache-busting
 *              - modernizr
 *              - vendor handling through glulp-vendors.json
 *
 * Usage:       - `gulp` (to run the whole process)
 *              - `gulp watch` (to watch for changes and compile if anything is being modified)
 *              - `modernizr -c assets/scripts/modernizr-config.json -d assets/scripts` to generate the modernizr.js file from the config-file
 *              - add vendor-requirements to gulp-vendors.json, they will be compiled/bundled by `gulp` (restart `gulp watch`)
 *
 * Author:      David Voglgsang
 *
 * Version:     1.0
 *
*/


/* SETTINGS
/===================================================== */
// local domain used by browsersync
var browsersync_proxy = "development.vm";

// default asset paths
var assets = {
  css: ['assets/styles/styles.scss'],
  responsive_desktop: ['assets/styles/responsive/desktop.scss'],
  responsive_contentW: ['assets/styles/responsive/content-width.scss'],
  responsive_wideW: ['assets/styles/responsive/wide-width.scss'],
  responsive_popup: ['assets/styles/responsive/popup.scss'],
  responsive_mobile: ['assets/styles/responsive/mobile.scss'],
  css_watch: ['assets/styles/*.scss'],
  javascript: ['assets/scripts/*.js']
}


/* DEPENDENCIES
/===================================================== */
// general
const gulp = require('gulp');
const babel = require('gulp-babel');
const concat = require('gulp-concat');
const rename = require("gulp-rename");
const order = require("gulp-order");
const browserSync = require('browser-sync').create();
// css
const sass = require('gulp-sass');
const cleanCSS = require('gulp-clean-css');
const autoprefixer = require('gulp-autoprefixer');
// cache busting
const rev = require('gulp-rev');
// js
const uglify = require('gulp-uglify');
// images
const imagemin = require('gulp-imagemin');
// error handling with notify & plumber
const notify = require("gulp-notify");
const plumber = require('gulp-plumber');
// watch
const watch = require('gulp-watch');
// delete
const del = require('del');


/* TASKS
/===================================================== */

/* CLEAN
/––––––––––––––––––––––––*/
// delete compiled files/folders (before running the build)
// css
gulp.task('clean:css', function() { return del(['dist/*.css'])});
gulp.task('clean:javascript', function() { return del(['dist/*.js'])});

/* BROWSERSYNC
/––––––––––––––––––––––––*/
// initialize Browser Sync
gulp.task('browsersync', function() {
  browserSync.init({
    proxy: browsersync_proxy,
    notify: false,
    open: false,
    snippetOptions: {
      whitelist: ['/wp-admin/admin-ajax.php'],
      blacklist: ['/wp-admin/**']
    }
  });
});


/* CSS
/––––––––––––––––––––––––*/
// from:    assets/styles/main.css
// actions: compile, minify, prefix, rename
// to:      dist/style.min.css
gulp.task('css', function() {
  return gulp
    .src(assets['css'])
    .pipe(plumber({errorHandler: notify.onError("<%= error.message %>")}))
    .pipe(concat('style.min.css'))
    .pipe(sass())
    .pipe(autoprefixer('last 2 version', { cascade: false }))
    .pipe(cleanCSS())
    .pipe(rename('dist/style.min.css'))
    .pipe(gulp.dest('./'))
    .pipe(browserSync.stream());
});

gulp.task('responsive_desktop', function() {
  return gulp
    .src(assets['responsive_desktop'])
    .pipe(plumber({errorHandler: notify.onError("<%= error.message %>")}))
    .pipe(concat('responsive_desktop.css'))
    .pipe(sass())
    .pipe(autoprefixer('last 2 version', { cascade: false }))
    .pipe(cleanCSS())
    .pipe(rename('dist/responsive_desktop.css'))
    .pipe(gulp.dest('./'))
    .pipe(browserSync.stream());
});
gulp.task('responsive_contentW', function() {
  return gulp
    .src(assets['responsive_contentW'])
    .pipe(plumber({errorHandler: notify.onError("<%= error.message %>")}))
    .pipe(concat('responsive_contentW.css'))
    .pipe(sass())
    .pipe(autoprefixer('last 2 version', { cascade: false }))
    .pipe(cleanCSS())
    .pipe(rename('dist/responsive_contentW.css'))
    .pipe(gulp.dest('./'))
    .pipe(browserSync.stream());
});
gulp.task('responsive_wideW', function() {
  return gulp
    .src(assets['responsive_wideW'])
    .pipe(plumber({errorHandler: notify.onError("<%= error.message %>")}))
    .pipe(concat('responsive_wideW.css'))
    .pipe(sass())
    .pipe(autoprefixer('last 2 version', { cascade: false }))
    .pipe(cleanCSS())
    .pipe(rename('dist/responsive_wideW.css'))
    .pipe(gulp.dest('./'))
    .pipe(browserSync.stream());
});
gulp.task('responsive_popup', function() {
  return gulp
    .src(assets['responsive_popup'])
    .pipe(plumber({errorHandler: notify.onError("<%= error.message %>")}))
    .pipe(concat('responsive_popup.css'))
    .pipe(sass())
    .pipe(autoprefixer('last 2 version', { cascade: false }))
    .pipe(cleanCSS())
    .pipe(rename('dist/responsive_popup.css'))
    .pipe(gulp.dest('./'))
    .pipe(browserSync.stream());
});
gulp.task('responsive_mobile', function() {
  return gulp
    .src(assets['responsive_mobile'])
    .pipe(plumber({errorHandler: notify.onError("<%= error.message %>")}))
    .pipe(concat('responsive_mobile.css'))
    .pipe(sass())
    .pipe(autoprefixer('last 2 version', { cascade: false }))
    .pipe(cleanCSS())
    .pipe(rename('dist/responsive_mobile.css'))
    .pipe(gulp.dest('./'))
    .pipe(browserSync.stream());
});



/* JAVASCRIPT
/––––––––––––––––––––––––*/
// from:    assets/scripts/
// actions: concatinate, minify, rename
// to:      dist/script.min.css
// note:    modernizr.js is concatinated first in .pipe(order)
gulp.task('javascript', gulp.series('clean:javascript', function() {
  return gulp
    .src(assets['javascript'])
    .pipe(order([
      'assets/scripts/*.js'
    ], { base: './' }))
    .pipe(plumber({errorHandler: notify.onError("<%= error.message %>")}))
    .pipe(concat('script.min.js'))
    .pipe(babel({
      presets: ['@babel/preset-env']
    }))
    .pipe(uglify())
    .pipe(rename('dist/script.min.js'))
    .pipe(gulp.dest('./'))
    .pipe(browserSync.stream());
}));



/* WATCH
/––––––––––––––––––––––––*/
// watch for modifications in
// styles, scripts, images, php files, html files
gulp.task('watch', gulp.parallel('browsersync', function() {
  watch(assets['css_watch'], gulp.series('css'));
  watch(assets['javascript'], gulp.series('javascript'));
  watch('*.php', browserSync.reload);
  watch('*.html', browserSync.reload);
}));



/* DEFAULT
/––––––––––––––––––––––––*/
// default gulp tasks executed with `gulp`
gulp.task('default', gulp.series('css', 'responsive_desktop', 'responsive_contentW', 'responsive_wideW', 'responsive_popup', 'responsive_mobile', 'javascript'));
