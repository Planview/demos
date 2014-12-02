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

		foreach (range(1,10) as $index) {
			Demo::create(array(
					"title" => $faker->sentence(), "description" => $faker->paragraph()
				));
		}
	}

}
