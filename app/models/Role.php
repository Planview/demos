<?php

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    /**
     * Make a list for options in a select
     * @return array All roles keyed as id => name
     */
    public static function optionsList()
    {
        $list = array();
        //foreach (self::all() as $role) {
        foreach (self::orderBy('name', 'asc')->get() as $role) {
            $list[$role->id] = $role->name;
        }
        return $list;
    }
    /**
     * Get all permissions by id that are associated to a given role
     * @return array Array of id's for a role's permissions
     */
    public function permissionsById()
    {
        $permissionsById = array();
        foreach ($this->perms as $permission) {
            $permissionsById[] = $permission->id;
        }
        return $permissionsById;
    }
}

/*
The Role model has two main attributes: name and permissions. name, as you can imagine, is the name of the Role. For example: "Admin", "Owner", "Employee". The permissions field has been deprecated in preference for the permission table. You should no longer use it. It is an array that is automatically serialized and unserialized when the Model is saved. This array should contain the name of the permissions of the Role. For example: array( "manage_posts", "manage_users", "manage_products" ).
*/
