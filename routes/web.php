<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware('locale')->group(function () {
    Auth::routes();
    Route::get('change-language/{language}', 'HomeController@changeLanguage')
        ->name('user.change-language');
    Route::middleware('auth', 'user.active')->group(function () {
        Route::get('/', 'HomeController@index')->name('home');
        Route::get('/home', 'HomeController@index')->name('home');
        Route::get('/progress', 'TraineeController@showProgress')->name('progress');
        Route::resource('course','CourseController');
        Route::post('course/assign/{course}', 'CourseController@assign')->name('course.assign');
        Route::resource('subject','SubjectController');
        Route::resource('task','TaskController');
        Route::put('/trainee/{trainee}/active-course/{course}', 'TraineeController@activeCourse')
            ->name('trainee.course.active');
        Route::resource('trainee','TraineeController');
        Route::put('trainee/{trainee}/pass-subject/{subject}', 'TraineeController@passSubject')
            ->name('trainee.subject.pass');
        Route::get('assign', 'TraineeController@assign')->name('assign');
        Route::resource('supervisor','SupervisorController');
        Route::get('edit-password', 'HomeController@editPassword')
            ->name('user.edit.password');
        Route::put('update-password', 'HomeController@updatePassword')
            ->name('user.update.password');
        Route::get('edit-profile', 'HomeController@editProfile')
            ->name('user.edit.profile');
        Route::put('update-profile', 'HomeController@updateProfile')
            ->name('user.update.profile');
        Route::get('detail-profile', 'HomeController@showProfile')
            ->name('user.detail.profile');
        Route::get('calendar/data', 'HomeController@getDate')->name('calendar.data');
        Route::get('notifications/data', 'NotificationController@getNotifications')
            ->name('notification.data');
        Route::get('read-notification/{notification}', 'NotificationController@readNotification')
            ->name('notification.read');
    });
});
