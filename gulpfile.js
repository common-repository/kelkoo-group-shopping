'use strict';

var paths = {
  public: {
    sass : 'public/sass/**/*.scss',
    css  : 'public/css/'
  },
  admin: {
    sass : 'admin/sass/**/*.scss',
    css  : 'admin/css/'
  }
}
, gulp = require('gulp')
, sass = require('gulp-sass')
, gcmq = require('gulp-group-css-media-queries')
, watch = require('gulp-watch')
, uglify = require('gulp-uglify')
, minify = require('gulp-minify-css')
, notify = require("gulp-notify")
, pump = require('pump')
, shell = require("gulp-shell")
;

gulp.task('sass-admin', function () {
  return gulp.src(paths.admin.sass)
    .pipe(sass.sync().on('error', sass.logError))
    .pipe(gcmq())
    .pipe(gulp.dest(paths.admin.css))
    .pipe(minify())
    .pipe(gulp.dest(paths.admin.css))
    ;
});

gulp.task('sass-public', function () {
  return gulp.src(paths.public.sass)
    .pipe(sass.sync().on('error', sass.logError))
    .pipe(gcmq())
    .pipe(gulp.dest(paths.public.css))
    .pipe(minify())
    .pipe(gulp.dest(paths.public.css))
    //.pipe(notify("[SASS] public OK"))
    ;
});


gulp.task('scripts-public', function (cb) {
  pump([
         gulp.src('public/scripts/*.js'),
         uglify(),
         gulp.dest('public/js')
       ],
       cb
      );
});

gulp.task('scripts-admin', function (cb) {
  pump([
         gulp.src('admin/scripts/*.js'),
         uglify(),
         gulp.dest('admin/js')
      ],
      cb
     );
});

gulp.task('scripts-public-dev', function (cb) {
  pump([
         gulp.src('public/scripts/*.js'),
         gulp.dest('public/js')
       ],
       cb
      );
});

gulp.task('scripts-admin-dev', function (cb) {
  pump([
         gulp.src('admin/scripts/*.js'),
         gulp.dest('admin/js')
      ],
      cb
     );
});

gulp.task('build', ['sass-public', 'sass-admin', 'scripts-public', 'scripts-admin', 'translate']);

gulp.task('watch', ['build'], function() {
    gulp.watch('public/scripts/*.js',  ['scripts-public-dev']);
    gulp.watch('admin/scripts/*.js',  ['scripts-admin-dev']);
    gulp.watch(paths.admin.sass, ['sass-admin']);
    gulp.watch(paths.public.sass, ['sass-public']);
    gulp.watch('languages/*.po',  ['translate'])
});

gulp.task('translate', () => {
  return gulp.src('languages/*.po', {read: false})
  .pipe(shell([
    'msgfmt -o <%= file.path.replace(".po", ".mo") %> <%= file.path %>'
  ]))
});