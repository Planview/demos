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

/*
Route::get('/', function()
{
	return View::make('hello');
});
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

Route::resource('demos', 'DemosController');

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

Route::get('users', function()
{
    $users = User::all();

    return View::make('users')->with('users', $users);
});

/*
// print sql query
Event::listen('laravel.query'), function($sql) {
    var_dump($sql);
}
*/