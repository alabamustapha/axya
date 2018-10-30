const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .styles([
    'public/css/vendor/font-awesome.min.css',
    'public/css/custom/dashboard.css',
    'public/css/custom/override.css'
   ], 'public/css/all.css');

if (mix.inProduction()) {
    mix.version();
}
