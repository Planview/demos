<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
    return View::make('home');
});

Route::resource('demos', 'DemosController', ['only' => ['index', 'show']]);

Route::group(['prefix' => 'pvadmin', 'namespace' => 'pvadmin'], function()
{
    // Route::resource('', 'UsersController');
    Route::resource('demos', 'DemosController');
    Route::resource('permissions', 'PermissionsController');
    Route::resource('roles', 'RolesController');
    Route::resource('users', 'UsersController');
});

// Confide routes
Route::get('users/create', 'UsersController@create');
Route::post('users', 'UsersController@store');
Route::get('users/login', 'UsersController@login');
Route::post('users/login', 'UsersController@doLogin');
Route::get('users/confirm/{code}', 'UsersController@confirm');
Route::get('users/forgot_password', 'UsersController@forgotPassword');
Route::post('users/forgot_password', 'UsersController@doForgotPassword');
Route::get('users/reset_password/{token}', 'UsersController@resetPassword');
Route::post('users/reset_password', 'UsersController@doResetPassword');
// Route::get('users/logout', 'UsersController@logout');

Route::get('logout', 'UsersController@logout');
Route::get('users', 'UsersController@index');

Route::resource('users', 'UsersController');

// Route model binding
Route::model('users', 'User');
// Route::model('roles', 'Role');
// Route::model('permissions', 'Permission');

// Route::group(['prefix' => 'auth'], function ()
// {
//     // Get Requests
//     Route::get('login', ['as' => 'auth.login', 'uses' => 'UsersController@login']);
//     Route::get('confirm/{code}', ['as' => 'auth.confirm', 'uses' => 'UsersController@confirm']);
//     Route::get('forgot_password', ['as' => 'auth.forgotPassword', 'uses' => 'UsersController@forgotPassword']);
//     Route::get('change_password', ['as' => 'auth.changePassword', 'uses' => 'UsersController@changePassword', 'before' => 'auth']);
//     Route::get('reset_password/{token}', ['as' => 'auth.resetPassword', 'uses' => 'UsersController@resetPassword']);
//     Route::get('logout', ['as' => 'auth.logout', 'uses' => 'UsersController@logout']);

//     // Form Posts
//     Route::group(['before' => 'csrf'], function ()
//     {
//         Route::post('login', ['as' => 'auth.doLogin', 'uses' => 'UsersController@doLogin']);
//         Route::post('forgot_password', ['as' => 'auth.doForgotPassword', 'uses' => 'UsersController@doForgotPassword']);
//         Route::post('change_password', ['as' => 'auth.doChangePassword', 'uses' => 'UsersController@doChangePassword', 'before' => 'auth']);
//         Route::post('reset_password', ['as' => 'auth.doResetPassword', 'uses' => 'UsersController@doResetPassword']);
//     });
// });

// print sql query
// Event::listen('laravel.query'), function($sql) {
//     var_dump($sql);
// }
