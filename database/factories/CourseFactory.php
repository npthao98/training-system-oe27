<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Course;
use Faker\Generator as Faker;

$factory->define(Course::class, function (Faker $faker) {
    return [
        'title' => $faker->text(50),
        'image' => 'course.png',
        'description' => $faker->text(2000),
        'status' => '1',
    ];
});
