<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['course_id', 'user_id', 'day', 'start_time', 'end_time', 'room'])]
class Schedule extends Model
{

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }


    public function lecturerUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}