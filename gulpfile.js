import process from "node:process";
import gulp from 'gulp';
import rev from 'gulp-rev';
import sourcemaps from 'gulp-sourcemaps';
import autoprefixer from 'gulp-autoprefixer';
import {deleteAsync} from 'del'
import cleanCss from 'gulp-clean-css';
import gulpIf from 'gulp-if';
import dartSass from 'sass';
import gulpSass from 'gulp-sass';
const sass = gulpSass( dartSass );

const buildDir  = './public'
const assetsDir = './assets'

const isDev = process.env['APP_MODE'] === 'dev';

const cleanCssOpt = {}
if (isDev) {
    cleanCssOpt['format'] = 'beautify'
}

function buildStyles() {
    return gulp.src(`${assetsDir}/*.scss`)
        .pipe(gulpIf(isDev, sourcemaps.init()))
        .pipe(sass().on('error', sass.logError))
        .pipe(autoprefixer())
        .pipe(cleanCss(cleanCssOpt))
        .pipe(gulpIf(isDev, sourcemaps.write()))
        .pipe(rev())
        .pipe(gulp.dest(buildDir))
        .pipe(rev.manifest())
        .pipe(gulp.dest(buildDir))
}

function clean() {
    return deleteAsync(`${buildDir}/*.(css|json)`)
}

const build = gulp.series(clean, buildStyles);

export {buildStyles, build};
