<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\DatabaseNotification;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fullname',
        'birthday',
        'gender',
        'avatar',
        'status',
        'role_id',
        'email',
        'password',
    ];

    public $timestamps = true;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function courseUsers()
    {
        return $this->hasMany(CourseUser::class);
    }

    public function courseUserActive()
    {
        return $this->courseUsers()->where('status', config('number.active'));
    }

    public function courseUsersNotInactive()
    {
        return $this->hasMany(CourseUser::class)
            ->whereIn('status', [config('number.active'), config('number.passed')]);
    }

    public function subjectUsers()
    {
        return $this->hasMany(SubjectUser::class);
    }

    public function subjectUsersNotInactive()
    {
        return $this->hasMany(SubjectUser::class)
            ->whereIn('status', [config('number.active'), config('number.passed')]);
    }

    public function subjectUsersActive()
    {
        return $this->hasMany(SubjectUser::class)
            ->where('status', config('number.active'));
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function coursesNotInActive()
    {
        return $this->courses()
            ->wherePivotIn('status', [config('number.active'), config('number.passed')])
            ->withPivot('start_time', 'status');
    }

    public function subjectsNotInActive()
    {
        return $this->subjects()
            ->wherePivotIn('status', [config('number.active'), config('number.passed')])
            ->withPivot('start_time', 'status');
    }

    public function courseActive()
    {
        return $this->courses()
            ->wherePivot('status', config('number.active'))
            ->withPivot('start_time', 'status');
    }

    public function courseInActive()
    {
        return $this->courses()
            ->wherePivot('status', config('number.inactive'));
    }

    public function subjectActive()
    {
        return $this->subjects()
            ->wherePivot('status', config('number.active'))
            ->withPivot('start_time', 'status');
    }

    public function notifications()
    {
        return $this->morphMany(DatabaseNotification::class, 'notifiable')
            ->orderBy('created_at');
    }
}
