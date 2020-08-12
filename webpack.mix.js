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
    .js('resources/js/createSubject.js', 'public/js')
    .js('resources/js/trainee_calendar.js', 'public/js');

mix.sass('resources/assets/sass/app.scss', 'public/css');

mix.styles('resources/css/supervisor_detail_course.css', 'public/css')
    .styles('resources/css/supervisor_header.css', 'public/css')
    .styles('resources/css/supervisor_list_courses.css', 'public/css')
    .styles('resources/css/supervisor_detail_user.css', 'public/css')
    .styles('resources/css/trainee_detail_subject.css', 'public/css')
    .styles('resources/css/calendar.css', 'public/css');
