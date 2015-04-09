<?php

class DemosController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $demos = Demo::demosUserCanAccess();
        return View::make("demos.index")->with(array("demos"=>$demos));
    }


    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create()
    {
        App::abort(404);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        App::abort(404);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        if (Auth::user()->can('manage_clients')) {
            // admins can view all demos
            $demo = Demo::findOrFail($id);
            return View::make("demos.show")->with(array("demo"=>$demo));
        } else if (in_array($id, Demo::demoIdsUserCanAccess())) {
            // user can view this demo
            $demo = Demo::findOrFail($id);
            return View::make("demos.show")->with(array("demo"=>$demo));
        } else {
            return Redirect::to('/demos')->with('message', "You do not have access to that demo.");;
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        App::abort(404);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        App::abort(404);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        App::abort(404);
    }


}
