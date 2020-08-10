const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/createSubject.js', 'public/js')
    .js('resources/js/trainee_calendar.js', 'public/js');

mix.sass('resources/assets/sass/app.scss', 'public/css');

mix.styles('resources/css/supervisor_detail_course.css', 'public/css')
    .styles('resources/css/supervisor_header.css', 'public/css')
    .styles('resources/css/supervisor_list_courses.css', 'public/css')
    .styles('resources/css/supervisor_detail_user.css', 'public/css')
    .styles('resources/css/trainee_detail_subject.css', 'public/css')
    .styles('resources/css/calendar.css', 'public/css')
    .styles('resources/css/login.css', 'public/css/login.css')
    .styles('resources/css/dashboard.css', 'public/css/dashboard.css')
    .styles('resources/css/progress.css', 'public/css/progress.css');
