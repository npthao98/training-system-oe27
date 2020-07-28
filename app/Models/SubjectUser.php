<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectUser extends Model
{
    protected $table = 'subject_user';

    protected $fillable = [
        'subject_id',
        'user_id',
        'start_time',
        'end_time',
        'status',
    ];

    public $timestamps = true;

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
