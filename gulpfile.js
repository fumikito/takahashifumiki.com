var gulp        = require('gulp'),
    fs          = require('fs'),
    $           = require('gulp-load-plugins')(),
    pngquant    = require('imagemin-pngquant'),
    eventStream = require('event-stream');


// Sassのタスク
gulp.task('sass', function () {

  return gulp.src(['./src/scss/**/*.scss'])
    .pipe($.plumber({
      errorHandler: $.notify.onError('<%= error.message %>')
    }))
    .pipe($.sassBulkImport())
    .pipe($.sourcemaps.init())
    .pipe($.sass({
      errLogToConsole: true,
      outputStyle    : 'compressed',
      sourceComments : 'normal',
      sourcemap      : true,
      includePaths   : [
        './src/scss',
        './node_modules/bootstrap-sass/assets/stylesheets',
        './node_modules/bootstrap-material-design/sass'
      ]
    }))
    .pipe($.sourcemaps.write('./map'))
    .pipe(gulp.dest('./assets/css'));
});


// Minify All
gulp.task('jsconcat', function () {
  return gulp.src(['./src/js/**/*.js'])
    .pipe($.plumber({
      errorHandler: $.notify.onError('<%= error.message %>')
    }))
    .pipe($.sourcemaps.init({
      loadMaps: true
    }))
    .pipe($.include())
    .pipe($.uglify({
      output:{
        comments: /^!/
      }
    }))
    .pipe($.sourcemaps.write('./map'))
    .pipe(gulp.dest('./assets/js/'));
});


// JS Hint
gulp.task('jshint', function () {
  return gulp.src([
    './src/js/**/*.js'
  ])
    .pipe($.jshint('./src/.jshintrc'))
    .pipe($.jshint.reporter('jshint-stylish'));
});

// JS task
gulp.task('js', ['jshint', 'jsconcat']);

// Build Libraries.
gulp.task('copylib', function () {
  return eventStream.merge(
    // Copy Bootstrap-materials
    gulp.src([
      './node_modules/arrive/minified/arrive.min.js',
      './node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js',
      './node_modules/bootstrap-material-design/dist/js/material.min.js',
      './node_modules/bootstrap-material-design/dist/js/material.min.js.map',
      './node_modules/bootstrap-material-design/dist/js/ripples.min.js.map',
      './node_modules/bootstrap-material-design/dist/js/ripples.min.js'
    ])
      .pipe(gulp.dest('./assets/js/')),
    // Copy Bootstrap-materials
    gulp.src([
      './node_modules/bootstrap-material-design/dist/css/ripples.min.css',
      './node_modules/bootstrap-material-design/dist/css/ripples.min.css.map'
    ])
      .pipe(gulp.dest('./assets/css/')),
    // Build unpacked Libraries.
    gulp.src([
      './node_modules/html5shiv/dist/html5shiv.js',
      './node_modules/respond.js/dest/respond.src.js'
    ])
      .pipe($.uglify())
      .pipe(gulp.dest('./assets/js/')),
    // Copy headroom
    gulp.src([
      './node_modules/headroom.js/dist/headroom.min.js',
      './node_modules/headroom.js/dist/jQuery.headroom.min.js'
    ]).pipe(gulp.dest('./assets/js'))
  );
});

// Image min
gulp.task('imagemin', function () {
  return gulp.src('./src/img/**/*')
    .pipe($.imagemin({
      progressive: true,
      svgoPlugins: [{removeViewBox: false}],
      use        : [pngquant()]
    }))
    .pipe(gulp.dest('./assets/img'));
});


// watch
gulp.task('watch', function () {
  // Make SASS
  gulp.watch('src/scss/**/*.scss', ['sass']);
  // Uglify all
  gulp.watch(['src/js/**/*.js'], ['js']);
  // Minify Image
  gulp.watch('src/img/**/*', ['imagemin']);
});

// Build
gulp.task('build', ['copylib', 'js', 'sass', 'imagemin']);

// Default Tasks
gulp.task('default', ['watch']);

