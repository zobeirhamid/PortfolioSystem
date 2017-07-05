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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Project::class, function (Faker\Generator $faker) {

    return [
        'title' => $faker->name,
        'description' => $faker->paragraph,
        'website' => $faker->url,
        'sticky' => false
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Tag::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Link::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'fa_logo' => $faker->name,
        'link' => $faker->url
    ];
});
