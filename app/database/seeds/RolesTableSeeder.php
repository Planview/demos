<?php

class RolesTableSeeder extends Seeder {

    public function run()
    {
        Eloquent::unguard();

        Role::create([
            'name'  => 'Admin'
        ]);
        Role::create([
            'name'  => 'ISR Admin'
        ]);
        Role::create([
            'name'  => 'Super Admin'
        ]);
    }

}
