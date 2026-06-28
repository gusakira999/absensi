<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\Fillable;

// Menggunakan PHP Attributes agar seragam dengan User & Course
#[Fillable([
    'schedule_id', 
    'user_id', 
    'status',        // 'Hadir', 'Izin', 'Sakit', 'Alpa'
    'device_info',   // Untuk validasi device mahasiswa (keamanan)
    'latitude',      // Geolocation koordinat X
    'longitude',     // Geolocation koordinat Y
    'scanned_at'     // Waktu presensi dilakukan
])]
class Attendance extends Model
{
    /**
     * Relasi: Catatan presensi ini merujuk ke Jadwal Kuliah tertentu
     */
    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }

    /**
     * Relasi: Catatan presensi ini dicatat atas nama Mahasiswa (User) tertentu
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}