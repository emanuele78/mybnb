const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/token_processor.js', 'public/js')
    .js('resources/js/index.js', 'public/js')
    .js('resources/js/navbar.js', 'public/js')
    .js('resources/js/show.js', 'public/js')
    .extract()
    .version()
    .copyDirectory('resources/fontawesome/webfonts', 'public/webfonts')
    .copyDirectory('resources/img/', 'public/img/')
    .styles(['resources/fontawesome/style.css'], 'public/css/plain.css')
    .sass('resources/sass/app.scss', 'public/css')
    .options({
        processCssUrls: false
    });
