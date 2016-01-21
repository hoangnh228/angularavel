var elixir = require('laravel-elixir');

elixir.config.sourcemaps = false;
elixir.config.production = false;

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
    mix
    .sass('*.s*ss', 'public/css/style.css')
    .coffee('*.coffee', 'public/js/script.js')
    .browserSync({
        proxy: 'angularavel.dev'
    });
});
