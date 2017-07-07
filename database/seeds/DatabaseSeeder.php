<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    private $faker;

    public function __construct(Faker\Generator $faker)
    {
        $this->faker = $faker;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('users')->insert([
            'name' => $this->faker->name,
            'twitter_id' => str_random(10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Model::reguard();
    }
}
