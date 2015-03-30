<?php

namespace pvadmin;

use Input;
use Redirect;
use View;

use Permission;
use Role;

class RolesController extends \BaseController {

    /**
     * Display a listing of the roles.
     *
     * @return Response
     */
    public function index()
    {
        $roles = Role::orderBy('name', 'asc')->get();
        
        return View::make("pvadmin.roles.index")->with(array("roles"=>$roles));
    }

    /**
     * Show the form for creating a new role.
     *
     * @return Response
     */
    public function create()
    {
        $role = new Role();

        return View::make('pvadmin.roles.form')
            ->with('title', 'Create Role')
            ->with('action', 'pvadmin.roles.store')
            ->with('method', 'post')
            ->with('permissions', Permission::optionsList())
            ->with('role', $role);
    }

    /**
     * Store a newly created role in storage.
     *
     * @return Response
     */
    public function store()
    {
        $role = new Role;
        $role->name = Input::get('name');
        if ($role->save()) {
            if (Input::get('permissions')) {
                $role->perms()->sync(Input::get('permissions'));
            }
            return Redirect::route('pvadmin.roles.index')
                ->with('message', 'Role Created: '.$role->name);
        } else {
            $error = $role->errors()->all(':message');
            return Redirect::route('pvadmin.roles.create')
                ->withInput(Input::all())
                ->withError('There was a problem with your submission. See below for more information.')
                ->withErrors($role->errors());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $role = Role::findOrFail($id);

        return View::make('pvadmin.roles.form')
            ->with('title', 'Edit Role: ' . $role->name)
            ->with('action', ['pvadmin.roles.update', $role->id])
            ->with('method', 'put')
            ->with('permissions', Permission::optionsList())
            ->with('role', $role);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    //public function edit($role)
    {
        $role = Role::findOrFail($id);

        return View::make('pvadmin.roles.form')
            ->with('title', 'Edit Role: ' . $role->name)
            ->with('action', ['pvadmin.roles.update', $role->id])
            ->with('method', 'put')
            ->with('permissions', Permission::optionsList())
            ->with('role', $role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $role = Role::findOrFail($id);

        $role->name = Input::get('name');

        if (Input::get('permissions')) {
            $role->perms()->sync(Input::get('permissions'));
        }

        if ($role->save()) {
            return Redirect::route('pvadmin.roles.show', $role->id)
                ->withMessage('The role has been successfully updated.');
        } else {
            return Redirect::route('pvadmin.roles.show', $role->id)
                ->withError('The role could not be saved. See below for more information.')
                ->withErrors($role->errors());
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
        $role = Role::findOrFail($id);
        $message = 'Role Expired: '.$role->name;
        $result = $role->delete();

        if ($result) {
            return Redirect::route('pvadmin.roles.index')
                ->withMessage($message);
        } else {
            return Redirect::route('pvadmin.roles.index')
                ->withError('There was a problem with your submission. See below for more information.')
                ->withErrors($permission->errors());
        }
    }

}
