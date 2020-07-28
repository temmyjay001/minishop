<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        $faker = Faker::create();
     
        foreach (range(1, 10) as $index) {
            DB::table('products')->insert([
                'sku' => $faker->unique()->md5,
                'Name' => $faker->word,
                'price' =>  $faker->numberBetween($min = 1, $max = 1000),
                'description' =>  $faker->text,
                'Category' =>  $faker->word,
                'UnitsInStock' =>  $faker->numberBetween($min = 1, $max = 50),
            ]);
        }
    }
}
