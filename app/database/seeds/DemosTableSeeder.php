<?php

use Faker\Factory as Faker;

class DemosTableSeeder extends Seeder {

    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        $faker = Faker::create();

        DB::table('demos')->delete();

        foreach (range(1,20) as $index)
        {
            $language = ($index % 3) == 0 ? "Deutsch" : (($index % 5) == 0 ? "UK" : "North America");
            // $enterpriseVersion = ($index % 3) == 0 ? "10.4" : "11";
            $enterpriseVersion = ($index % 2) == 0 ? "11" : "10.4";
            Demo::create(array(
                "title"                 => $faker->catchPhrase(),
                "description"           => $faker->paragraph(), //$faker->realText($faker->numberBetween(10,20))
                "enterprise_version"    => $enterpriseVersion,
                "language"              => $language,
                "demo_code"             => $faker->sentence(),
                "related_content_code"  => $faker->sentence()
            ));
        }
    }
}
