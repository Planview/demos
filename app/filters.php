<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
    // log the user out if their last_activity_timestamp cookie has expires
    if ( !isset($_COOKIE['last_activity_timestamp']) && Auth::check() ) {
        Confide::logout();
        return Redirect::to('/')->with('message', 'Your session has expired. Please login again.');
    }
});

App::after(function($request, $response)
{
    // set or renew the logged in session time limit for users 
    $sessionExpirationInMinutes = 60;
    $sessionExpiration = $sessionExpirationInMinutes * 60;
    setcookie('last_activity_timestamp','Login sessions are limited to '.$sessionExpirationInMinutes.' minutes.', time() + $sessionExpiration, "/"); 
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
    if (Auth::guest())
    {
        if (Request::ajax())
        {
            return Response::make('Unauthorized', 401);
        }
        else
        {
            // return Redirect::guest(URL::route('auth.login', array(), false));
            return Redirect::guest('login');
        }
    }
});

Route::filter('auth.basic', function()
{
    return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
    if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
    if (Session::token() != Input::get('_token'))
    {
        throw new Illuminate\Session\TokenMismatchException;
    }
});

Route::filter('can', function ($route, $request, $permission)
{
    if (!Entrust::can($permission)) {
        return Redirect::to('/');
    }
});

Route::filter('pvadmin', function()
{
    // Is this an admin or super admin?
    if (!Auth::user()->can('manage_isrs')) {
        return Redirect::to('/');
    }
});
 
Route::filter('superadmin', function()
{
    // Is this a super admin?
    if (!Auth::user()->can('manage_admins')) {
        return Redirect::to('/');
    }
});

Route::when('pvadmin/users*', 'pvadmin');
Route::when('pvadmin/demos*', 'superadmin');
Route::when('pvadmin/permissions*', 'superadmin');
Route::when('pvadmin/roles*', 'superadmin');

/*
 / The /users URI is used during the login process and
 / we only need to restrict three URIs to admin-only access:
 / 1. /users -- lists all prospects
 / 2. /users/create -- creates a new prospect with access
 / 3. /users/"user ID" (which is numeric) -- allws for editing of a prospect
*/

Route::filter('admin', function()
{
  // Is this an ISR, admin, or super admin?
  if (!Auth::user()->can('manage_clients')) {
    return Redirect::to('/');
  }
});

Route::filter('adminUserView', function()
{
  if ( is_numeric(substr($_SERVER['REQUEST_URI'], 7)) ) { // Is this the user edit form view (which is numeric)?
    // Is this an ISR, admin, or super admin?
    if (!Auth::user()->can('manage_clients')) {
      return Redirect::to('/');
    }
  }
});

Route::when('users', 'admin');
Route::when('users/create', 'admin');
Route::when('users*', 'adminUserView');
