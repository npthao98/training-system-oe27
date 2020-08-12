<?php

use Illuminate\Database\Seeder;
use App\Models\SubjectUser;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $subjectUsers = SubjectUser::all();

        foreach ($subjectUsers as $subjectUser) {
            if ($subjectUser->status != 1) {
                $review = '';
                $status = 1;

                if ($subjectUser->status == 1) {
                    $status = 1;
                    $review = $faker->text(50);
                } elseif ($subjectUser->status == 1) {
                    $status = 1;
                }
                DB::table('tasks')->insert([
                    'plan' => $faker->text(50),
                    'actual' => $faker->text(50),
                    'next_plan' => $faker->text(50),
                    'comment' => $faker->text(50),
                    'review' => $review,
                    'user_id' => $subjectUser->user_id,
                    'subject_id' => $subjectUser->subject_id,
                    'status' => $status,
                    'created_at' => $subjectUser->end_time,
                ]);
            }
        }
    }
}
