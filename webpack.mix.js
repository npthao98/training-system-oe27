const mix = require('laravel-mix');

mix.js('resources/js/create_subject.js', 'public/js/create_subject.js')
    .js('resources/js/trainee_calendar.js', 'public/js/trainee_calendar.js')
    .js('resources/js/app.js', 'public/js/app.js')
    .js('resources/js/message.js', 'public/js/message.js');

mix.styles('resources/css/supervisor_detail_course.css', 'public/css/supervisor_detail_course.css')
    .styles('resources/css/supervisor_header.css', 'public/css/supervisor_header.css')
    .styles('resources/css/supervisor_list_courses.css', 'public/css/supervisor_list_courses.css')
    .styles('resources/css/supervisor_detail_user.css', 'public/css/supervisor_detail_user.css')
    .styles('resources/css/trainee_detail_subject.css', 'public/css/trainee_detail_subject.css')
    .styles('resources/css/calendar.css', 'public/css/calendar.css')
    .styles('resources/css/login.css', 'public/css/login.css')
    .styles('resources/css/dashboard.css', 'public/css/dashboard.css')
    .styles('resources/css/progress.css', 'public/css/progress.css')
    .styles('resources/css/message.css', 'public/css/message.css');

mix.sass('resources/sass/app.scss', 'public/css/app');
