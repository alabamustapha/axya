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
//   /* Burst only when new packages or Vue components are added */
//   //---VENDOR--->
  .js([
      'resources/js/app.js',
      'resources/js/vendor/shuffle.min.js',
      'resources/js/vendor/jquery.timepicker.min.js',
    ], 
    'public/js/vendors.js')
  // .sass('resources/sass/app.scss',    'public/css/vendors.css')

  //---CUSTOM--->
  // .js([
  //     'resources/js/custom/custom.js',
  //     'resources/js/custom/main.js',
  //   ], 
  //   'public/js/custom.js')
  .js([
      'public/js/vendor/jquery-3.3.1.min.js',
      'public/js/vendor/popper.min.js',
      'public/js/vendor/bootstrap.min.js',
      'public/js/custom/main.js',
    ], 
    'public/js/admin.js')
  // .sass('resources/sass/admin.scss','public/css/admin.css')
//   // .sass('resources/sass/welcome.scss','public/css/welcome.css')
//   // .sass('resources/sass/custom.scss', 'public/css/custom.css')
;

// // For Production (Use this occasionally)
// mix
//   /* Burst only when new packages or Vue components are added */
  // .js('public/js/vendors.js',         'public/js/vendors.min.js')
//   // .sass('resources/sass/app.scss',    'public/css/vendors.min.css')
//   .js('public/js/custom.js',          'public/js/custom.min.js')
//   .js('public/js/admin.js',          'public/js/admin.min.js')
//   .sass('resources/sass/admin.scss','public/css/admin.min.css')
//   .sass('resources/sass/welcome.scss','public/css/welcome.min.css')
//   .sass('resources/sass/custom.scss', 'public/css/custom.min.css')
// ;

if (mix.inProduction()) {
    mix.version();
}
