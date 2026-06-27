<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'attendance_date',
        'status',
        'check_in_time',
    ];
}
