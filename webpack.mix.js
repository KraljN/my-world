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

mix.js('resources/js/app.js', 'public/assets/js')
    .vue()
    .css('resources/css/template.css', 'public/assets/css')
    .sass('resources/sass/custom.scss', 'public/assets/css')
    .sass('resources/sass/responsive.scss', 'public/assets/css');
