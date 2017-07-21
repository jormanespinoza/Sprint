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
    Route::get('/', 'AdminController@getInfo');
    Route::resource('users', 'UserController');
    Route::resource('projects', 'ProjectController');
    Route::put('projects/{project}/update', [
        'uses' => 'ProjectController@updateAssignedUsers',
        'as' => 'projects.updateAssignedUsers'
    ]);
    Route::get('contact', 'PageController@getAdminContact');
    Route::post('contact', 'PageController@postAdminContact');
});

Route::resource('sprints', 'SprintController');
Route::resource('tasks', 'TaskController');
Route::resource('profile', 'ProfileController', ['except' => ['index', 'create', 'store', 'destroy']]);

// Authentication Routes
Auth::routes();
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');