<?php

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

Route::get('/', 'PageController@getIndex');
Route::get('contact', 'PageController@getContact');
Route::post('contact', 'PageController@postContact');

// Administrator Routes
Route::group(['prefix' => 'admin', 'middleware' => 'administrator'], function() {
    Route::get('/', function(){
        return view('admin.dashboard');
    });
    Route::resource('users', 'UserController');
    Route::resource('projects', 'ProjectController');
});

Route::resource('sprints', 'SprintController');
Route::resource('tasks', 'TaskController');

Route::resource('profile', 'ProfileController');

Auth::routes();
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');