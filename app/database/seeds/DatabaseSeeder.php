<?php

class DatabaseSeeder extends Seeder {

    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        Eloquent::unguard();

        $this->call('DemosTableSeeder');
        $this->command->info('Demo table seeded!');

        $this->call('UsersTableSeeder');
        $this->command->info('User table seeded!');

        $this->call('UsersTableSeederProduction');
        $this->command->info('Production User table seeded!');

        $this->call('PermissionsTableSeeder');
        $this->command->info('Permissions table seeded!');

        $this->call('RolesTableSeeder');
        $this->command->info('Roles table seeded!');

        $this->call('PermissionRoleTableSeeder');
        $this->command->info('Permissions are now synced to Roles!');

        $this->call('AssignedRolesTableSeeder');
        $this->command->info('Assigned Roles table seeded!');
    }

}
