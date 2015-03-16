<?php

namespace pvadmin;

use App;
use Config;
use Input;
use Lang;
use Mail;
use Response;
use Redirect;
use Session;
use View;
use URL;

Use Isr;
//use Permission;
use Role;
use User;
//use UserRepository;



class UsersController extends \BaseController {

    /**
     * Display a listing of the users.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::orderBy('email', 'asc')->paginate(5);
        
        return View::make("pvadmin.users.index")->with(array("users"=>$users));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $isr = new Isr();
        $roles = Role::optionsList();
        $user = new User();

        return View::make('pvadmin.users.form')->with([
            'title'     => 'Create a New User',
            'action'    => 'pvadmin.users.store',
            'isr'     => $isr,
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
        $isr = new Isr();

        $user->email    = Input::get('email');
        $user->company    = Input::get('company');
        $user->expiration    = Input::get('expiration');
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

            if (Input::has('isr_first_name')) {
                $isr->user_id    = $user->id;
                $isr->isr_first_name = Input::get('isr_first_name');
                if (Input::has('isr_last_name')) {
                    $isr->isr_last_name = Input::get('isr_last_name');
                }
                if (Input::has('isr_phone')) {
                    $isr->isr_phone = Input::get('isr_phone');
                }
                if (Input::has('isr_mobile_phone')) {
                    $isr->isr_mobile_phone = Input::get('isr_mobile_phone');
                }
                if (Input::has('isr_location')) {
                    $isr->isr_location = Input::get('isr_location');
                }
                if (!$isr->save()) {
                    $error = $isr->errors()->all(':message');

                    return Redirect::route('pvadmin.users.create')
                        ->withInput(Input::except('password'))
                        ->withError('There was a problem with your submission. See below for more information.')
                        ->withErrors($isr->errors());
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
    public function show($id)
    //public function show($user)
    {
        if (!($isr = Isr::where('user_id', '=', $id)->first())) {
            $isr = new Isr();
        }

        $roles = Role::optionsList();
        $user = User::findOrFail($id);

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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    //public function edit($user)
    {
        // if (!($isr = Isr::where('user_id', '=', $id)->first())) {
        //     $isr = new Isr();
        // }
        $isr = Isr::where('user_id', '=', $id)->first() ?: new Isr();

        $roles = Role::optionsList();
        $user = User::findOrFail($id);

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
    public function update($id)
    //public function update($user)
    {
        // user input
        $user = User::findOrFail($id);

        if (Input::has('password')) {
            if (Input::get('password') === Input::get('password_confirmation')) {
                $user->password = Input::get('password');
            } else {
                return Redirect::route('pvadmin.users.show', $user->id)
                    ->withInput(Input::except('password'))
                    ->withError('Error: Passwords do not match.');
            }
        }

        if (Input::has('roles')) {
            $user->roles()->sync(Input::get('roles'));
        }

        // isr input
        if (!($isr = Isr::where('user_id', '=', $id)->first())) {
            $isr = new Isr();
            $isr->user_id = $id;
        }

        if (Input::has('isr_first_name')) {
            $isr->isr_first_name = Input::get('isr_first_name');
        }
        if (Input::has('isr_last_name')) {
            $isr->isr_last_name = Input::get('isr_last_name');
        }
        if (Input::has('isr_phone')) {
            $isr->isr_phone = Input::get('isr_phone');
        }
        if (Input::has('isr_mobile_phone')) {
            $isr->isr_mobile_phone = Input::get('isr_mobile_phone');
        }
        if (Input::has('isr_location')) {
            $isr->isr_location = Input::get('isr_location');
        }

        $resultUser = $user->save();
        $resultIsr = $isr->save();

        if ($resultUser) {
            if ($resultIsr) {
                return Redirect::route('pvadmin.users.show', $user->id)
                    ->withMessage('The user has been updated.');
            } else {
                return Redirect::route('pvadmin.users.show', $user->id)
                    ->withInput(Input::except('password'))
                    ->withError('There was a problem with your submission. See below for more information.')
                    ->withErrors($isr->errors());
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
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $message = 'User Expired: '.$user->email;
        $result = $user->delete();

        if ($result) {
            return Redirect::route('pvadmin.users.index')
                ->withMessage($message);
        } else {
            return Redirect::route('pvadmin.users.index')
                ->withError('There was a problem with your submission. See below for more information.')
                ->withErrors($user->errors());
        }

    }
}
