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
        foreach ($users as $u) {
            $status = '1';
            for ($i = 1; $i <=10; $i++) {
                if ($i == 1) {
                    $status = '1';
                } else {
                    $status = $faker->randomElement(['0', '2']);
                }
                DB::table('course_user')->insert(
                    [
                        'user_id' => $u,
                        'course_id' => $i,
                        'start_time' => $faker->dateTimeBetween('-20 days','-5 days')->format('Y-m-d'),
                        'end_time' => $faker->dateTimeBetween('-4 days','+20 days')->format('Y-m-d'),
                        'status' => $status,
                    ]
                );
            }
        }
    }
}
