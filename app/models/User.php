<?php

use Zizaco\Confide\ConfideUser;
use Zizaco\Confide\ConfideUserInterface;
use Zizaco\Entrust\HasRole;

class User extends Eloquent implements ConfideUserInterface
{
    use ConfideUser, HasRole;

    public function demos()
    {
        // demo_user
        return $this->belongsToMany('Demo', 'user_demo_access');
    }

    public function isrs()
    {
        // isr_user
        return $this->hasMany('Isr');
    }

    /**
     * Create a simple array of the user's roles by id
     */
    public function rolesById()
    {
        $roles = array();
        foreach ($this->roles as $role) {
            $roles[] = $role->id;
        }
        return $roles;
    }

    public static function usersWithPermission($permission)
    {
        $list = array();

        foreach (self::orderBy('email', 'asc')->get() as $user) {
            if ($user->can($permission)) {
                $list[] = $user;
            }
        }
        return $list;
    }

    /**
    * Create a random password
    * @return string password
    */
    public function autoGeneratePassword()
    {
        $length = 8;
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $password = substr(str_shuffle($chars),0,$length);

        $this->password = $password;
        $this->password_confirmation = $password;

        return $password;
    }

    /**
     * Make an options list for a select drop-down form item
     * @return array All ISRs keyed as id => name
     */
    public static function isrList()
    {
        $list = array();
        $isrs = DB::table('isrs')->orderBy('isr_last_name', 'asc')->orderBy('isr_first_name', 'asc')->get();

        foreach ($isrs as $isr) {
            $list[$isr->user_id] = $isr->isr_first_name.' '.$isr->isr_last_name;
        }
        return $list;
    }

    /**
     * Gather ISR-specific information from the db
     * @return object ISR information
     */
    public function isrInfo()
    {
        if (!($isr = DB::table('isrs')->where('user_id', '=', $this->id)->first())) {
            $isr = new Isr();
        }
        return $isr;
    }

    /**
     * Make a list of the user's demo access
     * @return array of demo IDs
     */
    public function demoAccessList()
    {
        $list = array();

        foreach ($this->demos as $demo) {
            $list[] = $demo->id;
        }
        return $list;
    }


}
