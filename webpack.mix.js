const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/backend/js')
    .sass('resources/sass/app.scss', 'public/backend/css');
