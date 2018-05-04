var
    gulp = require("gulp"),
    livereload = require("gulp-livereload");

gulp.task("reload", function () {
    gulp.src('./css/*.css')
        .pipe(livereload());
    gulp.src('./*.php')
        .pipe(livereload());
    gulp.src('./admin/*.php')
        .pipe(livereload());
});

gulp.task("default", function () {
    livereload.listen();
    gulp.watch('./css/*.css', ['reload']);
    gulp.watch('./*.php', ['reload']);
    gulp.watch('./admin/*.php', ['reload']);
});