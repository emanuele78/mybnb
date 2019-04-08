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
    .js('resources/js/token_processor', 'public/js')
    .copyDirectory('resources/fontawesome/webfonts', 'public/webfonts')
    .styles(['resources/fontawesome/style.css'], 'public/css/plain.css')
    .sass('resources/sass/app.scss', 'public/css');
