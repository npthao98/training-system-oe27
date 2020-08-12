<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class CourseUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $users = User::where('role_id', 1)->pluck('id')->toArray();

        foreach ($users as $user) {
            $status = 1;

            for ($course_id = 1; $course_id <= 10; $course_id++) {
                if ($course_id == 1) {
                    $status = 1;
                } else {
                    $status = $faker->randomElement([0, 2]);
                }
                DB::table('course_user')->insert(
                    [
                        'user_id' => $user,
                        'course_id' => $course_id,
                        'start_time' => $faker->dateTimeBetween('-20 days','-5 days')->format('Y-m-d'),
                        'end_time' => $faker->dateTimeBetween('-4 days','+20 days')->format('Y-m-d'),
                        'status' => $status,
                    ]
                );
            }
        }
    }
}
