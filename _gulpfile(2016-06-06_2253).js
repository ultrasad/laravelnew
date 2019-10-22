//var elixir = require('node_modules/laravel-elixir');
var elixir = require('laravel-elixir');
//require('./elixir-extensions')
/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    //mix.sass('app.scss');
    //mix.browserify('/assets/js/scripts.js');
    //mix.version("public/js/scripts.js");
    /*mix.scripts(
    //['scripts.js', 'module2.js'],
    ['scripts.js'],
      'public/build/js/all.js',
      'public/assets/js'
    );

    mix.version("public/assets/js/scripts.js");

    mix.browserSync({
        online: false,
        proxy : 'localhost:8000'
    });*/

    elixir(function(mix) {
       mix.styles([
           'assets/bootstrap/css/bootstrap.min.css',
           'assets/font-awesome/css/font-awesome.css',
           'assets/jquery-scrollbar/jquery.scrollbar.css',
           'assets/jquery-metrojs/MetroJs.css',
           'assets/fotorama/fotorama.css',
           //'assets/jquery-datatable/media/css/dataTables.bootstrap.min.css',
           'assets/css/pages-icons.css',
           'assets/css/pages-main.css',
           'assets/css/style.css'
       ], 'public/css/all.css','public');

       mix.scripts([
           'assets/jquery/jquery-1.11.1.min.js',
           'assets/modernizr.custom.js',
           'assets/bootstrap/js/bootstrap.min.js',
           'assets/jquery-scrollbar/jquery.scrollbar.min.js',
           'assets/jquery-cookie/jquery.cookie.js',
           'assets/jquery-metrojs/MetroJs.min.js',
           'assets/jquery-isotope/isotope.pkgd.min.js',
           'assets/fotorama/fotorama.js',
           'assets/imagesloaded/imagesloaded.pkgd.min.js',
           'assets/jquery-infinite-scroll/jquery.infinitescroll.min.js',
           //'assets/datatables-responsive/js/lodash.min.js',
           'assets/js/pages.js',
           'assets/js/scripts.js',
       ], 'public/js/all.js','public');

       mix.version([
           'css/all.css',
           'js/all.js'
       ]);

       //mix.compressHtml();
   });

});
