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

mix
  .js([
      'resources/js/app.js',
      'resources/js/vendor/shuffle.min.js',
      'resources/js/vendor/jquery.timepicker.min.js',
    ], 
    'public/js/vendors.js')
  .js([
      'resources/js/custom/custom.js',
      'resources/js/custom/main.js',
    ], 
    'public/js/custom.js')

  // STYLES
  .sass('resources/sass/welcome.scss','public/css/welcome.css')
  .sass('resources/sass/custom.scss', 'public/css/custom.css')
  .sass('resources/sass/app.scss',    'public/css/vendors.css')
;

// // For Production  
// mix
//   .js('public/js/vendors.js',         'public/js/vendors.min.js')
//   .js('public/js/custom.js',          'public/js/custom.min.js')
//   .sass('resources/sass/welcome.scss','public/css/welcome.min.css')
//   .sass('resources/sass/custom.scss', 'public/css/custom.min.css')
//   .sass('resources/sass/app.scss',    'public/css/vendor.min.css')
//   ;

if (mix.inProduction()) {
    mix.version();
}
