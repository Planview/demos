<?php

class PermissionsTableSeeder extends Seeder {

    public function run()
    {
        Eloquent::unguard();
        Permission::create([
            'name'  => 'manage_admins',
            'display_name'  => 'Manage Admins'
        ]);
        Permission::create([
            'name'  => 'manage_clients',
            'display_name'  => 'Manage Clients'
        ]);
        Permission::create([
            'name'  => 'manage_content',
            'display_name'  => 'Manage Content'
        ]);
        Permission::create([
            'name'  => 'manage_isrs',
            'display_name'  => 'Manage ISRs'
        ]);
    }

}
