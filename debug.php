<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Course;
use Illuminate\Support\Facades\DB;

echo "\n=== CEK DATA COURSES ===\n\n";

// Cek raw di database
$count = DB::table('courses')->count();
echo "✓ Total courses di DB: $count\n";

if ($count > 0) {
    echo "\nData yang ada:\n";
    DB::table('courses')->get()->each(function($c, $i) {
        echo ($i+1) . ". {$c->course_name} ({$c->course_code})\n";
    });
}

// Cek via Eloquent
echo "\n✓ Lewat Model Course:\n";
$courses = Course::get();
echo "Total: " . count($courses) . "\n";

if (count($courses) > 0) {
    $courses->each(function($c) {
        echo "- {$c->course_name}\n";
    });
}
?>
