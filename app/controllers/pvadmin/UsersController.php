<?php

namespace pvadmin;

use Input;
use Redirect;
use View;

use Auth;
use Config;
use Isr;
use Lang;
use Mail;
use Permission;
use Request;
use Role;
use User;

class UsersController extends \BaseController {

    /**
     * Display a listing of the users.
     *
     * @return Response
     */
    public function index()
    {
        $user           = User::findOrFail(Auth::id());
        $title          = 'Manage Admin Users';

        if (isset($_GET["userByEmail"])) {
            $thisUser = User::where('email', '=', $_GET["userByEmail"])->firstOrFail();
            return Redirect::action('pvadmin.users.show', $thisUser->id);
        } else if (isset($_GET["allUsers"])) {
            $title          = 'Manage All Users';

            if ($user->can('manage_admins')) {
                $users = User::orderBy('email', 'asc')->get();
            } else if ($user->can('manage_isrs')) {
                $users = User::usersWithoutPermission('manage_isrs');
            }
        } else {
            if ($user->can('manage_admins')) {
                $users = User::usersWithPermission('manage_clients');
            } else if ($user->can('manage_isrs')) {
                $users = User::usersWithAbility('ISR Admin', 'manage_clients');
            }
        }

        return View::make('pvadmin.users.index')->with([
            'title'         => $title,
            'users'         => $users
        ]);
    }

    /**
     * Show the form for creating a new user.
     *
     * @return Response
     */
    public function create()
    {
        $isrs   = User::isrList();
        $roles  = Role::optionsList();
        $user   = new User();
        $isr    = $user->isrInfo();

        return View::make('pvadmin.users.form')->with([
            'title'     => 'Create a New User',
            'action'    => 'pvadmin.users.store',
            'isr'       => $isr,
            'isrs'      => $isrs,
            'user'      => $user,
            'roles'     => $roles,
            'method'    => 'post'
        ]);
    }

    /**
     * Store a newly created user in storage.
     *
     * @return Response
     */
    public function store()
    {
        $password = '';

        $user = new User();
        $isr_info_array = array();

        $user->email      = Input::get('email');
        $user->company    = Input::get('company');
        $user->expires    = Input::get('expires');
        $user->confirmation_code = md5(uniqid(mt_rand(), true));

        if (Input::get('auto_password', false)) {
            $password = $user->autoGeneratePassword();
        } else {
            $user->password = Input::get('password');
            $user->password_confirmation = Input::get('password_confirmation');
        }

        if ($user->save()) {
            if (Input::has('roles')) {
                $user->roles()->sync(Input::get('roles'));
            }

            // isr input
            if (Input::has('isr_first_name')) {
                $isr = new Isr(Input::all());
                if (!$user->isrs()->save($isr)) {
                    $error = $user->errors()->all(':message');

                    return Redirect::route('pvadmin.users.create')
                        ->withInput(Input::except('password'))
                        ->withError('There was a problem with your submission. See below for more information.')
                        ->withErrors($user->errors());
                }
            }
/*
            if (Input::get('auto_password', false)) {
                $user->confirm();

                Mail::send(
                    'emails.auth.auto-password', ['user' => $user, 'password' => $password],
                    function ($message) use ($user) {
                        $message
                            ->to($user->email, $user->email)
                            ->subject('Your Planview Sales Site Credentials');
                    });
            } elseif (null === Input::get('auto_confirm') && Config::get('confide::signup_email')) {
                Mail::send(
                    Config::get('confide::email_account_confirmation'),
                    compact('user'),
                function ($message) use ($user) {
                        $message
                            ->to($user->email, $user->email)
                            ->subject(Lang::get('confide::confide.email.account_confirmation.subject'));
                    }
                );
            } else {
                $user->confirm();
            }
*/
            $user->confirm();
            return Redirect::action('pvadmin.users.show', $user->id)
                ->with('message', "The user {$user->email} was successfully created.");
        } else {
            $error = $user->errors()->all(':message');

            return Redirect::route('pvadmin.users.create')
                ->withInput(Input::except('password'))
                ->withError('There was a problem with your submission. See below for more information.')
                ->withErrors($user->errors());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($user)
    {
        $roles = Role::optionsList();
        $isr   = $user->isrInfo();

        return View::make('pvadmin.users.form')->with([
            'title'     => "Update User: {$user->email}",
            'action'    => ['pvadmin.users.update', $user->id],
            'isr'       => $isr,
            'roles'     => $roles,
            'user'      => $user,
            'method'    => 'put'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($user)
    {
        // user input
        if (Input::has('password')) {
            $user->password = Input::get('password');
            $user->password_confirmation = Input::get('password_confirmation');
        }

        if (Input::has('roles')) {
            $user->roles()->sync(Input::get('roles'));
        }

        $resultUser = $user->save();

        // isr input
        if ($user->isrs->isEmpty()) {
            $isr = new Isr(Input::all());
            $resultIsr = $user->isrs()->save($isr);
        } else {
            $resultIsr = $user->isrs()->first()->fill(Input::all())->save();
        }

        if ($resultUser) {
            if ($resultIsr) {
                return Redirect::route('pvadmin.users.show', $user->id)
                    ->withMessage('This user was updated.');
            } else {
                return Redirect::route('pvadmin.users.show', $user->id)
                    ->withInput(Input::except('password'))
                    ->withError('There was a problem with your submission. See below for more information.')
                    ->withErrors($user->errors());
            }
        } else {
            return Redirect::route('pvadmin.users.show', $user->id)
                ->withInput(Input::except('password'))
                ->withError('There was a problem with your submission. See below for more information.')
                ->withErrors($user->errors());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($user)
    {
        $message = 'User deleted: '.$user->email;

        // delete ISR info first
        $resultIsr  = true;
        if (!$user->isrs->isEmpty()) {
            $resultIsr  = $user->isrs()->delete();
        }
        $resultUser = $user->delete();

        if ($resultIsr && $resultUser) {
            return Redirect::route('pvadmin.users.index')
                ->withMessage($message);
        } else {
            return Redirect::route('pvadmin.users.index')
                ->withError('There was a problem with your submission. See below for more information.')
                ->withErrors($user->errors());
        }
    }
}
