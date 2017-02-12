/*jslint node: true */
"use strict";
var gulp        = require('gulp');
var wpPot       = require('gulp-wp-pot');

gulp.task('pot', function () {
    return gulp.src('**/*.php')
        .pipe(wpPot( {
            domain: 'dogium-dogs',
            package: 'Dogium Dogs'
        } ))
        .pipe(gulp.dest('languages/dogium-dogs.pot'));
});