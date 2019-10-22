var htmlmin = require('gulp-htmlmin');
var gulp = require('gulp');

gulp.task('normal', function(){
  gulp.src('./index.html')
  .pipe(htmlmin())
  .pipe(gulp.dest('./build'));
});

gulp.task('collapse', function(){
  gulp.src('./index.html')
  .pipe(htmlmin({collapseWhitespace: true}))
  .pipe(gulp.dest('./build'));
});
