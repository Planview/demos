<?php

use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $date = date_create("NOW");

        DB::table('users')->delete();

        foreach (range(1,20) as $index) 
        {
            $password =  $faker->phoneNumber;
            $userEmail = $faker->email;
            $company = null;
            $expires = null;
            $isr_contact_id = null;
            if ($index > 10) {
                date_add($date,date_interval_create_from_date_string("15 days"));
                $company = $faker->company;
                $expires = date_format($date,"Y-m-d");
            }

            User::create(array(
                'email'                 => $userEmail,
                'password'              => $password,
                'confirmation_code'     => md5(uniqid(mt_rand(), true)),
                'company'               => $company,
                'expires'               => $expires,
                'isr_contact_id'        => $isr_contact_id,
                'password_confirmation' => $password,
                'confirmed'             => 1
            ));
        }
    }
}
