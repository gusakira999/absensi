<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['course_name', 'course_code', 'lecturer', 'semester'])]
class Course extends Model
{
    /**
     * Relasi: Satu Mata Kuliah bisa memiliki beberapa jadwal kelas/pertemuan
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Relasi: Satu Mata Kuliah bisa memiliki beberapa data absensi
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}