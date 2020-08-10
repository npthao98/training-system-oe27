<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Subject;
use Faker\Generator as Faker;

$factory->define(Subject::class, function (Faker $faker) {
    return [
        'title' => $faker->text(50),
        'image' => 'subject.png',
        'description' => $faker->text(2000),
        'time' => 2,
        'course_id' => $faker->numberBetween($min = 1, $max = 10),
        'status' => '1',
    ];
});
