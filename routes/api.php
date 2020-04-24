<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/tasks','ControllerTasks@index');
Route::get('/tasks/{id}','ControllerTasks@show');
Route::POST('/tasks','ControllerTasks@store');
Route::put('tasks/{id}','ControllerTasks@update');


Route::resource('users', 'User\UserController');

Route::resource('categories', 'Category\ControllerCategories');
