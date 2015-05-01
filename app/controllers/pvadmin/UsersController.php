<?php

namespace pvadmin;

use Input;
use Redirect;
use View;

use Auth;
use Config;
use DB;
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
        $user   = User::findOrFail(Auth::id());
        $title  = 'Manage Admin Users';
        $links  = false;

        if (isset($_GET["userByEmail"])) {
            $thisUser = User::where('email', '=', $_GET["userByEmail"])->firstOrFail();
            return Redirect::action('pvadmin.users.show', $thisUser->id);
        } else if (isset($_GET["allUsers"]) || isset($allUsers)) {
            $title          = 'Manage All Users';

            if ($user->can('manage_admins')) {
                $users = User::orderBy('email', 'asc')->paginate(10);
                $links = true;
            } else if ($user->can('manage_isrs')) {
                $userIds = User::usersWithPermissionIdArray('manage_isrs');

                $users = DB::table('users')
                    ->whereNotIn('id', $userIds)
                    ->orderBy('email', 'asc')
                    ->paginate(10);

                $links = true;
            }
        } else {
            if ($user->can('manage_admins')) {
                $users = User::usersWithPermission('manage_clients');
            } else if ($user->can('manage_isrs')) {
                $users = User::usersWithAbility('ISR Admin', 'manage_clients');
            }
        }

        return View::make('pvadmin.users.index')->with([
            'links'     => $links,
            'title'     => $title,
            'users'     => $users
        ]);
    }

    /**
     * Show the form for creating a new user.
     *
     * @return Response
     */
    public function create()
    {
        $user   = new User();
        $isr    = $user->isrInfo();

        if (!Auth::user()->can('manage_admins')) {
            $roles      = Role::isrAdminRole();
            $multiple   = null;
            $user->can('manage_clients') ? $checked = true : $checked = false;
        } else {
            $checked = false;
            $roles = Role::optionsList();
            $multiple = 'multiple';
        }

        return View::make('pvadmin.users.form')->with([
            'title'     => 'Create a New User',
            'action'    => 'pvadmin.users.store',
            'checked'   => $checked,
            'isr'       => $isr,
            'multiple'  => $multiple,
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

        $user           = new User();
        $isr_info_array = array();

        $user->email             = Input::get('email');
        $user->company           = Input::get('company');
        $user->expires           = Input::get('expires');
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
        if (!Auth::user()->can('manage_admins') && $user->can('manage_isrs')) {
            return Redirect::route('pvadmin.users.index')
                ->withError('Admins can only update ISR Admins.');
        } else {
            if (!Auth::user()->can('manage_admins')) {
                $roles      = Role::isrAdminRole();
                $multiple   = null;
                $user->can('manage_clients') ? $checked = true : $checked = false;
            } else {
                $checked = false;
                $roles = Role::optionsList();
                $multiple = 'multiple';
            }

            $isr   = $user->isrInfo();

            return View::make('pvadmin.users.form')->with([
                'title'     => "Update User: {$user->email}",
                'action'    => ['pvadmin.users.update', $user->id],
                'checked'   => $checked,
                'isr'       => $isr,
                'multiple'  => $multiple,
                'roles'     => $roles,
                'user'      => $user,
                'method'    => 'put'
            ]);
        }
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
            if (is_array(Input::get('roles'))) {
                $user->roles()->sync(Input::get('roles'));
            } else {
                $user->roles()->sync((array) Input::get('roles'));
            }
        } else {
            $user->roles()->sync([]);
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

        // 1. delete demo access
        $resultDemoAccess  = $user->demos()->sync([]);
        // 2. (if any) delete associated ISR ID (foreign key) from all users
        $resultAssociatedUsersQuery  = DB::update('update users set isr_contact_id = null where isr_contact_id = ?', array($user->id));
        // 3. (if any) delete ISR info
        $resultIsr  = true;
        if (!$user->isrs->isEmpty()) {
            $resultIsr  = $user->isrs()->delete();
        }
        // 4. delete user
        $resultUser = $user->delete();

        isset($_GET["allUsers"]) ? $showAllUsers = array('allUsers' => 'true') : $showAllUsers = null;

        if ($resultDemoAccess && $resultIsr && $resultUser) {
            return Redirect::route('pvadmin.users.index', $showAllUsers)
                ->withMessage($message);
        } else {
            return Redirect::route('pvadmin.users.index', $showAllUsers)
                ->withError('There was a problem with your submission. See below for more information.')
                ->withErrors($user->errors());
        }
    }
}
