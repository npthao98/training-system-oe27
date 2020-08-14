<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'title',
        'image',
        'description',
        'status',
    ];

    public $timestamps = true;

    public function courseUsers()
    {
        return $this->hasMany(CourseUser::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function traineesActive()
    {
        return $this->users()
            ->wherePivot('status', config('number.active'));
    }

    public function subjectTasks()
    {
        return $this->hasManyThrough(Task::class, Subject::class);
    }
}
