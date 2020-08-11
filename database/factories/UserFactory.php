<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Models Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'fullname' => $faker->name,
        'birthday' => $faker->date('Y-m-d', '2000-12-12'),
        'gender' => $faker->randomElement(['male','female']),
        'email' => $faker->unique()->email,
        'avatar' => 'avatar.png',
        'password' => bcrypt('password'),
        'status' => 1,
        'role_id' => $faker->randomElement([1,2]),
    ];
});
