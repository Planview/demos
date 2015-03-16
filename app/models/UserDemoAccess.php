<?php

// use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;

class UserDemoAccess extends Eloquent {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_demo_access';

    /**
     * Update (or initially create) user demo access
     * @return true if completed
     */
    public static function updateUserDemoAccess($id, $demoList)
    {
        $success = true;
        // remove previous access
        if ($deleteAffectedRows = self::where('user_id', '=', $id)->delete()) {
            // add new access
            if (is_array($demoList)) {
                foreach ($demoList as $demoId) {
                    $user_demo_access = new self();
                    $user_demo_access->user_id = $id;
                    $user_demo_access->demo_id = $demoId;
                    if (!$user_demo_access->save()) { 
                        $success = false; 
                    }
                }
            }
        } else {
            $success = false;
        }

        return $success;
    }

    /**
     * Make a list of the user's demo access
     * @return array of demo IDs
     */
    public static function accessList($id)
    {
        $list = array();
        $x = 0;
        foreach (self::where('user_id', '=', $id)->get() as $user_demo_access) {
            $list[$x] = $user_demo_access->demo_id;
            $x++;
        }
        return $list;
    }
}
