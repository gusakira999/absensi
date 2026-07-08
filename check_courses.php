<?php
require 'bootstrap/app.php';

use App\Models\Course;

$courses = Course::all();
echo "Total courses: " . count($courses) . PHP_EOL;

if (count($courses) > 0) {
    echo "\nDaftar Mata Kuliah:\n";
    foreach ($courses as $course) {
        echo "- {$course->course_name} ({$course->course_code}) - {$course->lecturer}\n";
    }
} else {
    echo "❌ Tidak ada data mata kuliah di database\n";
}
?>
