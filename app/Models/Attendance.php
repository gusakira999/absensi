<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\Fillable;

// Menggunakan PHP Attributes agar seragam dengan User & Course
#[Fillable([
    'user_id', 
    'course_id',
    'attendance_date',
    'status',        // 'hadir', 'izin', 'sakit', 'alpha'
    'check_in_time'  // Waktu presensi dilakukan
])]
class Attendance extends Model
{
    /**
     * Relasi: Catatan presensi ini merujuk ke Course tertentu
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    /**
     * Relasi: Catatan presensi ini dicatat atas nama Mahasiswa (User) tertentu
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}