var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
// var uglify = require('gulp-uglify');
// var rename = require('gulp-rename');

var webpackStream = require("webpack-stream");
var webpack = require("webpack");
var webpackConfig = require("./webpack.config");

var AUTOPREFIXER_BROWSERS = [
  'last 2 version',
  'ie >= 9',
  'iOS >= 7',
  'Android >= 4.2'
];

var src = {
  'scss': ['src/scss/style.scss'],
  'scssWatch': 'src/**/*.scss',
  'js': ['src/**/*.js']
};

var dest = {
  'css': 'htdocs/assets/css/',
  'js': 'htdocs/assets/js/',
};

//webpackによるバンドル(htdocsに)
gulp.task('bundle1', function(){
  return webpackStream(webpackConfig, webpack)
  .pipe(gulp.dest(dest.js));
});

//webpackによるバンドル(staticに)
gulp.task('bundle2', function(){
  return webpackStream(webpackConfig, webpack)
  .pipe(gulp.dest('static/assets/js/'));
});

//Sassのコンパイル(htdocsに)
gulp.task('sass1', function(){
  return gulp.src(src.scss)
  .pipe(sass({outputStyle: 'compressed'})).on("error", sass.logError)
  .pipe(autoprefixer(AUTOPREFIXER_BROWSERS))
  .pipe(gulp.dest(dest.css));
});

//Sassのコンパイル(staticに)
gulp.task('sass2', function(){
  return gulp.src(src.scss)
  .pipe(sass({outputStyle: 'compressed'})).on("error", sass.logError)
  .pipe(autoprefixer(AUTOPREFIXER_BROWSERS))
  .pipe(gulp.dest('static/assets/css/'));
});

//watchタスク
gulp.task('watch', function() {
  gulp.watch(src.scssWatch, gulp.task('sass1'));
  gulp.watch(src.scssWatch, gulp.task('sass2'));
  gulp.watch(src.js, gulp.task('bundle1'));
  gulp.watch(src.js, gulp.task('bundle2'));
});

//defaultタスク
gulp.task('default',
  gulp.series('bundle1','bundle2','sass1','sass2','watch')
);