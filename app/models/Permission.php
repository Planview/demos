<?php

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    /**
     * Generate a list of all permissions for use in a select
     * @return  array   All permissions in id => display_name form
     */
    public static function optionsList()
    {
        $options = array();
        //foreach (self::all() as $permission) {
        foreach (self::orderBy('display_name', 'asc')->get() as $permission) {
            $options[$permission->id] = $permission->display_name;
        }
        return $options;
    }
    /**
     * Get an array of all a permissions roles, just the id
     * @return array The id's of all the roles associated to a permission
     */
    public function rolesById()
    {
        $rolesById = array();
        foreach ($this->roles as $role) {
            $rolesById[] = $role->id;
        }
        return $rolesById;
    }
}

/*
The Permission model has two attributes: name and display_name.
name, as you can imagine, is the name of the Permission.
For example: "Admin", "Owner", "Employee", "can_manage". 
display_name is a viewer friendly version of the permission string. 
"Admin", "Can Manage", "Something Cool".
*/
