<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'course_id',
        'day',
        'start_time',
        'end_time',
        'room'
    ];
}
