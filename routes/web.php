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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('projects', 'ProjectController');
Route::resource('sprints', 'SprintController');
Route::resource('tasks', 'TaskController');
Route::resource('subtasks', 'SubtaskController');
Route::resource('profile', 'ProfileController');