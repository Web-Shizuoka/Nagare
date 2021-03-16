var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
// var uglify = require('gulp-uglify');
// var rename = require('gulp-rename');

const concat = require('gulp-concat');
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
  'js': ['src/js/**/*.js', '!src/js/plugins/**/*.js']
};

var dest = {
  'css': 'nagare/assets/css/',
  'js': 'nagare/assets/js/',
};

//plugins内のものをまとめる
gulp.task('plugins', ()=>{
  return gulp.src(['src/js/plugins/*.js'])
  .pipe(concat('plugins.js'))
  .pipe(gulp.dest('nagare/assets/js/'));
});

//webpackによるバンドル(nagareに)
gulp.task('bundle', function(){
  return webpackStream(webpackConfig, webpack)
  .pipe(gulp.dest(dest.js));
});

//Sassのコンパイル(nagareに)
gulp.task('sass', function(){
  return gulp.src(src.scss)
  .pipe(sass({outputStyle: 'compressed'})).on("error", sass.logError)
  .pipe(autoprefixer(AUTOPREFIXER_BROWSERS))
  .pipe(gulp.dest(dest.css));
});

//watchタスク
gulp.task('watch', function() {
  gulp.watch(src.scssWatch, gulp.task('sass'));
  gulp.watch(src.js, gulp.task('bundle'));
});

//defaultタスク
gulp.task('default',
  gulp.series('plugins','bundle','sass','watch')
);