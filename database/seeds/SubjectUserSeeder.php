<?php

use Illuminate\Database\Seeder;
use App\Models\CourseUser;
use App\Models\Subject;

class SubjectUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $courseUser = CourseUser::all();
        foreach ($courseUser as $i) {
            $subjects = Subject::where('course_id', $i->course_id)->get();
            $dem = 1;
            foreach ($subjects as $s) {
                $start = now()->format('Y-m-d');
                $end = now()->addDays($s->time)->format('Y-m-d');
                if ($i->status == '0') {
                    $status = '0';
                } elseif ($i->status == '1') {
                    if ($dem == 1) {
                        $status = '1';
                        $dem++;
                    } else {
                        $status = '0';
                    }
                } elseif ($i->status == '2') {
                    $status = '2';
                }
                DB::table('subject_user')->insert([
                    [
                        'user_id' => $i->user_id,
                        'subject_id' => $s->id,
                        'start_time' => $start,
                        'end_time' => $end,
                        'status' => $status,
                    ],
                ]);
            }
        }
    }
}
