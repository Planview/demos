<?php

class PermissionRoleTableSeeder extends Seeder {

    public function run()
    {
        $admin = Role::where('name', 'Admin')->firstOrFail();
        $isrAdmin = Role::where('name', 'ISR Admin')->firstOrFail();
        $superAdmin = Role::where('name', 'Super Admin')->firstOrFail();

        $manageAdmins = Permission::where('name', 'manage_admins')->firstOrFail();
        $manageClients = Permission::where('name', 'manage_clients')->firstOrFail();
        $manageContent = Permission::where('name', 'manage_content')->firstOrFail();
        $manageIsrs = Permission::where('name', 'manage_isrs')->firstOrFail();

        $admin->perms()->sync([
            $manageClients->id,
            $manageIsrs->id,
        ]);
        $isrAdmin->perms()->sync([
            $manageClients->id,
        ]);
        $superAdmin->perms()->sync([
            $manageAdmins->id,
            $manageClients->id,
            $manageContent->id,
            $manageIsrs->id,
        ]);
    }

}
