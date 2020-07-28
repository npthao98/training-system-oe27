<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'title',
        'image',
        'description',
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
}
