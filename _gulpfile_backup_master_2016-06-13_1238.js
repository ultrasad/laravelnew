var elixir = require('laravel-elixir');
//require('./elixir-extensions');


elixir(function(mix) {

    elixir(function(mix) {
       mix.styles([
           'assets/bootstrap/css/bootstrap.min.css',
           'assets/font-awesome/css/font-awesome.css',
           'assets/jquery-scrollbar/jquery.scrollbar.css',
           'assets/jquery-metrojs/MetroJs.css',
           'assets/fotorama/fotorama.css',
           'assets/css/pages-icons.css',
           'assets/css/pages-main.css',
           //'assets/css/style.css'
       ], 'public/css/all.css','public');

       mix.styles([
           'assets/css/style.css'
       ], 'public/css/style.css','public');

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
           'assets/js/pages.js',
           //'assets/js/scripts.js',
       ], 'public/js/all.js','public');

       mix.scripts([
           'assets/js/scripts.js',
       ], 'public/js/scripts.js','public');

       mix.version([
           'css/all.css',
           'css/style.css',
           'js/all.js',
           'js/scripts.js'
       ]);
   });

});

//elixir(function(mix) {
    //mix.compressHtml();
//});
