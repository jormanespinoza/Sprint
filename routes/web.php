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

// Home View
Route::get('/', 'PageController@getIndex');

// Authentication Routes
Auth::routes();
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

// Administrator Routes
Route::group(['prefix' => 'admin', 'middleware' => 'administrator'], function() {
    Route::get('/', 'AdminController@getInfo');
    Route::resource('users', 'UserController');
    Route::resource('projects', 'ProjectsController');
    Route::put('projects/{project}/update', [
        'uses' => 'ProjectsController@updateAssignedUsers',
        'as' => 'projects.updateAssignedUsers'
    ]);
    Route::get('contact', 'PageController@getAdminContact');
    Route::post('contact', 'PageController@postAdminContact');
});

// User's Routes
Route::get('contact', 'PageController@getContact');
Route::post('contact', 'PageController@postContact');
Route::get('project/{project}', 'ProjectController@show')->name('project.show');
Route::group(['prefix' => 'project/{project}'], function() {
    Route::resource('sprints', 'SprintController', ['except' => 'index']);
});
Route::resource('tasks', 'TaskController');
Route::resource('profile', 'ProfileController', ['except' => ['index', 'create', 'store', 'destroy']]);