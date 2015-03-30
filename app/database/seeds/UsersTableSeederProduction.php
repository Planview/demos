<?php

class UsersTableSeederProduction extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'username'              => 'pvadmin',
            'email'                 => 'webmaster@planview.com',
            'password'              => 'password',
            'confirmation_code'     => md5(uniqid(mt_rand(), true)),
            'company'               => null,
            'expires'               => null,
            'isr_contact_id'        => null,
            'password_confirmation' => 'password',
            'confirmed'             => 1
        ]);

        $admin->confirm();
    }
}
