<?php

class AssignedRolesTableSeeder extends Seeder {

    public function run()
    {
        $user = Confide::getUserByEmailOrUsername(['email' => 'webmaster@planview.com']);

        $adminRole = Role::where('name', 'Super Admin')->firstOrFail();

        $user->attachRole($adminRole);
    }

}
