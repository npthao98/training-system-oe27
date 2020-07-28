<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseUser extends Model
{
    protected $table = 'course_user';

    protected $fillable = [
        'course_id',
        'user_id',
        'status',
        'start_time',
        'end_time',
    ];

    public $timestamps = true;

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
