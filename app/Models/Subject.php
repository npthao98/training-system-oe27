<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'course_id',
        'image',
        'title',
        'time',
        'description',
        'status',
    ];

    public $timestamps = true;

    public function tasks()
    {
        return $this->hasMany(Task::class)
            ->orderBy('id', 'desc');
    }

    public function subjectUsers()
    {
        return $this->hasMany(SubjectUser::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function usersActive()
    {
        return $this->users()->wherePivot('status', config('number.active'))
            ->withPivot(['start_time']);
    }
}
