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
        foreach ($subjectUsers as $i) {
            if ($i->status != '0') {
                $review = '';
                $status = '0';
                if ($i->status == '2') {
                    $status = '1';
                    $review = $faker->text(50);
                } elseif ($i->status == '1') {
                    $status = '0';
                }
                DB::table('tasks')->insert([
                    'plan' => $faker->text(50),
                    'actual' => $faker->text(50),
                    'next_plan' => $faker->text(50),
                    'comment' => $faker->text(50),
                    'review' => $review,
                    'user_id' => $i->user_id,
                    'subject_id' => $i->subject_id,
                    'status' => $status,
                    'created_at' => $i->end_time,
                ]);
            }
        }
    }
}
