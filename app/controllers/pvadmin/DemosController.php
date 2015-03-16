<?php

namespace pvadmin;

use Demo;
use Input;
use Redirect;
use Session;
use View;
use URL;

class DemosController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $demos = Demo::withTrashed()->orderBy('title', 'asc')->get();

        return View::make("pvadmin.demos.index")->with(array("demos"=>$demos));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $demo = new Demo();

        return View::make('pvadmin.demos.form')->with([
            'title'     => 'Create a New Demo',
            'action'    => 'pvadmin.demos.store',
            'demo'      => $demo,
            'method'    => 'post'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $demo = new Demo;
        $demo->title                = Input::get('title');
        $demo->description          = Input::get('description');
        $demo->enterprise_version   = Input::get('enterprise_version');
        $demo->language             = Input::get('language');
        $demo->demo_code            = Input::get('demo_code');
        $demo->related_content_code = Input::get('related_content_code');

        if ($demo->save()) {
            return Redirect::action('pvadmin.demos.show', $demo->id)
                ->with('message', "{$demo->title} was successfully created.");
        } else {
            $error = $demo->errors()->all(':message');

            return Redirect::route('pvadmin.users.create')
                ->withInput(Input::except('password'))
                ->withError('There was a problem with your submission. See below for more information.')
                ->withErrors($demo->errors());
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
        $demo = Demo::withTrashed()->findOrFail($id);

        return View::make('pvadmin.demos.form')->with([
            'title'     => "Update Demo: {$demo->title}",
            'action'    => ['pvadmin.demos.update', $demo->id],
            'demo'       => $demo,
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
    {
        $demo = Demo::withTrashed()->findOrFail($id);

        return View::make('pvadmin.demos.form')->with([
            'title'     => "Update Demo: {$demo->title}",
            'action'    => ['pvadmin.demos.update', $demo->id],
            'demo'       => $demo,
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
    {
        if (Input::get('submit_button_restore')) {
            $demo = Demo::withTrashed()->find($id);
            $demo->restore();

            return Redirect::action('pvadmin.demos.index')
                  ->with('message', "{$demo->title} was successfully restored.");
        } else {
            $demo = Demo::withTrashed()->find($id);
            $demo->title                = Input::get('title');
            $demo->description          = Input::get('description');
            $demo->enterprise_version   = Input::get('enterprise_version');
            $demo->language             = Input::get('language');
            $demo->demo_code            = Input::get('demo_code');
            $demo->related_content_code = Input::get('related_content_code');

            if ($demo->save()) {
                return Redirect::action('pvadmin.demos.show', $demo->id)
                    ->with('message', "{$demo->title} was successfully updated.");
            } else {
                $error = $demo->errors()->all(':message');

                return Redirect::action('pvadmin.demos.show', $demo->id)
                    ->withInput(Input::all())
                    ->withError('There was a problem with your submission. See below for more information.')
                    ->withErrors($demo->errors());
            }
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
        $demo = Demo::withTrashed()->find($id);
        $destroyDemo = Demo::destroy($id);

        return Redirect::action('pvadmin.demos.index')
            ->with('message', "Demo Expired: {$demo->title}");
    }

}
