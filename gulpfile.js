const gulp = require('gulp');
const sass = require('gulp-sass');
const autoprefixer = require('gulp-autoprefixer');

const concat = require('gulp-concat');
const webpackStream = require("webpack-stream");
const webpack = require("webpack");
const webpackConfig = require("./webpack.config");
const sourcemaps = require('gulp-sourcemaps');
const minifyCss  = require('gulp-minify-css');

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
  .pipe(sourcemaps.init({largeFile:true}))
  .pipe(sass({
    outputStyle: 'compressed'
  })).on("error", sass.logError)
  .pipe(minifyCss({advanced:false}))
  .pipe(autoprefixer(AUTOPREFIXER_BROWSERS))
  .pipe(sourcemaps.write('./'))
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