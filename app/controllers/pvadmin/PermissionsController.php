<?php

namespace pvadmin;

use Input;
use Redirect;
use View;

use Permission;
use Role;

class PermissionsController extends \BaseController {

    /**
     * Display a listing of the permissions.
     *
     * @return Response
     */
    public function index()
    {
        $permissions = Permission::orderBy('display_name', 'asc')->get();
        
        return View::make("pvadmin.permissions.index")->with(array("permissions"=>$permissions));
    }

    /**
     * Show the form for creating a new role.
     *
     * @return Response
     */
    public function create()
    {
        // $permission = Permission::findOrFail($id);
        $permission = new Permission();

        return View::make('pvadmin.permissions.form')
            ->with('title', 'Create Permission')
            ->with('action', 'pvadmin.permissions.store')
            ->with('method', 'post')
            ->with('permission', $permission)
            ->with('roles', Role::optionsList());
        // return View::make("pvadmin.permissions.create");
    }

    /**
     * Store a newly created permission in storage.
     *
     * @return Response
     */
    public function store()
    {
        $permission = new Permission;
        $permission->name = Input::get('name');
        $permission->display_name = Input::get('display_name');
        
        if ($permission->save()) {
            if (Input::get('roles')) {
                $permission->roles()->sync(Input::get('roles'));
            }
            return Redirect::route('pvadmin.permissions.index', $permission->id)
                ->with('message', 'Permission Created: '.$permission->display_name);
        } else {
            $error = $permission->errors()->all(':message');
            return Redirect::route('pvadmin.permissions.create')
                ->withInput(Input::all())
                ->withError('There was a problem with your submission. See below for more information.')
                ->withErrors($permission->errors());
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
        $permission = Permission::findOrFail($id);

        return View::make('pvadmin.permissions.form')
            ->with('title', 'Edit Permission: ' . $permission->display_name)
            ->with('action', ['pvadmin.permissions.update', $permission->id])
            ->with('method', 'put')
            ->with('roles', Role::optionsList())
            ->with('permission', $permission);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);

        return View::make('pvadmin.permissions.form')
            ->with('title', 'Edit Permission: ' . $permission->display_name)
            ->with('action', ['pvadmin.permissions.update', $permission->id])
            ->with('method', 'put')
            ->with('roles', Role::optionsList())
            ->with('permission', $permission);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $permission = Permission::findOrFail($id);

        $permission->name = Input::get('name');
        $permission->display_name = Input::get('display_name');

        if ($permission->save()) {
            if (Input::get('roles')) {
                $permission->roles()->sync(Input::get('roles'));
            }
            return Redirect::route('pvadmin.permissions.show', $permission->id)
                ->withMessage('The permission has been successfully updated.');
        } else {
            return Redirect::route('pvadmin.permissions.show', $permission->id)
                ->withError('The permission could not be saved. See below for more information.')
                ->withErrors($permission->errors());
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
        $permission = Permission::findOrFail($id);
        $message = 'Permission Expired: '.$permission->display_name;
        $result = $permission->delete();

        if ($result) {
            return Redirect::route('pvadmin.permissions.index')
                ->withMessage($message);
        } else {
            return Redirect::route('pvadmin.permissions.index')
                ->withError('There was a problem with your submission. See below for more information.')
                ->withErrors($permission->errors());
        }
    }

}
