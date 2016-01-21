<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('todoApp', function() {
    return view('index');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});

Route::resource('api/todos', 'TodoController');
Route::get('/api/employees', 'EmployeeController@index');
Route::get('/api/employees/{id}', 'EmployeeController@index');
Route::post('/api/employees', 'EmployeeController@store');
Route::post('/api/employees/{id}', 'EmployeeController@update');
Route::delete('/api/employees/{id}', 'EmployeeController@destroy');
// Route::resource('api/employees', 'EmployeeController');
