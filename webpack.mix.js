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

mix.js('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css');
mix.styles([
    'resources/assets/css/supervisor_detail_course.css',
], 'public/css/supervisor_detail_course.css');
mix.styles([
    'resources/assets/css/supervisor_header.css',
], 'public/css/supervisor_header.css');
mix.styles([
    'resources/assets/css/supervisor_list_courses.css',
], 'public/css/supervisor_list_courses.css');
