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
    //$view = View::make('greeting')->with('name', 'Scotty Scott');
	//$view = View::make('greeting')->withName('Scotty Viper');
	//$view = View::make('greeting')->nest('child', 'child.view');
    $data = array(
        'heading' => 'You know what?',
        'body' => 'This is totally awesome!',
		'first_name' => 'Scotty',
		'last_name' => 'Scott'
    );
    //return View::make('greeting', $data);
	//return View::make('greeting')->nest('child', 'child.view', $data)->with('first_name', 'Scotty')->with('last_name', 'Scott');
	return View::make('greeting')->nest('child', 'child.view', $data)->with($data);
});

Route::get('/mockup', function()
{
    return View::make('mockup');
});

Route::resource('demos', 'DemosController', ['only' => ['index', 'show']]);

/*
Route::get('/{page}', function ($page) {
	return View::make('page')->with(['page' => $page]);
});
*/

/////////////////////////////////////////////////////////////
/*
Route::get('users', function()
{
    return 'Users!';
});

Route::get('users', 'UserController@getIndex');

Route::get('users', function()
{
    return View::make('users');
});
*/

Route::resource('users', 'UsersController');

/*
Route::get('users', function()
{
    $users = User::all();

    return View::make('users')->with('users', $users);
});
*/

/*
// print sql query
Event::listen('laravel.query'), function($sql) {
    var_dump($sql);
}
*/

Route::group(['prefix' => 'pvadmin', 'namespace' => 'pvadmin'], function()
{
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
Route::get('users/logout', 'UsersController@logout');

Route::get('users', 'UsersController@index');
