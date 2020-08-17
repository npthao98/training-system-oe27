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
    Route::middleware('auth')->group(function () {
        Route::get('/', 'HomeController@index')->name('home');
        Route::get('/home', 'HomeController@index')->name('home');
        Route::get('change-language/{language}', 'HomeController@changeLanguage')
            ->name('user.change-language');
        Route::get('/calendar', 'TraineeController@showCalendar')->name('calendar');
        Route::get('/progress', 'TraineeController@showProgress')->name('progress');
        Route::resource('course','CourseController');
        Route::post('course/assign/{course}', 'CourseController@assign')->name('course.assign');
        Route::resource('subject','SubjectController');
        Route::resource('task','TaskController');
        Route::resource('trainee','TraineeController');
        Route::get('assign', 'TraineeController@assign')->name('assign');
        Route::resource('supervisor','SupervisorController');
    });
});
