const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/token_processor.js', 'public/js')
    .js('resources/js/index.js', 'public/js')
    .js('resources/js/navbar.js', 'public/js')
    .js('resources/js/send_message_mod.js', 'public/js')
    .js('resources/js/show_availability.js', 'public/js')
    .js('resources/js/user_registration.js', 'public/js')
    .js('resources/js/booking.js', 'public/js')
    .js('resources/js/check_availability_mod.js', 'public/js')
    .js('resources/js/show_apartment.js', 'public/js')
    .js('resources/js/load_map_mod.js', 'public/js')
    .js('resources/js/load_address_mod.js', 'public/js')
    .js('resources/js/payment.js', 'public/js')
    .js('resources/js/threads_index.js', 'public/js')
    .js('resources/js/thread_show.js', 'public/js')
    .extract()
    .version()
    .copyDirectory('resources/fontawesome/webfonts', 'public/webfonts')
    .copyDirectory('resources/img/', 'public/img/')
    .styles(['resources/fontawesome/style.css'], 'public/css/plain.css')
    .sass('resources/sass/app.scss', 'public/css')
    .options({
        processCssUrls: false
    });
