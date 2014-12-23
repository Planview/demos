<?php

namespace pvadmin;

use Demo;
use Input;
use Redirect;
use Session;
use View;

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
		return View::make("pvadmin.demos.create");
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$demo = new Demo;
		$demo->title = Input::get('demo_title');
		$demo->description = Input::get('demo_description');
		$demo->save();
		$page_messages = 'Demo Created: '.$demo->title;

		return Redirect::route('pvadmin.demos.index')->withPage_messages($page_messages);
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
		return View::make("pvadmin.demos.show")->with(array("demo"=>$demo));
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
		return View::make("pvadmin.demos.edit")->with(array("demo"=>$demo));
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
			$restoreDemo = Demo::withTrashed()->where('id', $id)->restore();
			$demo = Demo::withTrashed()->findOrFail($id);
			$page_messages = 'Demo Restored: '.$demo->title;
		} else {
			$demo = Demo::withTrashed()->find($id);
			$demo->title = Input::get('demo_title');
			$demo->description = Input::get('demo_description');
			$demo->save();
			$page_messages = 'Demo Updated: '.$demo->title;
		}

		return Redirect::route('pvadmin.demos.index')->withPage_messages($page_messages)->with(array("demo"=>$demo));		
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
		$dseatroyDemo = Demo::destroy($id);
		$page_messages = 'Demo Expired: '.$demo->title;

		return Redirect::route('pvadmin.demos.index')->withPage_messages($page_messages);
	}


}
