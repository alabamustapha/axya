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

// mix.js('resources/js/app.js', 'public/js')//[,'public/js/custom.js','public/js/popper.min.js']
//    .sass('resources/sass/app.scss', 'public/css')
//    .styles([
//     'public/css/vendor/font-awesome.min.css',
//     'public/css/vendor/bootstrap.min.css',
//     'public/css/custom/dashboard.css',
//     'public/css/custom/aesthetics.css',
//     'public/css/custom/override.css'
//    ], 'public/css/all.css');

mix.js([
// JAVASCRIPT
    'resources/js/app.js',
    // 'public/js/vendor/pikaday.js',
    'public/js/vendor/shuffle.min.js',
    ],
    'public/js/vendors.js')
  .js([
    'public/js/custom.js',
    'public/js/main.js',
    ],
    'public/js/custom.js')

// STYLES
  .sass('resources/sass/app.scss', 'public/css/app.css')
  .styles([
    'public/css/app.css',
    'public/css/vendor/jquery.timepicker.css',
    'public/css/vendor/pikaday.css',
   ], 
   'public/css/vendors.css')
  .styles([
    'public/css/custom/style.css',
    'public/css/custom/dashboard.css',
    'public/css/custom/admin.css',
    'public/css/custom/aesthetics.css',
    'public/css/custom/override.css',
   ],
   'public/css/custom.css')
  ;

// // For Production  
// mix.js('public/js/vendors.js', 'public/js/vendors.min.js')
//   .js('public/js/custom.js', 'public/js/custom.min.js')
//   // .sass('resources/sass/app.scss', 'public/css/app.css')
//   .styles('public/css/vendors.css', 'public/css/vendors.min.css')
//   .styles('public/css/custom.css', 'public/css/custom.min.css')
//   ;

if (mix.inProduction()) {
    mix.version();
}
