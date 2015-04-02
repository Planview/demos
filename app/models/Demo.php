<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Demo extends Eloquent {

    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];

    /**
     * Make a list of the user's demo access
     * @return Demo object array
     */
    public static function demosUserCanAccess()
    {
        $list   = array();
        $demos  = self::orderBy('title', 'asc')->get();

        if (Auth::check()) {
            if (User::find(Auth::id())->can('manage_clients')) {
                return $demos;
            } else {
                $demoIds = DB::table('user_demo_access')->where('user_id', '=', Auth::id())->get();
                foreach ($demos as $demo) {
                    foreach ($demoIds as $demoId) {
                        if ($demo->id == $demoId->demo_id) {
                            $list[] = $demo;
                        }
                    }
                }
            return $list;
            }
        } else {
            return $list;
        }
    }


}
