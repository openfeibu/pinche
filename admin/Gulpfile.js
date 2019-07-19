var gulp = require('gulp');
// npm install --save-dev gulp-htmlmin
// 引入组件
var jshint = require('gulp-jshint');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
//自己写的这个工具
var templateCache = require('gulp-require-htmltemplete');
var rename = require('gulp-rename');
var htmlmin = require('gulp-htmlmin');
var cssmin = require("gulp-clean-css");
//修改过
var nameAmd = require('gulp-name-amd');
//这里写需要编译的模块
var moulders=['document','common','project','app'];
// 编译Sass
gulp.task('sass', function() {
    return   gulp.src('src/libs/**/*.scss')
        .pipe(sass())
        .pipe(concat("style.css"))
        .pipe(gulp.dest('./dist/css'))
        .pipe(rename('style.min.css'))
        .pipe(cssmin())
        .pipe(gulp.dest('./dist/css'));
});

// 合并，压缩文件
gulp.task('moulder', function() {
        console.log("正在编译模块");
       function moulder(moulder){
        return   gulp.src("src/"+moulder+"/**/*.js")   //路劲
               .pipe( nameAmd({
                   baseName:"/www/gitweb/lyoa/admin/src/"
               }))
               .pipe(concat(moulder+".js"))
               .pipe(gulp.dest("./dist/js"))
               .pipe(uglify())
               .pipe(rename(moulder+'.min.js'))
               .pipe(gulp.dest("./dist/js"));
       }
         var out=null;
         for(var i=0;i<moulders.length;i++){
             out=moulder(moulders[i]);
         }
         return out;
});


gulp.task('libs', function() {
    //打包lib文件
    return  gulp.src(['src/libs/js/jquery-1.8.1.min.js',
        'src/libs/js/underscore.js',
        'src/libs/js/vue.js',
        'src/libs/js/vue-resource.js',
        'src/libs/js/vue-router.js',
        'src/libs/js/require.js'])
        .pipe(concat("lib.js"))
        .pipe(gulp.dest('./dist/js'))
        .pipe(uglify())
        .pipe(rename('lib.min.js'))
        .pipe(gulp.dest('./dist/js'));
});

gulp.task('tp2js', function(){
    function mouldertp2js(moulder){
        var out=  gulp.src('src/'+moulder+'/**/*.html')
            .pipe(htmlmin({collapseWhitespace: true}))
            .pipe(templateCache({
                baseUrl:'/Admin/src/'+moulder+'/'
            }))
            .pipe(gulp.dest('src/'+moulder));;

    }

    for(var i=0;i<moulders.length;i++){
        out=mouldertp2js(moulders[i]);
    }
    return out;
});

function moulderall(){
    var moulderspath=[];
    for(var i=0;i<moulders.length;i++){
        moulderspath.push("dist/js/"+moulders[i]+".js");
    }
    gulp.src(moulderspath)
        .pipe(concat("all.js"))
        .pipe(gulp.dest('./dist/js'))
        .pipe(uglify())
        .pipe(rename('all.min.js'))
        .pipe(gulp.dest('./dist/js'))
}


// 默认任务
gulp.task('default', function(){
    gulp.run('libs');
    gulp.run('tp2js');
    gulp.run('moulder',function () {
        moulderall();
    });
    gulp.run('sass');
});


// 默认任务
gulp.task('watch', function(){
    var path=moulders.join("|");
    gulp.watch('src/**/*.js', function () {
        gulp.run('moulder');
    });
    gulp.watch('src/**/*.scss', function () {       //当js文件变化后，自动检验 压缩
        gulp.run('sass');
    });
});
