<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'twitter_id' => $faker->randomNumber
    ];
});

$factory->define(App\Conference::class, function (Faker\Generator $faker) {
    return [
    ];
});

$factory->define(App\Friend::class, function (Faker\Generator $faker) {
    return [
        'username' => $faker->word,
        'type' => 'new'
    ];
});
