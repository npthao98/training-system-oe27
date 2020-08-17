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
            if ($subjectUser->status != config('number.inactive')) {
                $review = '';
                $status = config('number.task.new');

                if ($subjectUser->status == config('number.passed')) {
                    $status = config('number.task.passed');
                    $review = $faker->text(config('number.default_text'));
                } elseif ($subjectUser->status == config('number.active')) {
                    $status = config('number.task.new');
                }
                DB::table('tasks')->insert([
                    'plan' => $faker->text(config('number.default_text')),
                    'actual' => $faker->text(config('number.default_text')),
                    'next_plan' => $faker->text(config('number.default_text')),
                    'comment' => $faker->text(config('number.default_text')),
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
