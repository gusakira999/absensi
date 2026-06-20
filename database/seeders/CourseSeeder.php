<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //coba 4 matkul
        Course::create([
            'code' => 'CS101',
            'Name' => 'Rekayasa Perangkat Lunak',
            'sks' => 3,
            'description' => 'Belajar tentang apa itu rekayasa perangkat lunak dan bagaimana cara membuatnya',
        ]);

        Course::create([
            'code' => 'CS102',
            'Name' => 'Metode Numerik',
            'sks' => 3,
            'description' => 'Belajar menghitung dengan metode numerik dengan menggunakan excel',
        ]);

        Course::create([
            'code' => 'CS103',
            'Name' => 'Algoritma dan Pemrograman',
            'sks' => 4,
            'description' => 'Belajar tentang algoritma dan pemrograman dengan menggunakan bahasa pemrograman Phyton',
        ]);

        Course::create([
            'code' => 'CS104',
            'Name' => 'Sistem Operasi',
            'sks' => 3,
            'description' => 'Belajar tentang sistem operasi pada komputer dan bagaimana cara menggunakannya',
        ]);
    }
}
